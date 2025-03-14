<?php
// delete_product.php

// Database configuration
$host = 'localhost';
$dbname = 'your_database';
$username = 'your_username';
$password = 'your_password';

try {
    // Database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $productId = $_GET['id'];
        
        // Prepare and execute delete query
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$productId]);

        $message = $stmt->rowCount() > 0 ? "Product deleted successfully" : "Product not found";
        $alertType = $stmt->rowCount() > 0 ? "success" : "warning";
    } else {
        $message = "Invalid product ID";
        $alertType = "danger";
    }
} catch (PDOException $e) {
    $message = "Error deleting product: " . $e->getMessage();
    $alertType = "danger";
}

// Redirect back with message
header("Location: products.php?message=" . urlencode($message) . "&type=" . $alertType);
exit();
?>