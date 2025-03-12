<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Models/add_productModel.php';

class AddProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new AddProductModel(); // Ensure correct class name
    }

    public function index() {
        // Logic to render the product addition page
        $this->view('products/add-p');  // Make sure the view is correctly located
        
    }

    // Method to handle form submission (store new product)
    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $title = trim($_POST['title']);
                $category = trim($_POST['category']);
                $barcode = $_POST['barcode'];
                $quantity = $_POST['quantity'];
                $description = $_POST['description'];
                $base_price = $_POST['base_price'];
                $discounted_price = $_POST['discounted_price'];
                $in_stock = isset($_POST['in_stock']) ? 1 : 0;

                // Handle file upload
                $target_dir = __DIR__ . "/../views/products/uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $filename = basename($_FILES["product_image"]["name"]);
                $filename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $filename);
                $target_file = $target_dir . $filename;
                $db_image_path = "uploads/" . $filename;

                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                    if ($this->productModel->storeNewProduct($title, $category, $barcode, $quantity, $description, $base_price, $discounted_price, $in_stock, $db_image_path)) {
                        $this->redirect('/addproduct');
                        
                    } else {
                        throw new Exception("Error inserting product.");
                    }
                } else {
                    throw new Exception("Error uploading image.");
                }
            } catch (Exception $e) {
                echo "<script>alert('" . $e->getMessage() . "');</script>";
            }
        }
    }
}
