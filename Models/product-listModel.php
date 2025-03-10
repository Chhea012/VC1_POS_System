<?php
require_once './Database/Database.php';

$db = new Database();
$conn = $db->getConnection();

// Get the total count of products for pagination
$countSql = "SELECT COUNT(*) FROM products";
$countStmt = $conn->prepare($countSql);
$countStmt->execute();
$totalProducts = $countStmt->fetchColumn();

$currentPage = $_GET['page'] ?? 1;
$itemsPerPage = $_GET['items'] ?? 10;
$totalPages = ceil($totalProducts / $itemsPerPage);
$startIndex = ($currentPage - 1) * $itemsPerPage;

// Fetch products from the database with pagination
$sql = "SELECT p.*, c.category_name FROM products p 
        JOIN categories c ON p.category_id = c.category_id 
        LIMIT :startIndex, :itemsPerPage";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
$stmt->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sample data for demonstration
$salesData = [
    'in_store' => [
        'amount' => 500,
        'orders' => 56,
        'change' => 4.7,
        'positive' => true
    ],
    'website' => [
        'amount' => 100,
        'orders' => 56,
        'change' => 2.7,
        'positive' => true
    ],
    'affiliate' => [
        'amount' => 500,
        'orders' => 56,
        'change' => 3.7,
        'positive' => false
    ]
];
?>