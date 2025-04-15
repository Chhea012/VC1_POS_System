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
    public function getCategoryByID($id)
    {
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("SELECT * FROM categories WHERE category_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching category by ID: " . $e->getMessage());
            return false;
        }
    }
    public function getAllCategories()
    {
        try {
            $conn = $this->db->getConnection();
            // Test the connection
            $testStmt = $conn->query("SELECT 1");
            error_log("Test query result: " . print_r($testStmt->fetchAll(), true));

            $query = "SELECT c.category_id, c.category_name, 
                      COALESCE(SUM(p.quantity), 0) as total_quantity, 
                      COALESCE(SUM(p.price * p.quantity), 0) as Price_Total 
                      FROM categories c 
                      LEFT JOIN products p ON c.category_id = p.category_id 
                      GROUP BY c.category_id, c.category_name";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            error_log("getAllCategories result: " . print_r($result, true));
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error fetching categories: " . $e->getMessage());
            return [];
        }
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

    public function updateCategory($category_id, $category_name)
    {
        try {
            $stmt = $this->db->getConnection()->prepare("
                UPDATE categories SET 
                    category_name = :category_name
                WHERE category_id = :category_id
            ");
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindParam(':category_name', $category_name);

            $result = $stmt->execute();
            if (!$result) {
                error_log("Update Error: " . implode(", ", $stmt->errorInfo()));
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Update Error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($category_id)
    {
        try {
            $conn = $this->db->getConnection();
            $sql = "DELETE FROM products WHERE category_id = :category_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['category_id' => $category_id]);

            $sql = "DELETE FROM categories WHERE category_id = :category_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['category_id' => $category_id]);
        } catch (PDOException $e) {
            error_log("Delete Error: " . $e->getMessage());
            throw new Exception('Error deleting category: ' . $e->getMessage());
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
        $stmt = $conn->prepare("SELECT c.category_id, c.category_name, 
       COALESCE(SUM(p.quantity), 0) as total_quantity, 
       COALESCE(SUM(p.price * p.quantity), 0) as Price_Total 
FROM categories c 
LEFT JOIN products p ON c.category_id = p.category_id 
GROUP BY c.category_id, c.category_name;
");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

