<?php
// translate.php

$translations = [
    'en' => [
        // Sidebar/Navbar
        'dashboard' => 'Dashboard',
        'products' => 'Products',
        'inventory' => 'Inventory',
        'drink' => 'Drink',
        'fastfood' => 'FastFood',
        'freshice' => 'FreshIce',
        'category' => 'Category',
        'orders' => 'Orders',
        'topproductorder' => 'Top Products Ordered',
        'historyorders' => 'History Orders',
        'user' => 'Users',
        'weather' => 'Weather',
        'calendar' => 'Calendar',
        'manage' => 'Manage',

        // Dashboard
        'welcome' => 'WELCOME! 🎉🚀',
        'welcome_message' => 'Boom! You\'ve smashed it with <span class="fw-bold text-success">%ORDER_INCREASE% more orders</span> today. Check your orders now!',
        'income_money' => 'Income Money 💰',
        'view_more' => 'View more',
        'weathertoday' => 'Weather Today ☀️🌧️',
        'profit_money' => 'Profit Money 💰',
        'expenses' => 'Expenses 💰',
        'total_money' => 'Total Money 💰',
        'total_orders' => 'Total Orders',
        'stock' => 'Stock: ',
        'restore' => 'Restore',
        'low_stock' => 'Low Stock',
        'high_stock' => 'High Stock',
        'graphic_sales' => 'Graphic Sales',
        'this_week' => 'This week',
        'last_week' => 'Last week',
        'total_money_order' => 'Total Money Order',
        'quantity_order_this_week' => 'Quantity Order this week',
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        // Added missing keys
        'product_sales' => 'Product Sales 📈',
        'order_statistics' => '📊 Order Statistics',

    ],
    'km' => [
        // Sidebar/Navbar
        'dashboard' => 'ផ្ទាំងគ្រប់គ្រង',
        'products' => 'ផលិតផល',
        'inventory' => 'ស្តុកទំនិញ',
        'drink' => 'ភេសជ្ជៈ',
        'fastfood' => 'អាហាររហ័ស',
        'freshice' => 'ទឹកកកស្រស់',
        'category' => 'ប្រភេទ',
        'orders' => 'ការបញ្ជាទិញ',
        'topproductorder' => 'ផលិតផលលក់ដាច់ជាងគេ',
        'historyorders' => 'ប្រវត្តិការបញ្ជាទិញ',
        'user' => 'អ្នកប្រើប្រាស់',
        'weather' => 'អាកាសធាតុ',
        'calendar' => 'ប្រតិទិន',
        'manage' => 'គ្រប់គ្រង',

        // Dashboard
        'welcome' => 'សូមស្វាគមន៍! 🎉🚀',
        'welcome_message' => 'អស្ចារ្យ! អ្នកបានទទួលជោគជ័យជាមួយ <span class="fw-bold text-success">%ORDER_INCREASE% ការបញ្ជាទិញបន្ថែម</span> ថ្ងៃនេះ។ ពិនិត្យការបញ្ជាទិញរបស់អ្នកឥឡូវនេះ!',
        'income_money' => 'ប្រាក់ចំណូល 💰',
        'view_more' => 'មើលបន្ថែម',
        'weathertoday' => 'អាកាសធាតុថ្ងៃនេះ ☀️🌧️',
        'profit_money' => 'ប្រាក់ចំណេញ 💰',
        'expenses' => 'ចំណាយ 💰',
        'total_money' => 'ប្រាក់សរុប 💰',
        'total_orders' => 'ការបញ្ជាទិញសរុប',
        'stock' => 'ស្តុក: ',
        'restore' => 'ស្តារឡើងវិញ',
        'low_stock' => 'ស្តុកទាប',
        'high_stock' => 'ស្តុកខ្ពស់',
        'graphic_sales' => 'ការលក់ជាក្រាហ្វិក',
        'this_week' => 'សប្តាហ៍នេះ',
        'last_week' => 'សប្តាហ៍មុន',
        'total_money_order' => 'ប្រាក់បញ្ជាទិញសរុប',
        'quantity_order_this_week' => 'បរិមាណបញ្ជាទិញសប្តាហ៍នេះ',
        'today' => 'ថ្ងៃនេះ',
        'yesterday' => 'ម្សិលមិញ',
        // Added missing keys
        'product_sales' => 'ការលក់ផលិតផល 📈',
        'order_statistics' => '📊 ស្ថិតិការបញ្ជាទិញ',

    ]
];

// Output translations as a JavaScript variable
echo '<script>';
echo 'const translations = ' . json_encode($translations) . ';';
echo '</script>';
