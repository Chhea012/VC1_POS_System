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
        $paymentModes = ['Cash Payment', 'Card Payment']; // Hardcoded
        $this->view('orders/create_order', [
            'selectProduct' => $selectProduct,
            'paymentModes' => $paymentModes
        ]);
    }
        public function qrcode() {

            $this->view('orders/qrmoney');
        }

        public function barcode() {

            $paymentModes = ['Cash Payment', 'Card Payment'];
            $this->view('orders/barcode_order', [
                'paymentModes' => $paymentModes
            ]);

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
        if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
            $orderId = $_GET['order_id'];
            $orderDetails = $this->createOrderModel->getOrderSummary($orderId);
            $order = $this->createOrderModel->getOrderById($orderId);
            $this->view('orders/order_summary', [
                'orderItems' => $orderDetails,
                'payment_mode' => $order['payment_mode'],
                'order_date' => $order['order_date']
            ]);
        } else {
            echo "Order ID is missing or invalid.";
        }
    }
    public function placeOrder() {
        if (!isset($_SESSION['user']['user_id']) || empty($_SESSION['user']['user_id'])) {
            die('Error: User must be logged in to place an order');
        }
    
        $input = $_POST;
    
        if (empty($input) || !isset($input['orderItems'])) {
            die('No order data received');
        }
    
        $orderDetails = json_decode($input['orderItems'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Invalid order data format');
        }
        
        // Check stock availability
        foreach ($orderDetails['items'] as $item) {
            $productId = $this->getProductIdByName($item['productName']);
            $quantity = $item['quantity'];
    
            // Check if product is in stock
            if (!$this->createOrderModel->checkProductStock($productId, $quantity)) {
                $_SESSION['error_orders'] = "Error: Product {$item['productName']} is out of stock or has insufficient stock!";
                header("Location: /orders/create"); 
                exit;
            }
            
        }
    
        $totalAmount = array_sum(array_column($orderDetails['items'], 'totalPrice'));
    
        $orderData = [
            'user_id' => $_SESSION['user']['user_id'],
            'total_amount' => $totalAmount,
            'payment_mode' => $orderDetails['paymentMode'] ?? null,
            'items' => array_map(function ($item) {
                return [
                    'product_id' => $this->getProductIdByName($item['productName']),
                    'quantity' => $item['quantity'],
                    'price' => $item['originalPrice']
                ];
            }, $orderDetails['items'])
        ];
    
        // Validate required fields
        $missingFields = [];
        if (empty($orderData['user_id'])) $missingFields[] = 'user_id';
        if (empty($orderData['total_amount'])) $missingFields[] = 'total_amount';
        if (empty($orderData['items'])) $missingFields[] = 'items';
        if (empty($orderData['payment_mode'])) $missingFields[] = 'payment_mode';
    
        if (!empty($missingFields)) {
            die('Error: Missing required fields - ' . implode(', ', $missingFields));
        }
    
        try {
            $orderId = $this->createOrderModel->saveOrder($orderData);
            if (!$orderId) {
                die('Error: No order ID returned from saveOrder');
            }
            echo "Redirecting with order ID: " . $orderId . "<br>";
            header("Location: /orders/summary?order_id=" . $orderId);
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function getProductByBarcode() {
        header('Content-Type: application/json');
        $barcode = $_GET['barcode'] ?? '';
        if (empty($barcode)) {
            echo json_encode(['error' => 'No barcode provided']);
            exit;
        }
    
        try {
            $product = $this->createOrderModel->getProductByBarcode($barcode);
            echo json_encode($product ?: ['error' => 'Product not found']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
        }
        exit; // Ensure response is sent
    }
    
}