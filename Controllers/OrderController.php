<?php
require_once 'BaseController.php';
require_once 'Models/OrderModel.php'; // Assuming you have this model

class OrderController extends BaseController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel(); // Initialize the model
    }

    public function index() {
        
        $orders = $this->orderModel->getAllOrders();

        $this->view('orders/order_list', ['orders' => $orders]);
    }
    public function show($orderId) {
        // Fetch order details
        $order = $this->orderModel->getOrderById($orderId);
    
        // Fetch order items
        $orderItems = $this->orderModel->getOrderItems($orderId);
    
        if (!$order) {
            die("Order not found."); // Better to use a proper error handling method
        }
    
        // Pass data to the view
        $this->view('orders/order_view', [
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }
    // Delete a product
    public function delete($orderId)
    {
        // Perform the deletion
        $this->orderModel->delete($orderId);
        
        // Set a success message
        $_SESSION['success_message'] = "Order deleted successfully!";
        
        // Redirect to the product list page
        header("Location: /orders");
        exit;
    }

 
}
