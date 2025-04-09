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
        $stmt = $this->db->query("SELECT total_money FROM money_history ORDER BY id DESC LIMIT 1");
        $lastTotal = $stmt->fetchColumn();
    
        if ($total > $lastTotal) {
            $stmt = $this->db->query("INSERT INTO money_history (total_money) VALUES (:total_money)", [
                ':total_money' => $total
            ]);
            return $stmt->rowCount() > 0;
        }
        return false;
    }
    
    public function getPreviousTotalStock() {
        $stmt = $this->db->query("SELECT total FROM stock_history ORDER BY updated_at DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function storeTotalStock($total) {
        $stmt = $this->db->query("SELECT total FROM stock_history ORDER BY id DESC LIMIT 1");
        $lastTotal = $stmt->fetchColumn();
        
        if ($total > $lastTotal) {
            $stmt = $this->db->query("INSERT INTO stock_history (total) VALUES (:total)", [
                ':total' => $total
            ]);
            return $stmt->rowCount() > 0;
        }
        return false;
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

    public function getTotalMoneyOrder() {
        $query = "SELECT SUM(total_price) AS total_Money FROM order_items";
        $stmt = $this->db->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLatestMoneyOrder() {
        $query = "SELECT * FROM order_items ORDER BY order_item_id DESC LIMIT 1";
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

    public function orderDay() {
        $today = new DateTime(); // Dynamic current date
        $startOfWeek = (clone $today)->modify('Monday this week');
        $endOfWeek = (clone $today)->modify('Sunday this week');

        $query = "
            SELECT total_amount, order_date 
            FROM orders 
            WHERE status = 'Already' 
            AND order_date BETWEEN :start_date AND :end_date
        ";
        $stmt = $this->db->query($query, [
            ':start_date' => $startOfWeek->format('Y-m-d 00:00:00'),
            ':end_date' => $endOfWeek->format('Y-m-d 23:59:59')
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function orderDayLastWeek() {
        $today = new DateTime();
        $startOfLastWeek = (clone $today)->modify('Monday last week');
        $endOfLastWeek = (clone $today)->modify('Sunday last week');

        $query = "
            SELECT total_amount, order_date 
            FROM orders 
            WHERE status = 'Already' 
            AND order_date BETWEEN :start_date AND :end_date
        ";
        $stmt = $this->db->query($query, [
            ':start_date' => $startOfLastWeek->format('Y-m-d 00:00:00'),
            ':end_date' => $endOfLastWeek->format('Y-m-d 23:59:59')
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderIncreasePercentage() {
        $today = date('Y-m-d');
        $todayOrders = $this->getTotalOrdersByDate($today);
        $totalOrders = $this->getTotalOrders();

        if ($totalOrders == 0) {
            return 0;
        }

        $orderPercentage = ($todayOrders / $totalOrders) * 100;
        return round($orderPercentage, 2);
    }

    public function getCategoriesOrderedToday() {
        $query = "
            SELECT categories.category_name, SUM(order_items.quantity) AS total_orders
            FROM order_items
            INNER JOIN products ON products.product_id = order_items.product_id
            INNER JOIN categories ON categories.category_id = products.category_id
            GROUP BY categories.category_name
        ";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProfitByDate($date) {
        $sql = "
            SELECT 
                SUM((oi.price - p.cost_product) * oi.quantity) AS total_profit
            FROM 
                order_items oi
            INNER JOIN 
                products p ON p.product_id = oi.product_id
            INNER JOIN 
                orders o ON o.order_id = oi.order_id
            WHERE 
                DATE(o.order_date) = :date
        ";
        $stmt = $this->db->query($sql, ['date' => $date]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_profit'] ?? 0;
    }
    public function getOrderedQuantityByDate($date) {
        $query = "
            SELECT SUM(oi.quantity) AS total_quantity
            FROM order_items oi
            INNER JOIN orders o ON o.order_id = oi.order_id
            WHERE DATE(o.order_date) = :order_date
        ";
        $stmt = $this->db->query($query, ['order_date' => $date]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_quantity'] ?? 0;
    }
    
    public function getTotalMoneyByDate($date) {
        $query = "
            SELECT SUM(oi.price) AS total_money
            FROM order_items oi
            INNER JOIN orders o ON o.order_id = oi.order_id
            WHERE DATE(o.order_date) = :order_date
        ";
        $stmt = $this->db->query($query, ['order_date' => $date]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_money'] ?? 0;
    }
    
    }