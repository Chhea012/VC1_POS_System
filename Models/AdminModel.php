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
        $stmt = $this->db->query("INSERT INTO money_history (total_money) VALUES (:total_money)", [
            ':total_money' => $total
        ]);
        return $stmt->rowCount() > 0;
    }

    // New methods for stock tracking
    public function getPreviousTotalStock() {
        $stmt = $this->db->query("SELECT total FROM stock_history ORDER BY updated_at DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function storeTotalStock($total) {
        $stmt = $this->db->query("INSERT INTO stock_history (total) VALUES (:total)", [
            ':total' => $total
        ]);
        return $stmt->rowCount() > 0;
    }
}