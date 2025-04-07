<?php
require_once './Database/Database.php';

class OrderModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Fetch all orders (unchanged)
    public function getAllOrders() {
        $query = "SELECT o.order_id, o.user_id, o.order_date, o.total_amount, o.payment_mode FROM orders o";
        $stmt = $this->db->query($query);

        if ($stmt === false) {
            echo "Query failed!";
            return [];
        }

        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($orders)) {
            echo "No orders found.";
        }

        return $orders;
    }

    // Fetch top products (new method)
    public function getTopProducts() {
        $query = "SELECT p.product_name, p.image, SUM(oi.quantity) as total_quantity, oi.price,
                         RANK() OVER (ORDER BY SUM(oi.quantity) DESC) as rank
                  FROM order_items oi
                  INNER JOIN products p ON oi.product_id = p.product_id
                  GROUP BY p.product_id, p.product_name, p.image, oi.price
                  HAVING SUM(oi.quantity) >= 20
                  ORDER BY total_quantity DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch order details by order_id (unchanged)
    public function getOrderById($orderId) {
        $query = "SELECT o.total_amount, o.order_date, o.payment_mode
                  FROM orders o
                  WHERE o.order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch order items by order_id (unchanged)
    public function view($orderId) {
        $query = "SELECT p.product_name, p.image, ot.price, o.order_date, o.payment_mode, ot.quantity
                  FROM order_items ot
                  INNER JOIN orders o ON o.order_id = ot.order_id
                  INNER JOIN products p ON ot.product_id = p.product_id
                  WHERE ot.order_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete an order (unchanged)
    public function delete($orderId) {
        try {
            $this->db->beginTransaction();

            $sqlItems = "DELETE FROM order_items WHERE order_id = :order_id";
            $stmtItems = $this->db->prepare($sqlItems);
            $stmtItems->execute([':order_id' => $orderId]);

            $sqlOrder = "DELETE FROM orders WHERE order_id = :order_id";
            $stmtOrder = $this->db->prepare($sqlOrder);
            $stmtOrder->execute([':order_id' => $orderId]);

            $this->db->commit();

            $_SESSION['success_message'] = "Order deleted successfully!";
        } catch (Exception $e) {
            $this->db->rollBack();
            $_SESSION['error_message'] = "Failed to delete order: " . $e->getMessage();
        }

        header("Location: /orders");
        exit;
    }
}
?>