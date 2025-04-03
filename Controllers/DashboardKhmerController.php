<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if user is not logged in
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}

// Handle language switching
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language'])) {
    $_SESSION['lang'] = $_POST['language'];
}

// Default language is English
$lang = $_SESSION['lang'] ?? 'en';

// Translation arrays
$translations = [
    'en' => [
        'welcome' => 'WELCOME! 🎉🚀',
        'welcome_msg' => 'Boom! You\'ve smashed it with <span class="fw-bold text-success">{orderIncrease}% more orders</span> today. Check your orders now!',
        'view_orders' => 'View Orders',
        'product_sales' => 'Product Sales 📈',
        'default_products' => 'Default Products 🛒',
        'total_stock' => 'Total Stock 📦',
        'income_money' => 'Income Money 💰',
        'expenses' => 'Expenses 💰',
        'total_money' => 'Total Money 💰',
    ],
    'km' => [
        'welcome' => 'សូមស្វាគមន៍! 🎉🚀',
        'welcome_msg' => 'អស្ចារ្យ! អ្នកបានទទួលការបញ្ជាទិញកើនឡើង <span class="fw-bold text-success">{orderIncrease}%</span> នៅថ្ងៃនេះ។ ពិនិត្យការបញ្ជាទិញរបស់អ្នកឥឡូវនេះ!',
        'view_orders' => 'មើលការបញ្ជាទិញ',
        'product_sales' => 'ការលក់ផលិតផល 📈',
        'default_products' => 'ផលិតផលលំនាំដើម 🛒',
        'total_stock' => 'ស្តុកសរុប 📦',
        'income_money' => 'ប្រាក់ចំណូល 💰',
        'expenses' => 'ចំណាយ 💰',
        'total_money' => 'ប្រាក់សរុប 💰',
    ]
];

// Function to get translated text
function translate($key, $params = [], $translations, $lang) {
    $text = $translations[$lang][$key] ?? $key;
    foreach ($params as $paramKey => $paramValue) {
        $text = str_replace("{" . $paramKey . "}", $paramValue, $text);
    }
    return $text;
}

// Sample data (replace with your actual data logic)
$orderIncrease = 25; // Example value
$totalOrderedQuantity = 150;
$addedStock = 20;
$totalStock = ['total' => 500];
$totalMoneyOrder = 1234.56;
$totalMoney = ['grand_total' => 1500.75];
$increment = 50.25;
$categoriesOrderedToday = [
    ['category_name' => 'Electronics', 'total_orders' => 50],
    ['category_name' => 'Clothing', 'total_orders' => 30],
];
$lowStockProducts = [
    ['product_name' => 'Phone', 'quantity' => 5, 'image' => 'phone.jpg'],
];
$highStockProducts = [
    ['product_name' => 'Laptop', 'quantity' => 100, 'image' => 'laptop.jpg'],
];

// Prepare data for the view
$data = [
    'lang' => $lang,
    'translations' => $translations,
    'orderIncrease' => $orderIncrease,
    'totalOrderedQuantity' => $totalOrderedQuantity,
    'addedStock' => $addedStock,
    'totalStock' => $totalStock,
    'totalMoneyOrder' => $totalMoneyOrder,
    'totalMoney' => $totalMoney,
    'increment' => $increment,
    'categoriesOrderedToday' => $categoriesOrderedToday,
    'lowStockProducts' => $lowStockProducts,
    'highStockProducts' => $highStockProducts,
    'translate' => function ($key, $params = []) use ($translations, $lang) {
        return translate($key, $params, $translations, $lang);
    }
];

// Load the view and pass the data
// require_once "views/admins/dashboard.php";
?>
