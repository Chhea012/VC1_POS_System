<?php
require_once './Database/Database.php';

class OrderModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Fetch all orders
    public function getAllOrders() {
        $query = "SELECT o.order_id, o.user_id, o.order_date, o.total_amount, o.payment_mode FROM orders o";
        $stmt = $this->db->query($query);

        if ($stmt === false) {
            // Handle query failure
            echo "Query failed!";
            return [];
        }

        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // If no orders found, handle accordingly
        if (empty($orders)) {
            echo "No orders found.";
        }

        return $orders;
    }

// Fetch order details by order_id
public function getOrderById($orderId) {
    $query = "SELECT p.product_name, ot.price,o.total_amount, o.order_date, o.payment_mode, ot.quantity
FROM order_items ot
INNER JOIN orders o ON o.order_id = ot.order_id
INNER JOIN products p ON ot.product_id = p.product_id
WHERE ot.order_id = :order_id"; // Correct the syntax here
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT); // Properly bind the parameter
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    // Fetch order items by order_id
// Fetch order items by order_id
public function view($orderId) {
    $query = "SELECT p.product_name, ot.price, o.order_date, o.payment_mode, ot.quantity
              FROM order_items ot
              INNER JOIN orders o ON o.order_id = ot.order_id
              INNER JOIN products p ON ot.product_id = p.product_id
              WHERE ot.order_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$orderId]);

    // Fetch all order items
    $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $orderItems;
}


    // Delete an order
    public function delete($orderId) {
        $sql = "DELETE FROM orders WHERE order_id = :order_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':order_id' => $orderId]);
    }
}
?>


