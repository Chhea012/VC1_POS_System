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
<<<<<<< HEAD
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
=======
     // Fetch and display details of a specific order
     public function show($orderId) {
        $order = $this->orderModel->getOrderById($orderId);
        $orderItems = $this->orderModel->getOrderItemsByOrderId($orderId);
    
        if (!$order) {
            echo "Order not found!";
            return;
        }
    
        $this->view('orders/order_detail', [
>>>>>>> 940848d3e3c6fbc4bbdce2e192f3f240375aa55c
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }
<<<<<<< HEAD
    
=======
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

>>>>>>> 940848d3e3c6fbc4bbdce2e192f3f240375aa55c
 
}
