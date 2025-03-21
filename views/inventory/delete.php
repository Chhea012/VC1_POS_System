<?php
require_once "Models/drinkModel.php"; // Ensure correct path

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = intval($_GET['id']);

    // Assuming you have a function to delete a product
    $deleted = deleteProduct($productId); // Replace with actual delete logic

    if ($deleted) {
        header("Location: inventory.php?message=Product+deleted+successfully");
        exit;
    } else {
        header("Location: inventory.php?error=Failed+to+delete+product");
        exit;
    }
} else {
    header("Location: inventory.php?error=Invalid+ID");
    exit;
}
?>
