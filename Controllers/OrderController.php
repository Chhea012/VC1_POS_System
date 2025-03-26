<?php
require_once 'BaseController.php';
require_once 'Models/OrderModel.php'; // Assuming you have this model

class OrderController extends BaseController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel(); // Initialize the model
    }

    public function index() {
        // Fetch orders from the database
        $orders = $this->orderModel->getAllOrders();

        // Pass the orders data to the view
        $this->view('orders/order_list', [
            'orders' => $orders,
    ]);
    }
    public function show($orderId) {
        $order = $this->orderModel->getOrderById();  
        
        $this->view('orders/order_list', [
            'order' => $order,
            'orderItems' => $orderItems // Ensure this is being passed
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
