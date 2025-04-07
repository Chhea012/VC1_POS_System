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
        $paymentModes = $this->createOrderModel->getPaymentModeOptions();
        $this->view('orders/create_order', [
            'selectProduct' => $selectProduct,
            'paymentModes' => $paymentModes
        ]);
    }

    public function qrcode() {
        $this->view('orders/qrmoney');
    }

    public function barcode() {
        $paymentModes = $this->createOrderModel->getPaymentModeOptions();
        $this->view('orders/barcode_order', [
            'paymentModes' => $paymentModes
        ]);
    }

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
            $orderId = filter_var($_GET['order_id'], FILTER_VALIDATE_INT);
            if ($orderId === false) {
                echo "Invalid Order ID";
                return;
            }
            $orderDetails = $this->createOrderModel->getOrderSummary($orderId);
            $order = $this->createOrderModel->getOrderById($orderId);
            $this->view('orders/order_summary', [
                'orderItems' => $orderDetails,
                'payment_mode' => $order['payment_mode'] ?? '',
                'order_date' => $order['order_date'] ?? ''
            ]);
        } else {
            echo "Order ID is missing or invalid.";
        }
    }

    public function placeOrder() {
        if (!isset($_SESSION['user']['user_id']) || empty($_SESSION['user']['user_id'])) {
            $_SESSION['error_orders'] = 'Error: User must be logged in to place an order';
            header("Location: /orders/create");
            exit;
        }

        if (empty($_POST) || !isset($_POST['orderItems'])) {
            $_SESSION['error_orders'] = 'No order data received';
            header("Location: /orders/create");
            exit;
        }

        $orderDetails = json_decode($_POST['orderItems'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $_SESSION['error_orders'] = 'Invalid order data format: ' . json_last_error_msg();
            header("Location: /orders/create");
            exit;
        }

        if (!isset($orderDetails['paymentMode']) || empty($orderDetails['paymentMode'])) {
            $_SESSION['error_orders'] = 'Payment mode is required';
            header("Location: /orders/create");
            exit;
        }

        foreach ($orderDetails['items'] as $item) {
            $productId = $this->getProductIdByName($item['productName']);
            if (!$this->createOrderModel->checkProductStock($productId, $item['quantity'])) {
                $_SESSION['error_orders'] = "Error: Product {$item['productName']} is out of stock or has insufficient stock!";
                header("Location: /orders/create");
                exit;
            }
        }

        $totalAmount = array_sum(array_column($orderDetails['items'], 'totalPrice'));
        $orderData = [
            'user_id' => $_SESSION['user']['user_id'],
            'total_amount' => $totalAmount,
            'payment_mode' => $orderDetails['paymentMode'],
            'items' => array_map(function ($item) {
                return [
                    'product_id' => $this->getProductIdByName($item['productName']),
                    'quantity' => $item['quantity'],
                    'price' => $item['originalPrice']
                ];
            }, $orderDetails['items'])
        ];

        try {
            $orderId = $this->createOrderModel->saveOrder($orderData);
            header("Location: /orders/summary?order_id=" . $orderId);
            exit;
        } catch (Exception $e) {
            $_SESSION['error_orders'] = "Error: " . $e->getMessage();
            header("Location: /orders/create");
            exit;
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
        exit;
    }
}
?>