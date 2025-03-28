<?php
require_once 'Database/Database.php';
require_once 'models/ImportExcelModel.php'; // Include the correct model
require_once 'vendor/autoload.php'; // Use Composer autoloader for PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportExcelController {
    private $importExcelModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        if (!$this->db) {
            throw new Exception("Database connection failed.");
        }
        // Fix the instantiation: Use ImportExcelModel, not ImportExcelController
        $this->importExcelModel = new ImportExcelModel();
    }

    public function showImportForm() {
        // Fetch data for the view
        $categories = $this->importExcelModel->getCategories();
        $products = $this->importExcelModel->getProducts();
        $itemsPerPage = isset($_GET['items']) ? (int)$_GET['items'] : 10; // Default to 10 items per page
        include 'views/products/uploads/productList.php';
    }

    public function importExcel() {
        if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] === 0) {
            $filePath = $_FILES['excel_file']['tmp_name'];

            try {
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                // Validate that the Excel file has data (excluding the header row)
                if (count($rows) <= 1) {
                    $_SESSION['error'] = "The Excel file is empty or contains only headers.";
                    header("Location: /products/productList");
                    exit;
                }

                $importedCount = 0;
                // Skip the header row (first row)
                foreach (array_slice($rows, 1) as $row) {
                    // Map the Excel columns based on the table structure
                    // Expected Excel format: # | PRODUCT | CATEGORY | STOCK | PRICE | QTY | TOTAL-PRICE
                    $index = $row[0]; // # (not used in DB)
                    $product_name = $row[1]; // PRODUCT
                    $category_name = $row[2]; // CATEGORY (e.g., "NOODLE", "DRINKS")
                    $stock = $row[3]; // STOCK (e.g., "High stock", "Low stock", but we'll recalculate)
                    $price = $row[4]; // PRICE (e.g., $0.75)
                    $qty = $row[5]; // QTY (e.g., 10)
                    $total_price = $row[6]; // TOTAL-PRICE (e.g., $7.50, but we'll recalculate)

                    // Validate required fields
                    if (empty($product_name) || empty($category_name) || !is_numeric($price) || !is_numeric($qty)) {
                        $_SESSION['error'] = "Invalid data in Excel file. Ensure all required fields (Product, Category, Price, Qty) are filled correctly.";
                        header("Location: /products/productList");
                        exit;
                    }

                    // Clean the price (remove '$' if present)
                    $price = str_replace('$', '', $price);
                    $price = floatval($price);

                    // Convert qty to integer
                    $qty = intval($qty);

                    // Calculate stock status dynamically based on quantity
                    $stock = $qty > 5 ? 'High stock' : 'Low stock';

                    // Calculate total price
                    $total_price = $price * $qty;

                    // Get or create category ID based on category name
                    $category_id = $this->importExcelModel->getOrCreateCategory($category_name);

                    if (!$category_id) {
                        $_SESSION['error'] = "Failed to process category: $category_name.";
                        header("Location: /products/productList");
                        exit;
                    }

                    // Insert the product into the database
                    $this->importExcelModel->insertProduct($product_name, $category_id, $stock, $price, $qty);
                    $importedCount++;
                }

                $_SESSION['success'] = "Successfully imported $importedCount products!";
            } catch (Exception $e) {
                $_SESSION['error'] = "Error processing file: " . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "File upload failed! Please select a valid Excel file.";
        }

        header("Location: /products/productList");
        exit;
    }
}