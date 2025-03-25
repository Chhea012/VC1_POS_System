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
        $this->view('orders/order_list', ['orders' => $orders]);
    }
 
}
