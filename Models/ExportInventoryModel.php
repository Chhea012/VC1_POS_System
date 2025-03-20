<?php
require_once "Database/Database.php";
$db = new Database();
$conn = $db->getConnection();
class ExportInventoryModel
{
    private $conn;

    public function __construct()
    {
        // Initialize the database connection
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function getInventory($category_id)
    {
        try {
            // Prepare and execute the SQL query
            $query = "SELECT product_id AS id, product_name AS name, price, category_name, quantity
                      FROM products 
                      INNER JOIN inventory ON inventory.category_id = inventory.category_id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            // Fetch all products as an associative array
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $products ?: [];
        } catch (PDOException $e) {
            // Handle errors (e.g., log them in a real app)
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }
}
