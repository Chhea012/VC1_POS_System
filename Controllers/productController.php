<?php
require_once 'Models/ProductModel.php';

class productController extends BaseController
{
    private $productManager;

    public function __construct()
    {
        $this->productManager = new ProductManager();
    }

    public function index()
    {
        $itemsPerPage = isset($_GET['items']) ? (int)$_GET['items'] : 10;
        $currentPage  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset       = ($currentPage - 1) * $itemsPerPage;
        $category_id  = isset($_GET['category_id']) && !empty($_GET['category_id']) ? (int)$_GET['category_id'] : null;
        $stock_filter = isset($_GET['stock']) ? $_GET['stock'] : null;
    
        $products = $this->productManager->getAllpage($itemsPerPage, $offset, $category_id, $stock_filter);
        $totalProducts = $this->productManager->getTotalProducts($category_id, $stock_filter);
        $totalPages    = ceil($totalProducts / $itemsPerPage);
        $categories    = $this->productManager->getCategories(); // Fetch categories for dropdown
    
        $salesData = [
            'in_store'  => ['amount' => 500, 'orders' => 56, 'change' => 4.7, 'positive' => true],
            'website'   => ['amount' => 100, 'orders' => 56, 'change' => 2.7, 'positive' => true],
            'affiliate' => ['amount' => 500, 'orders' => 56, 'change' => 3.7, 'positive' => false],
        ];
    
        $this->view('products/productList', [
            'products'     => $products,
            'currentPage'  => $currentPage,
            'itemsPerPage' => $itemsPerPage,
            'totalPages'   => $totalPages,
            'salesData'    => $salesData,
            'categories'   => $categories, // Pass categories to the view
        ]);
    }

    public function create()
    {
        $products = $this->productManager->getAllProducts();
        $categories = $this->productManager->getCategories(); // No parameter needed
    
        $this->view('products/addProduct', [
            'products'   => $products,
            'categories' => $categories,
        ]);
    }
    

    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $title        = trim($_POST['title']);
                $category_id = trim($_POST['category_id']);
                $barcode          = ! empty($_POST['barcode']) ? trim($_POST['barcode']) : null;
                $quantity         = (int) $_POST['quantity'];
                $description      = ! empty($_POST['description']) ? trim($_POST['description']) : null;
                $base_price       = (float) $_POST['base_price'];
                $discounted_price = isset($_POST['discounted_price']) ? (float) $_POST['discounted_price'] : 0;
                $in_stock         = 1; // Default to 1 since all your products are in stock

                $db_image_path = "uploads/default.png";
                if (! empty($_FILES["product_image"]["name"])) {
                    $target_dir = __DIR__ . "/../views/products/uploads/";
                    if (! is_dir($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }
                    $filename      = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES["product_image"]["name"]));
                    $target_file   = $target_dir . $filename;
                    $db_image_path = "uploads/" . $filename;
                    if (! move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                        throw new Exception("Error uploading image: " . $_FILES["product_image"]["error"]);
                    }
                }

                $result = $this->productManager->storeNewProduct(
                    $title, $category_id, $barcode, $quantity,
                    $description, $base_price, $discounted_price,
                    $in_stock, $db_image_path
                );

                if ($result) {
                    $_SESSION['success_message'] = "Product added successfully!";
                    header("Location: /products");
                    exit;
                } else {
                    throw new Exception("Error inserting product into database.");
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                error_log("Store Error: " . $e->getMessage());
                header("Location: /products/create");
                exit;
            }
        }
    }
    public function edit($id)
    {
        $product  = $this->productManager->getProductById($id);
        $products = $this->productManager->getAllProducts();
        $categories = $this->productManager->getCategories(); // Add this line
    
        if (! $product) {
            header("Location: /products");
            exit;
        }
    
        $this->view('products/editProduct', [
            'product'    => $product,
            'categories' => $categories,
        ]);
    }
    

    public function update($product_id)
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        try {
            $title        = trim($_POST['title']);
            $category_id = trim($_POST['category_id']);
            $barcode          = trim($_POST['barcode']);
            $quantity         = (int) $_POST['quantity'];
            $description      = trim($_POST['description']);
            $base_price       = (float) $_POST['base_price'];
            $discounted_price = isset($_POST['discounted_price']) ? (float) $_POST['discounted_price'] : null;
            $in_stock         = isset($_POST['in_stock']) ? 1 : 0;
            $db_image_path    = $_POST['existing_image'] ?? "uploads/default.png";

            if (!empty($_FILES["product_image"]["name"])) {
                $target_dir = __DIR__ . "/../views/products/uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $filename    = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES["product_image"]["name"]));
                $target_file = $target_dir . $filename;
                $db_image_path = "uploads/" . $filename;
                if (!move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                    throw new Exception("Error uploading image.");
                }
            }

            // Use $product_id instead of $id
            if ($this->productManager->updateProduct(
                $product_id, $title, $category_id, $barcode, $quantity,
                $description, $base_price, $discounted_price,
                $in_stock, $db_image_path
            )) {
                header("Location: /products");
                $_SESSION['success_message'] = "Edit Product successfully!";
                exit;
            } else {
                throw new Exception("Error updating product.");
            }
        } catch (Exception $e) {
            error_log("Update Error: " . $e->getMessage());
            echo "<script>alert('" . $e->getMessage() . "');</script>";
        }
    }
}
    // Delete a product
    public function delete($product_id)
    {
        // Perform the deletion
        $this->productManager->delete($product_id);
        
        // Set a success message
        $_SESSION['success_message'] = "Product deleted successfully!";
        
        // Redirect to the product list page
        header("Location: /products");
        exit;
    }
    
    
    public function show($id)
    {
        $product = $this->productManager->getProductById($id);

        if (! $product) {
            header("Location: /products");
            exit;
        }

        $this->view('products/viewProduct', ['product' => $product]);
    }

    public function viewProduct($id)
    {
        $product = $this->productManager->getProductById($id);

        header('Content-Type: application/json');
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Product not found"]);
        }
    }
    public function updateQuantity()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            try {
                $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
                $new_quantity = filter_input(INPUT_POST, 'new_quantity', FILTER_SANITIZE_NUMBER_INT);
    
                if (!$product_id || $new_quantity === null) {
                    throw new Exception("Invalid input data");
                }
    
                // Fetch the current quantity from DB
                $currentProduct = $this->productManager->getProductById($product_id);
                if (!$currentProduct) {
                    throw new Exception("Product not found.");
                }
    
                $current_quantity = (int) $currentProduct['quantity'];
                $updated_quantity = $current_quantity + $new_quantity; // Sum both
    
                $result = $this->productManager->updateProductQuantity($product_id, $updated_quantity);
    
                if ($result) {
                    $_SESSION['success_message'] = "Quantity updated successfully!";
                    header("Location: /products");
                    exit;
                } else {
                    throw new Exception("Error updating quantity.");
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                error_log("Quantity Update Error: " . $e->getMessage());
                header("Location: /products/updateQTY");
                exit;
            }
        }
    }
    
}
