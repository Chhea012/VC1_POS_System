<?php
require_once 'BaseController.php';
require_once 'Models/OrderModel.php'; // Assuming you have this model

class OrderController extends BaseController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel(); 

    }

    public function index() {
        // Fetch all orders
        $orders = $this->orderModel->getAllOrders();
    
        // Pass the orders data to the view
        $this->view('orders/order_list', [
            'orders' => $orders
        ]);
    }
    
    public function show($orderId) {
        // Fetch order details
        $order = $this->orderModel->getOrderById($orderId);
    
        // Fetch order items for this order
        $orderItems = $this->orderModel->view($orderId);
    
        // Pass order details and items to the view
        $this->view('orders/view_order', [
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }
    
    // Delete an order
    public function delete($orderId) {
        // Perform the deletion
        $this->orderModel->delete($orderId);
        $this->orderItemModel->deleteByOrderId($orderId);
        
        // Set a success message
        $_SESSION['success_message'] = "Order deleted successfully!";
        
        // Redirect to the orders list page
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
=======
    public function deleteByOrderId($orderId) {
        $sql = "DELETE FROM order_items WHERE order_id = :order_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":order_id", $orderId, PDO::PARAM_INT);
        return $stmt->execute();
>>>>>>> 807f291f62e6374aacfdeafd1accaf1e494db7b3
    }
    
}
<<<<<<< HEAD

=======
?>
>>>>>>> 807f291f62e6374aacfdeafd1accaf1e494db7b3
