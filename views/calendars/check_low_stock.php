<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "Models/iceModel.php"; // Adjust path as needed

function checkLowStockAndNotify() {
    // Fetch products (assuming iceModel.php provides this)
    $products = getProducts(); // Replace with your actual method to fetch products
    $products = $products ?? [];

    // Filter low stock items
    $low_stock_items = array_filter($products, fn($p) => ($p['quantity'] ?? 0) < 5);

    if (!empty($low_stock_items)) {
        $existingEvents = json_decode(localStorageGet('events'), true) ?? [];
        
        foreach ($low_stock_items as $item) {
            $notification = [
                'title' => "Low Stock Alert: " . ($item['product_name'] ?? 'Unknown'),
                'start' => date('Y-m-d'),
                'isRead' => false,
                'timestamp' => date('c'),
                'quantity' => $item['quantity'] ?? 0,
                'product_id' => $item['product_id'] ?? ''
            ];

            // Add notification if it doesn't already exist
            if (!in_array($notification['title'], array_column($existingEvents, 'title'))) {
                $existingEvents[] = $notification;
            }
        }

        // Save to localStorage via JavaScript (we'll trigger this in the next step)
        echo "<script>localStorage.setItem('events', '" . json_encode($existingEvents) . "');</script>";
    }

    return $low_stock_items;
}

// Helper function to simulate localStorage access in PHP (you'll need JS for actual storage)
function localStorageGet($key) {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null; // Fallback to session for server-side
}

// Call this function on every page load
$low_stock_items = checkLowStockAndNotify();
?>