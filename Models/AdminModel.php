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
    
}





