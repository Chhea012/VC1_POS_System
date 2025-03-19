<?php
require_once "Database/Database.php";
$db = new Database();
$conn = $db->getConnection();
class ExportProductDetailModel
{
    private $conn;

    public function __construct()
    {
        // Initialize the database connection
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function getInventory()
    {
    try {
            // Prepare and execute the SQL query
            $query = "SELECT product_id AS id, product_name AS name, price, category_name, quantity
                      FROM products 
                      INNER JOIN categories ON products.category_id = categories.category_id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } catch (PDOException $e) {
            // Handle errors (e.g., log them in a real app)
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
}
}