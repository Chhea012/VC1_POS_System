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
        $categories    = $this->productManager->getCategories(); 
        $totalStock    = $this->productManager->totalStockproduct(); 
    
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
            'categories'   => $categories,
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
                $cost_price       = (float) $_POST['cost_price'];
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
                    $description, $base_price,$cost_price, $discounted_price,
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
            $cost_price       = (float) $_POST['cost_price'];
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
                $description,$cost_price, $base_price, $discounted_price,
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
        $product = $this->productManager->view($id);

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

    public function import()
{
    if (isset($_FILES['excel_file']['tmp_name'])) {
        try {
            // Validate file type
            $allowed_extensions = ['xlsx', 'xls'];
            $file_extension = strtolower(pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_extensions)) {
                throw new Exception("Invalid file type. Please upload an Excel file (.xlsx or .xls).");
            }

            require_once 'vendor/autoload.php';
            $file = $_FILES['excel_file']['tmp_name'];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
            array_shift($rows);

            // Extract images
            $drawings = $sheet->getDrawingCollection();
            $images = [];
            foreach ($drawings as $drawing) {
                if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing) {
                    $coordinates = $drawing->getCoordinates();
                    $row_number = (int)filter_var($coordinates, FILTER_SANITIZE_NUMBER_INT);
                    $image_data = $drawing->getImageResource();
                    ob_start();
                    imagepng($image_data);
                    $image_binary = ob_get_clean();
                    $images[$row_number] = $image_binary;
                    error_log("Image found for row $row_number: $coordinates");
                }
            }

            $skipped_rows = [];
            $imported_count = 0;

            foreach ($rows as $index => $row) {
                $product_name = trim($row[0] ?? '');
                $description = trim($row[1] ?? '');
                $category_name = trim($row[2] ?? '');
                $price = (float)($row[3] ?? 0); // Column D (2D)
                $cost_product = (float)($row[4] ?? 0); // Column E (2E)
                $quantity = intval(trim($row[5] ?? '0')); // Column F (2F)
                $barcode = trim($row[7] ?? ''); // Column H (2H)

                error_log("Processing row " . ($index + 2) . ": " . json_encode($row));
                error_log("Quantity for product '$product_name': $quantity");
                error_log("Cost product for product '$product_name': $cost_product");
                error_log("Price for product '$product_name': $price");

                $category_id = $this->productManager->getCategoryIdByName($category_name);
                if (!$category_id) {
                    if (substr($category_name, -1) !== 's') {
                        $category_id = $this->productManager->getCategoryIdByName($category_name . 's');
                    }
                    if (!$category_id && substr($category_name, -1) === 's') {
                        $category_id = $this->productManager->getCategoryIdByName(substr($category_name, 0, -1));
                    }
                    if (!$category_id) {
                        $skipped_rows[] = "Row " . ($index + 2) . ": Category '$category_name' not found";
                        error_log("Skipped row " . ($index + 2) . ": Category '$category_name' not found");
                        continue;
                    }
                }

                $db_image_path = "uploads/default.png";
                $row_number = $index + 2;
                if (isset($images[$row_number])) {
                    $target_dir = __DIR__ . "/../views/products/uploads/";
                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }
                    $filename = strtolower(str_replace(' ', '_', $product_name)) . '_' . time() . '.png';
                    $target_file = $target_dir . $filename;
                    $db_image_path = "uploads/" . $filename;
                    if (!file_put_contents($target_file, $images[$row_number])) {
                        error_log("Failed to save image for row $row_number: $target_file");
                        $db_image_path = "uploads/default.png";
                    }
                } else {
                    error_log("No image found for row $row_number");
                }

                $result = $this->productManager->storeNewProduct(
                    $product_name,
                    $category_id,
                    $barcode,
                    $quantity,
                    $description,
                    $cost_product,
                    $price,
                    0,
                    1,
                    $db_image_path
                );

                if ($result) {
                    $imported_count++;
                    error_log("Successfully imported product '$product_name' at row " . ($index + 2));
                } else {
                    $skipped_rows[] = "Row " . ($index + 2) . ": Failed to insert product '$product_name'";
                    error_log("Skipped row " . ($index + 2) . ": Failed to insert product '$product_name'");
                }
            }

            $message = "Imported $imported_count products successfully!";
            if (!empty($skipped_rows)) {
                $message .= "<br>Skipped rows:<br>" . implode("<br>", $skipped_rows);
            }
            $_SESSION['success_message'] = $message;
            header("Location: /products");
            exit();
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error importing products: " . $e->getMessage();
            error_log("Import Error: " . $e->getMessage());
            header("Location: /products");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "No file uploaded.";
        header("Location: /products");
        exit();
    }
}
}
