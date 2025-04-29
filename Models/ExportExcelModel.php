<?php
require_once './Database/Database.php';

class ProductExport {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getProductsExport() {
        // Query to get products matching import_products.xlsx structure, including image
        $query = "SELECT 
                    p.product_name, 
                    p.description, 
                    c.category_name, 
                    p.price, 
                    p.cost_product, 
                    p.quantity, 
                    p.image, 
                    p.barcode
                  FROM products p
                  INNER JOIN categories c ON p.category_id = c.category_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>