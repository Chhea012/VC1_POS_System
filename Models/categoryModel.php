<?php
require_once './Database/Database.php';

$db   = new Database();
$conn = $db->getConnection();

class CategoryModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function storeCategory($category_name)
    {
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (:category_name)");
            $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
            return $stmt->execute(); // Insert the category
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
}

class ProductModel
{
    public function getAllProducts()
    {
        $db   = new Database();
        $conn = $db->getConnection();

        // Ensure the category_name field is included in the query
        $stmt = $conn->prepare("SELECT 
    category_name,
    COALESCE(SUM(products.quantity), 0) AS total_quantity,
    COALESCE(SUM(products.price), 0) AS Price_Total
FROM categories 
LEFT JOIN products ON categories.category_id = products.category_id 
GROUP BY categories.category_name;
");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
