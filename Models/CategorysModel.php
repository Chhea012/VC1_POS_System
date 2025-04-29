<?php
require_once './Database/Database.php';

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
            $query = "SELECT c.category_id, c.category_name, 
                      COALESCE(SUM(p.quantity), 0) as total_quantity, 
                      COALESCE(SUM(p.price * p.quantity), 0) as Price_Total 
                      FROM categories c 
                      LEFT JOIN products p ON c.category_id = p.category_id 
                      GROUP BY c.category_id, c.category_name";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching categories: " . $e->getMessage());
            return [];
        }
    }

    public function storeCategory($category_name)
    {
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM categories WHERE UPPER(category_name) = UPPER(:category_name)");
            $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Category name already exists.");
            }

            $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (:category_name)");
            $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function updateCategory($category_id, $category_name)
    {
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM categories WHERE UPPER(category_name) = UPPER(:category_name) AND category_id != :category_id");
            $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Category name already exists.");
            }

            $stmt = $conn->prepare("UPDATE categories SET category_name = :category_name WHERE category_id = :category_id");
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
            $result = $stmt->execute();
            if (!$result) {
                error_log("Update Error: " . implode(", ", $stmt->errorInfo()));
            }
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function delete($category_id)
    {
        try {
            $conn = $this->db->getConnection();
            $conn->beginTransaction();

            $stmt = $conn->prepare("DELETE FROM products WHERE category_id = :category_id");
            $stmt->execute(['category_id' => $category_id]);

            $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = :category_id");
            $stmt->execute(['category_id' => $category_id]);

            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollBack();
            error_log("Delete Error: " . $e->getMessage());
            throw new Exception('Error deleting category: ' . $e->getMessage());
        }
    }

    public function importCategories($rows)
    {
        try {
            $conn = $this->db->getConnection();
            $conn->beginTransaction();
            $importedCount = 0;

            $stmt = $conn->prepare("SELECT UPPER(category_name) as category_name FROM categories");
            $stmt->execute();
            $existingCategories = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'category_name');

            foreach ($rows as $row) {
                $category_name = trim($row[0] ?? '');
                if (empty($category_name) || in_array(strtoupper($category_name), $existingCategories)) {
                    continue;
                }

                $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (:category_name)");
                $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $existingCategories[] = strtoupper($category_name);
                    $importedCount++;
                }
            }

            $conn->commit();
            return $importedCount;
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception('Error importing categories: ' . $e->getMessage());
        }
    }
}

class ProductModel
{
    public function getAllProducts()
    {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            $query = "SELECT c.category_id, c.category_name, 
                      COALESCE(SUM(p.quantity), 0) as total_quantity, 
                      COALESCE(SUM(p.price * p.quantity), 0) as Price_Total 
                      FROM categories c 
                      LEFT JOIN products p ON c.category_id = p.category_id 
                      GROUP BY c.category_id, c.category_name";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }
}