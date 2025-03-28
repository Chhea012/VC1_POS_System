<?php
require_once 'Database/Database.php';

class ImportExcelModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getCategories() {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProducts() {
        $stmt = $this->db->query("SELECT p.*, c.category_name 
                                 FROM products p 
                                 LEFT JOIN categories c ON p.category_id = c.category_id");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as &$product) {
            $product['stock_status'] = $product['quantity'] > 5 ? 'High stock' : 'Low stock';
            $product['total_price'] = $product['price'] * $product['quantity'];
        }

        return $products;
    }

    public function getOrCreateCategory($category_name) {
        $stmt = $this->db->prepare("SELECT category_id FROM categories WHERE category_name = ?");
        $stmt->execute([$category_name]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($category) {
            return $category['category_id'];
        }

        $stmt = $this->db->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->execute([$category_name]);
        return $this->db->lastInsertId();
    }

    public function insertProduct($product_name, $category_id, $in_stock, $price, $quantity) {
        $total_price = $price * $quantity;
        $sql = "INSERT INTO products (product_name, category_id, in_stock, price, quantity, total_price) 
                VALUES (:product_name, :category_id, :in_stock, :price, :quantity, :total_price)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':product_name' => $product_name,
            ':category_id' => $category_id,
            ':in_stock' => $in_stock,
            ':price' => $price,
            ':quantity' => $quantity, // Fixed the parameter name to match the SQL
            ':total_price' => $total_price
        ]);
    }
}