<?php

require_once './Database/Database.php';


class adminHome {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Create an instance of the Database class
    }

    public function getLowStockProducts() {
        // Query to fetch products with quantity less than 5 (Low stock)
        $query = "SELECT image, product_name, quantity FROM products WHERE quantity < 5";
        
        // Execute the query and fetch results
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // ✅ Fetch all results
    }

    public function getHighStockProducts() {
        // Query to fetch products with quantity greater than 5 (High stock)
        $query = "SELECT image, product_name, quantity FROM products WHERE quantity > 5";
        
        // Execute the query and fetch results
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // ✅ Fetch all results
    }

    public function totalProduct(){
        $query = "SELECT SUM(products.quantity) AS total FROM products";
    
        $stmt = $this->db->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch only one row
    }

    public function sumTotalMoney() { 
        $query = "SELECT SUM(price * quantity) AS grand_total FROM products";
        $stmt = $this->db->query($query); // Use query() since there's no parameter
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function getPreviousTotalMoney() {
        // Use the query() method since it already handles prepare() and execute()
        $stmt = $this->db->query("SELECT total_money FROM money_history ORDER BY updated_at DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function storeTotalMoney($total) {
        // Using query() which already takes care of prepare()
        $stmt = $this->db->query("INSERT INTO money_history (total_money) VALUES (:total_money)", [
            ':total_money' => $total
        ]);
        return $stmt->rowCount() > 0;  // Return true if the insert was successful
    }
    
    
    
}





