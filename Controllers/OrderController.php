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
<<<<<<< HEAD
        // Fetch detailed information about the order
    public function detail($orderId) {
        $orderDetails = $this->orderModel->getOrderDetailsById($orderId);
        $orderItems = $this->orderModel->getOrderItemsByOrderId($orderId);

        // Calculate the grand total
        $grandTotal = 0;
        foreach ($orderItems as $item) {
            $grandTotal += $item['total_price'];
        }

        // Return as JSON
        echo json_encode([
            'order_date' => date('d M Y', strtotime($orderDetails['order_date'])),
            'payment_mode' => ucfirst($orderDetails['payment_mode']),
            'order_items' => $orderItems,
            'grand_total' => number_format($grandTotal, 2)
        ]);
        exit;
    }

    
    
}
=======
}
>>>>>>> 5bfeceb066ebc66e30f10384a27add074bd809cd
