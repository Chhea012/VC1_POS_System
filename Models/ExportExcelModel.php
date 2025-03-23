<?php

require_once './Database/Database.php';

$db = new Database();
$conn = $db->getConnection();

class ProductExport {
    private $db;

    public function __construct() {
        // Assuming the Database class provides the connection
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getProductsExport() {
        // Query to get products from the database
        $query = "SELECT product_id AS id, product_name AS name, price, category_name, quantity
                  FROM products 
                  INNER JOIN categories ON products.category_id = categories.category_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
