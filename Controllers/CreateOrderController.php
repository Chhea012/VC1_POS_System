<?php
require_once 'BaseController.php';
require_once 'Models/CreateOrderModel.php';

class CreateOrderController extends BaseController {
    private $createOrderModel;

    public function __construct() {
        $this->createOrderModel = new CreateOrderModel();
    }

    public function index() {
        $selectProduct = $this->createOrderModel->selectProductName();
        $this->view('orders/create_order', ['selectProduct' => $selectProduct]);
       
    }
        public function qrcode() {

            $this->view('orders/qrmoney');
        }
    

    public function placeOrder() {
        $input = $_POST;

        if (empty($input) || !isset($input['orderItems'])) {
            die('No order data received');
        }

        // Parse the JSON from orderItems
        $orderDetails = json_decode($input['orderItems'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Invalid order data format');
        }

        // Calculate total_amount from items
        $totalAmount = array_sum(array_column($orderDetails['items'], 'totalPrice'));

        // Structure orderData for the model
        $orderData = [
            'user_id' => $_SESSION['user']['user_id'] ?? null, // Assuming user_id is in session
            'total_amount' => $totalAmount,
            'items' => array_map(function ($item) {
                return [
                    'product_id' => $this->getProductIdByName($item['productName']), // Map productName to product_id
                    'quantity' => $item['quantity'],
                    'price' => $item['originalPrice'] // Use original price before discount
                ];
            }, $orderDetails['items'])
        ];

        try {
            $orderId = $this->createOrderModel->saveOrder($orderData);
            header("Location: /orders/summary?order_id=" . $orderId); // Redirect to summary
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Helper method to map product name to ID
    private function getProductIdByName($productName) {
        $products = $this->createOrderModel->selectProductName();
        foreach ($products as $product) {
            if ($product['product_name'] === $productName) {
                return $product['product_id'];
            }
        }
        throw new Exception("Product not found: " . $productName);
    }

    public function summary() {
        if (isset($_GET['order_id'])) {
            $orderId = $_GET['order_id'];
            
            // Fetch order details, including payment_mode and order_date
            $orderDetails = $this->createOrderModel->getOrderSummary($orderId);
            
            // Fetch the order including order_date and payment_mode
            $order = $this->createOrderModel->getOrderById($orderId);
            
            // Pass order items, payment_mode, and order_date to the view
            $this->view('orders/order_summary', [
                'orderItems' => $orderDetails,
                'payment_mode' => $order['payment_mode'],
                'order_date' => $order['order_date'] // Pass the order date
            ]);
        } else {
            echo "Order ID is missing.";
        }
    }
    
}
?>