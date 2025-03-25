<?php
require_once './Database/Database.php';

class OrderModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    public function getAllOrders() {
        $query = "SELECT o.order_id, o.user_id, o.order_date, o.total_amount, o.payment_mode FROM orders o";
        $stmt = $this->db->query($query);
        
        // Check if query execution is successful and if any orders are returned
        if ($stmt === false) {
            // If the query failed, handle the error
            echo "Query failed!";
            return [];
        }
    
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // If no orders are found, handle accordingly
        if (empty($orders)) {
            echo "No orders found.";
        }
    
        return $orders;
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
    // public function getOrderItemsByOrderId($orderId) {
    //     $query = "SELECT oi.product_name, oi.price, oi.quantity, (oi.price * oi.quantity) AS total 
    //               FROM order_items oi 
    //               WHERE oi.order_id = :order_id";
    //     $stmt = $this->db->prepare($query);
    //     $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    public function getOrderItemsByOrderId($orderId) {
        $query = "SELECT oi.product_name, oi.price, oi.quantity, (oi.price * oi.quantity) AS total_price 
                  FROM order_items oi 
                  WHERE oi.order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Ensure this is an array
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
     //  delete product
     public function delete($orderId) {
        $sql = "DELETE FROM orders WHERE order_id = :order_id";
        $stmt = $this->db->prepare($sql); 
        $stmt->execute(['order_id' => $orderId]); 
    
}
}
?>

