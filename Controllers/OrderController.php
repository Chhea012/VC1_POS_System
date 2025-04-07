<?php
require_once 'BaseController.php';
require_once 'Models/OrderModel.php';

class OrderController extends BaseController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    public function index() {
        $orders = $this->orderModel->getAllOrders();
        $topProducts = $this->orderModel->getTopProducts(); // Fetch top products
        $this->view('orders/order_list', [
            'orders' => $orders,
            'topProducts' => $topProducts // Pass top products to view
        ]);
    }

    public function show($orderId) {
        $order = $this->orderModel->getOrderById($orderId);
        $orderItems = $this->orderModel->view($orderId);

        if (!$order) {
            $_SESSION['error_message'] = "Order not found.";
            header("Location: /orders");
            exit;
        }

        $this->view('orders/view_order', [
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }

    public function delete($orderId) {
        $this->orderModel->delete($orderId);
    }
}
?>