<?php
require_once './Database/Database.php';

class CreateOrderModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection(); // Get the PDO instance
    }

    public function selectProductName() {
        $query = "SELECT product_id, product_name, price FROM products";
        $stmt = $this->db->query($query); // Now $this->db is PDO, so query() works directly
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveOrder($orderData) {
        if (!is_array($orderData)) {
            throw new Exception('orderData must be an array, received: ' . gettype($orderData));
        }

        // Use PDO directly
        $this->db->beginTransaction();
        
        try {
            // Validate input data
            if (!isset($orderData['user_id']) || !isset($orderData['total_amount']) || !isset($orderData['items'])) {
                throw new Exception('Missing required order data');
            }
            
            if (!is_array($orderData['items']) || empty($orderData['items'])) {
                throw new Exception('Order must contain at least one item');
            }

            // Insert order
            $query = "INSERT INTO orders (
                user_id, 
                total_amount,
                order_date,
                status
            ) VALUES (
                :user_id, 
                :total_amount,
                NOW(),
                'Pending'
            )";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $orderData['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':total_amount', $orderData['total_amount'], PDO::PARAM_STR);
            $stmt->execute();
            
            $orderId = $this->db->lastInsertId();
            
            // Prepare order items insert
            $query = "INSERT INTO order_items (
                order_id, 
                product_id, 
                quantity, 
                price, 
                total_price
            ) VALUES (
                :order_id, 
                :product_id, 
                :quantity, 
                :price, 
                :total_price
            )";
            
            $stmt = $this->db->prepare($query);
            
            $calculatedTotal = 0;
            
            foreach ($orderData['items'] as $item) {
                if (!isset($item['product_id']) || !isset($item['quantity']) || !isset($item['price'])) {
                    throw new Exception('Invalid item data');
                }
                
                $productId = $item['product_id'];
                $quantity = $item['quantity'];
                $price = $item['price'];
                $totalPrice = $price * $quantity;
                $calculatedTotal += $totalPrice;
                
                $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->bindParam(':price', $price, PDO::PARAM_STR);
                $stmt->bindParam(':total_price', $totalPrice, PDO::PARAM_STR);
                $stmt->execute();
            }
            
            // Verify total_amount
            if (round($calculatedTotal, 2) !== round((float)$orderData['total_amount'], 2)) {
                throw new Exception('Total amount mismatch');
            }
            
            $this->db->commit();
            return $orderId;
            
        } catch (Exception $e) {
            $this->db->rollBack();
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
    
}
?>