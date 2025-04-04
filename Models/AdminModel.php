<?php
require_once './Database/Database.php';

class adminHome {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getLowStockProducts() {
        $query = "SELECT image, product_name, quantity FROM products WHERE quantity < 5";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHighStockProducts() {
        $query = "SELECT image, product_name, quantity FROM products WHERE quantity > 5";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalProduct() {
        $query = "SELECT SUM(products.quantity) AS total FROM products";
        $stmt = $this->db->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function sumTotalMoney() { 
        $query = "SELECT SUM(price * quantity) AS grand_total FROM products";
        $stmt = $this->db->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPreviousTotalMoney() {
        $stmt = $this->db->query("SELECT total_money FROM money_history ORDER BY updated_at DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function storeTotalMoney($total) {
        // Get the latest total_money from the table
        $stmt = $this->db->query("SELECT total_money FROM money_history ORDER BY id DESC LIMIT 1");
        $lastTotal = $stmt->fetchColumn();
    
        // Insert only if the new total is greater than the last total
        if ($total > $lastTotal) {
            $stmt = $this->db->query("INSERT INTO money_history (total_money) VALUES (:total_money)", [
                ':total_money' => $total
            ]);
            return $stmt->rowCount() > 0;
        }
        return false; // No insertion happened
    }
    
    

    // New methods for stock tracking
    public function getPreviousTotalStock() {
        $stmt = $this->db->query("SELECT total FROM stock_history ORDER BY updated_at DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function storeTotalStock($total) {
        // Get the latest total stock from the table
        $stmt = $this->db->query("SELECT total FROM stock_history ORDER BY id DESC LIMIT 1");
        $lastTotal = $stmt->fetchColumn();
        
        // Insert only if the new total is greater than the last total
        if ($total > $lastTotal) {
            $stmt = $this->db->query("INSERT INTO stock_history (total) VALUES (:total)", [
                ':total' => $total
            ]);
            return $stmt->rowCount() > 0;
        }
    
        return false; // No insertion happened
    }
    

    public function getTotalOrderedQuantity() {
        $query = "SELECT SUM(quantity) AS total_ordered_quantity FROM order_items";
        $stmt = $this->db->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getLatestOrder() {
        $query = "SELECT * FROM orders ORDER BY order_date DESC LIMIT 1";
        $stmt = $this->db->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
// Get total money from orders
public function getTotalMoneyOrder() {
    $query = "SELECT SUM(total_price) AS total_Money FROM order_items";
    $stmt = $this->db->query($query);  // Use query() here
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get the latest money order
public function getLatestMoneyOrder() {
    $query = "SELECT * FROM order_items 
              ORDER BY order_item_id DESC 
              LIMIT 1";
    $stmt = $this->db->query($query);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getTotalOrdersByDate($date) {
    $query = "SELECT COUNT(*) AS total_orders FROM orders WHERE DATE(order_date) = :order_date";
    $stmt = $this->db->query($query, ['order_date' => $date]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_orders'] ?? 0;
}

public function getTotalOrders() {
    $query = "SELECT COUNT(*) AS total_orders FROM orders";
    $stmt = $this->db->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['total_orders'] : 0;
}
public function totalCost() {
    $query = "SELECT SUM(cost_product * quantity) AS Cost_total FROM products";
    $stmt = $this->db->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
public function totalMoneyorder() {
    $query = "SELECT SUM(total_amount) AS Money_order FROM orders";
    $stmt = $this->db->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// Calculate order percentage increase
public function getOrderIncreasePercentage() {
    $today = date('Y-m-d');

    // Get total orders for today
    $todayOrders = $this->getTotalOrdersByDate($today);

    // Get total orders in the system so far
    $totalOrders = $this->getTotalOrders();  // You should create a method for this to get all orders

    // Handle case where there are no orders at all in the system
    if ($totalOrders == 0) {
        return 0; // No orders yet, so no percentage
    }

    // Calculate today's percentage of the total orders
    $orderPercentage = ($todayOrders / $totalOrders) * 100;

    return round($orderPercentage, 2);  // Return the percentage of today's orders
}
    // Fetch the total orders by category
    public function getCategoriesOrderedToday() {
        $query = "
            SELECT categories.category_name, COUNT(order_items.order_id) AS total_orders
            FROM order_items
            INNER JOIN products ON products.product_id = order_items.product_id
            INNER JOIN categories ON categories.category_id = products.category_id
            GROUP BY categories.category_name
        ";

        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

}