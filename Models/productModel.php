<?php
require_once 'Database/Database.php';

class ProductManager
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        if (!$this->db) {
            throw new Exception("Database connection failed.");
        }
    }

    public function getAllpage($limit, $offset, $category_id = null, $stock_filter = null)
    {
        $query = "SELECT p.*, c.category_name
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.category_id
                  WHERE 1=1"; // Use 1=1 to easily append conditions
    
        // Add category filter if provided
        if ($category_id !== null) {
            $query .= " AND p.category_id = :category_id";
        }
    
        // Add stock filter if provided
        if ($stock_filter === 'high') {
            $query .= " AND p.quantity >= 5"; // Adjust threshold as needed
        } elseif ($stock_filter === 'low') {
            $query .= " AND p.quantity <5"; // Adjust threshold as needed
        }
    
        $query .= " ORDER BY p.product_id DESC
                    LIMIT :limit OFFSET :offset";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    
        if ($category_id !== null) {
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all products with category names
    public function getAllProducts()
    {
        $query = "SELECT p.*, c.category_name
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.category_id
                  ORDER BY p.product_id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get total number of products
    public function getTotalProducts()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM products");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    // Get product by ID
    public function getProductById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE product_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCategories($storeId = null)
    {
        $query = "SELECT category_id, category_name FROM categories";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Store a new product
    public function storeNewProduct($title, $category_id, $barcode, $quantity, $description, $base_price, $discounted_price, $in_stock, $image)
    {
        try {
            $sql = "INSERT INTO products (
                        product_name, category_id, barcode, quantity, description, 
                        price, discounted_price, in_stock, image, created_at, updated_at, supplier_id
                    ) VALUES (
                        ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), NULL
                    )";
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $title, $category_id, $barcode, $quantity, $description,
                $base_price, $discounted_price, $in_stock, $image
            ]);
    
            if (!$result) {
                error_log("SQL Error: " . implode(", ", $stmt->errorInfo()));
                return false;
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error storing product: " . $e->getMessage());
            return false;
        }
    }

    // Update an existing product
    public function updateProduct($id, $title, $category_id, $barcode, $quantity, $description, $base_price, $discounted_price, $in_stock, $image_path)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE products SET 
                    product_name = :title, 
                    category_id = :category_id, 
                    barcode = :barcode, 
                    quantity = :quantity, 
                    description = :description, 
                    price = :base_price, 
                    discounted_price = :discounted_price, 
                    in_stock = :in_stock, 
                    image = :image_path,
                    updated_at = NOW()
                WHERE product_id = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT); 
            $stmt->bindParam(':barcode', $barcode);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':base_price', $base_price);
            $stmt->bindParam(':discounted_price', $discounted_price);
            $stmt->bindParam(':in_stock', $in_stock, PDO::PARAM_INT);
            $stmt->bindParam(':image_path', $image_path);

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

    // View a product with category name
    public function view($id)
    {
        $stmt = $this->db->prepare("SELECT p.*, c.category_name 
                                   FROM products p
                                   LEFT JOIN categories c ON p.category_id = c.category_id
                                   WHERE p.product_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
        //  delete product
        public function delete($product_id) {
            $sql = "DELETE FROM products WHERE product_id = :product_id";
            $stmt = $this->db->prepare($sql); // ✅ Correct: Use prepare() instead of query()
            $stmt->execute(['product_id' => $product_id]); // ✅ Pass the parameter separately
        }

        // In ProductManager.php, add this method
public function updateProductQuantity($product_id, $quantity)
{
    try {
        $stmt = $this->db->prepare("
            UPDATE products SET 
                quantity = :quantity,
                updated_at = NOW()
            WHERE product_id = :product_id
        ");
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        
        $result = $stmt->execute();
        if (!$result) {
            error_log("Quantity Update Error: " . implode(", ", $stmt->errorInfo()));
        }
        return $result;
    } catch (PDOException $e) {
        error_log("Quantity Update Error: " . $e->getMessage());
        return false;
    }
}
        
}