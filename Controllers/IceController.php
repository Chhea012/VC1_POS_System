<?php 
class IceController extends BaseController {
private $productManager;
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        if (!$this->db) {
            throw new Exception("Database connection failed.");
        }
        $this->productManager = new ProductManager();
    }
    public function index() {
        $this->view('inventory/ice');
    }
    
    public function delete($product_id) {
        // Check if product exists
        $sql = "SELECT image FROM products WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($product) {
            // Delete product image file if it exists
            $imagePath = __DIR__ . '/../' . $product['image']; // Adjust the path if needed
            if (!empty($product['image']) && file_exists($imagePath)) {
                unlink($imagePath);
            }
    
            // Delete product record
            $sql = "DELETE FROM products WHERE product_id = :product_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['product_id' => $product_id]);
    
            $_SESSION['success_message'] = "Product deleted successfully!";
        } else {
            $_SESSION['error_message'] = "Product not found!";
        }
    
        header("Location: /ice");
        exit;
    }
    
    
    public function show($id)
    {
        $ice = $this->productManager->getProductById($id);

        if (! $ice) {
            header("Location: /ice");
            exit;
        }

        $this->view('inventory/ice', ['ice' => $ice]);
    }
}