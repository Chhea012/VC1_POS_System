<?php
require_once './Database/Database.php';

class OrderModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Fetch all orders from the database
    public function getAllOrders() {
        $query = "SELECT o.order_id, o.user_id, o.order_date, o.total_amount, o.payment_mode FROM orders o";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch order details based on order_id
    public function getOrderById($orderId) {
        $query = "SELECT o.order_id, o.user_id, o.order_date, o.total_amount, o.payment_mode 
                  FROM orders o 
                  WHERE o.order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch order items based on order_id
    public function getOrderItemsByOrderId($orderId) {
        $query = "SELECT oi.product_name, oi.price, oi.quantity, (oi.price * oi.quantity) AS total 
                  FROM order_items oi 
                  WHERE oi.order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($orderId) {
        $query = "SELECT oi.order_item_id, oi.order_id, oi.product_id, oi.quantity, oi.price, 
                     oi.total_price, p.product_name
              FROM order_items oi
              JOIN products p ON oi.product_id = p.product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>

