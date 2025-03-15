<?php

require_once __DIR__ . '/../Database/Database.php';

class AddProductModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // ✅ Fetch all products (for index method)
    public function getAllProducts()
    {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Store a new product in the database
    public function storeNewProduct($title, $category, $barcode, $quantity, $description, $base_price, $discounted_price, $in_stock, $image)
    {
        // Get category ID
        $category_sql = "SELECT category_id FROM categories WHERE category_name = ?";
        $stmt = $this->conn->prepare($category_sql);
        $stmt->execute([$category]);
        $category_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$category_row) {
            return false; // Category not found
        }

        $category_id = $category_row['category_id'];

        // Insert new product
        $sql = "INSERT INTO products (product_name, category_id, barcode, quantity, description, price, discounted_price, in_stock, image) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $result =$stmt->execute([$title, $category_id, $barcode, $quantity, $description, $base_price, $discounted_price, $in_stock, $image]);
        if ($result) {
            $_SESSION['success_message'] = "Product added successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to add product. Please try again.";
        }

        return $result;
    }
    
    
}
