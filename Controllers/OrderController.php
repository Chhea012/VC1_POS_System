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

        // Pass the orders data to the view
        $this->view('orders/order_list', [
            'orders' => $orders,
    ]);
    }
    public function show($orderId) {
        $order = $this->orderModel->getOrderById($orderId);  
        $orderItems = $this->orderModel->getOrderItemsByOrderId($orderId);
    
        $this->view('orders/order_details', [
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }
       
    // Delete a product
    public function delete($orderId)
    {
        try {
            if ($this->orderModel->delete($orderId)) {
                $_SESSION['success_message'] = "Order deleted successfully!";
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error: " . $e->getMessage();
        }
    
        header("Location: /orders");
        exit;
    }
}
