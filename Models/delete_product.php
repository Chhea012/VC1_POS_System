<?php
require_once "Database/Database.php"; // Ensure database connection

class ProductModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection(); // Get database connection
    }

    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE product_id = ?");
        return $stmt->execute([$id]);
    }
}

?>
