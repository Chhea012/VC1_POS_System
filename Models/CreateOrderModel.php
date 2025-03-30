<?php
require_once './Database/Database.php';

class CreateOrderModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function selectProductName() {
        $query = "SELECT product_id, product_name, price, quantity FROM products";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaymentModeOptions() {
        $query = "SHOW COLUMNS FROM orders LIKE 'payment_mode'";
        $stmt = $this->db->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        preg_match("/^enum\((.*)\)$/", $row['Type'], $matches);
        $enumValues = str_getcsv($matches[1], ',', "'");
        return $enumValues; // Returns ['Cash Payment', 'Card Payment']
    }

    public function saveOrder($orderData) {
        if (!is_array($orderData)) {
            throw new Exception('orderData must be an array, received: ' . gettype($orderData));
        }
    
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
            error_log("Warning: Cleared existing transaction in saveOrder");
        }
    
        $this->db->beginTransaction();
    
        try {
            // Check for missing keys
            if (!isset($orderData['user_id']) || !isset($orderData['total_amount']) || !isset($orderData['items'])) {
                throw new Exception('Missing required order data (user_id, total_amount, or items)');
            }
    
            if (!is_array($orderData['items']) || empty($orderData['items'])) {
                throw new Exception('Order must contain at least one item');
            }
    
            // Validate payment_mode if set, otherwise use default
            $paymentMode = $orderData['payment_mode'] ?? 'Cash Payment'; // Default to Cash Payment
            $validPaymentModes = $this->getPaymentModeOptions();
            if (!in_array($paymentMode, $validPaymentModes)) {
                throw new Exception('Invalid payment mode: ' . $paymentMode);
            }
    
            // Insert the order
            $query = "INSERT INTO orders (
                user_id, 
                total_amount,
                order_date,
                payment_mode
            ) VALUES (
                :user_id, 
                :total_amount,
                NOW(),
                :payment_mode
            )";
    
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $orderData['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':total_amount', $orderData['total_amount'], PDO::PARAM_STR);
            $stmt->bindParam(':payment_mode', $paymentMode, PDO::PARAM_STR);
            $stmt->execute();
    
            // Get the last inserted order ID
            $orderId = $this->db->lastInsertId();
    
            if (!$orderId) {
                throw new Exception('No order ID returned from saveOrder');
            }
    
            // Insert order items
            $itemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
            $itemStmt = $this->db->prepare($itemQuery);
    
            foreach ($orderData['items'] as $item) {
                if (!isset($item['product_id'], $item['quantity'], $item['price'])) {
                    throw new Exception('Missing item details (product_id, quantity, price)');
                }
                $itemStmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
                $itemStmt->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
                $itemStmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
                $itemStmt->bindParam(':price', $item['price'], PDO::PARAM_STR);
                $itemStmt->execute();
            }
    
            // Commit the transaction
            $this->db->commit();
            return $orderId;
    
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw new Exception('Failed to save order: ' . $e->getMessage());
        }
    }
    
    
    public function getOrderSummary($orderId) {
        $query = "SELECT oi.order_item_id, oi.product_id, p.product_name, oi.quantity, oi.price, oi.total_price
                  FROM order_items oi
                  JOIN products p ON oi.product_id = p.product_id
                  WHERE oi.order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($orderId) {
        $query = "SELECT order_date, payment_mode FROM orders WHERE order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the order details including order_date
    }
    
    public function checkProductStock($productId, $quantity) {
        $query = "SELECT quantity FROM products WHERE product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
    
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product && $product['quantity'] >= $quantity) {
            return true; // Sufficient stock
        }
    
        return false; // Insufficient stock
    }
    
}
?>
