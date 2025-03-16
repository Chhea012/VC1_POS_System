<?php
require_once __DIR__ . '/../Database/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['barcode'])) {
    $db = new Database();
    $conn = $db->getConnection();
    
    $barcode = trim($_POST['barcode']);

    $stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE barcode = ?");
    $stmt->execute([$barcode]);
    $barcode_count = $stmt->fetchColumn();

    echo ($barcode_count > 0) ? "exists" : "available";
}
?>

