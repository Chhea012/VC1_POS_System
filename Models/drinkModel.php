<?php
require_once 'Database/Database.php';

$db = new Database();
$conn = $db->getConnection();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data
        $title = $_POST['title'];
        $category_name = trim($_POST['category']);
        error_log("Category selected: " . $category_name); // Log the selected category

        $barcode = $_POST['barcode'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'];
        $base_price = $_POST['base_price'];
        $discounted_price = $_POST['discounted_price'];
        $in_stock = isset($_POST['in_stock']) ? 1 : 0;

        // Handle file upload
        // Define the target directory where the image will be stored
        $target_dir = __DIR__ . "/uploads/"; // Ensure you are using the absolute path
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the uploads directory exists; if not, create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create directory with full permissions
        }

        $filename = basename($_FILES["product_image"]["name"]);
        $filename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $filename); // Sanitize filename
        $target_file = $target_dir . $filename; // Full server path
        $db_image_path = "uploads/" . $filename; // Relative path for database
        
        // Validate file type (extension and MIME type)
        $allowed_file_types = ['jpg', 'jpeg', 'png', 'gif'];
        $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($imageFileType, $allowed_file_types)) {
            $error_message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        } else {
            // Check MIME type
            $file_mime_type = mime_content_type($_FILES["product_image"]["tmp_name"]);
            if (!in_array($file_mime_type, $allowed_mime_types)) {
                $error_message = "Uploaded file is not a valid image type.";
            } else {
                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                    // Check if category exists in categories table
                    $category_sql = "SELECT category_id FROM categories WHERE category_name = ?";
                    $stmt = $conn->prepare($category_sql);
                    $stmt->execute([$category_name]);
                    $category = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($category) {
                        $category_id = $category['category_id'];

                        // Insert into products table
                        $sql = "INSERT INTO products (product_name, category_id, barcode, quantity, description, price, discounted_price, in_stock, image) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$title, $category_id, $barcode, $quantity, $description, $base_price, $discounted_price, $in_stock, $db_image_path]);


                        $success_message = "Product added successfully!";
                    } else {
                        $error_message = "Category not found. Please choose a valid category.";
                    }
                } else {
                    $error_message = "Error uploading the image.";
                }
            }
        }
    } catch(PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

// --- New Code to Display Drink Category After Adding ---

// Determine which category to display
$display_category = isset($new_product_category) && $new_product_category === 'drink' ? 'drink' : 'all';

// Fetch products based on category
if ($display_category === 'all') {
    $sql = "SELECT p.*, c.category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.category_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
} else {
    $sql = "SELECT p.*, c.category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.category_id 
            WHERE c.category_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$display_category]);
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <style>
        .products { margin: 20px; }
        .product { border: 1px solid #ccc; padding: 10px; margin: 10px 0; }
        .message { margin: 10px 0; }
    </style>
</head>
<body>
    <!-- Display Success/Error Messages -->
    <?php if (isset($success_message)): ?>
        <p class="message" style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        <p class="message" style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
</body>
</html>



