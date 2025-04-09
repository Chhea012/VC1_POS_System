<?php
require_once 'Models/AdminModel.php';

class AdminController extends BaseController {
    private $adminHome;

    public function __construct() {
        $this->adminHome = new adminHome();
    }
    
    public function index() {
        // Get Low stock products
        $lowStockProducts = $this->adminHome->getLowStockProducts();
        
        // Get High stock products
        $highStockProducts = $this->adminHome->getHighStockProducts();
        $totalStock = $this->adminHome->totalProduct();
        
        // Get the current total money from the database
        $totalMoney = $this->adminHome->sumTotalMoney();
        
        // Get the previous total from the database
        $previousTotal = $this->adminHome->getPreviousTotalMoney()['total_money'] ?? 0;
        
        // Calculate the increment (difference between new and old totals)
        $increment = $totalMoney['grand_total'] - $previousTotal;
        
        // Calculate added stock by comparing current and previous totals
        $previousStock = $this->adminHome->getPreviousTotalStock()['total'] ?? 0;
        $addedStock = $totalStock['total'] - $previousStock;
        
        // Store the new totals in the database
        $this->adminHome->storeTotalMoney($totalMoney['grand_total']);
        $this->adminHome->storeTotalStock($totalStock['total']);
    
        // Fetch the latest order
        $latestOrder = $this->adminHome->getLatestOrder();
        $totalOrderedQuantity = $this->adminHome->getTotalOrderedQuantity()['total_ordered_quantity'] ?? 0;

        $latestMoneyOrder = $this->adminHome->getLatestMoneyOrder();
        $totalMoneyOrder = $this->adminHome->getTotalMoneyOrder()['total_Money'] ?? 0;

        // Get the previous total money (if any)
        $previousTotalMoney = $this->adminHome->getPreviousTotalMoney()['total_money'] ?? 0;
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        $profitToday = $this->adminHome->getProfitByDate($today);
        $profitYesterday = $this->adminHome->getProfitByDate($yesterday);

        
        // Calculate the sales increment: the difference between current and previous total
        $salesIncrement = $totalMoneyOrder - $previousTotalMoney;
        
        // Optionally, update the money history if the new total is different
        if ($totalMoneyOrder != $previousTotalMoney) {
            $this->adminHome->storeTotalMoney($totalMoneyOrder);
        }
        $categoriesOrderedToday = $this->adminHome->getCategoriesOrderedToday();

        // If no orders exist, set default data
        if (empty($categoriesOrderedToday)) {
            $categoriesOrderedToday = [
                ['category_name' => 'No Orders', 'total_orders' => 1]
            ];
        }

// This week data
$orderDataThisWeek = $this->adminHome->orderDay();
$daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
$dailySumsThisWeek = array_fill_keys($daysOfWeek, 0);
$totalMoneyThisWeek = 0;
foreach ($orderDataThisWeek as $order) {
    $dayName = date('l', strtotime($order['order_date']));
    $dailySumsThisWeek[$dayName] += floatval($order['total_amount']);
    $totalMoneyThisWeek += floatval($order['total_amount']);
}
$jsOrderDataThisWeek = implode(',', array_values($dailySumsThisWeek));

// Last week data
$orderDataLastWeek = $this->adminHome->orderDayLastWeek();
$dailySumsLastWeek = array_fill_keys($daysOfWeek, 0);
$totalMoneyLastWeek = 0;
foreach ($orderDataLastWeek as $order) {
    $dayName = date('l', strtotime($order['order_date']));
    $dailySumsLastWeek[$dayName] += floatval($order['total_amount']);
    $totalMoneyLastWeek += floatval($order['total_amount']);
}
$jsOrderDataLastWeek = implode(',', array_values($dailySumsLastWeek));

        // Get the order increase percentage
        $orderIncrease = $this->adminHome->getOrderIncreasePercentage();
        $totalOrders = $this->adminHome->getTotalOrders();
        $totalCost = $this->adminHome->totalCost()['Cost_total'] ?? 0;
        $totalMoneyorder = $this->adminHome->totalMoneyorder()['Money_order'] ?? 0;
        
    $dateType = $_GET['date'] ?? 'today';
    $date = ($dateType === 'yesterday') 
        ? date('Y-m-d', strtotime('-1 day')) 
        : date('Y-m-d');

    // You can use either or both:
$totalQuantityorder = $this->adminHome->getOrderedQuantityByDate($date);
$totalMoneyor = $this->adminHome->getTotalMoneyByDate($date);

        // Pass the data to the view
        $this->view('admins/dashboard', [
            'lowStockProducts' => $lowStockProducts,
            'totalOrders' => $totalOrders,
            'highStockProducts' => $highStockProducts,
            'totalStock' => $totalStock,
            'totalMoney' => $totalMoney,
            'increment' => $increment,
            'addedStock' => $addedStock,
            'latestOrder' => $latestOrder,
            'totalOrderedQuantity' => $totalOrderedQuantity,
            'latestMoneyOrder' => $latestMoneyOrder,
            'totalMoneyOrder' => $totalMoneyOrder,
            'salesIncrement'  => $salesIncrement,
            'orderIncrease' => $orderIncrease,  
            'categoriesOrderedToday' => $categoriesOrderedToday,
            'totalCost' => $totalCost,
            'totalMoneyorder' => $totalMoneyorder,
            'orderDataThisWeek' => $orderDataThisWeek,
            'jsOrderDataThisWeek' => $jsOrderDataThisWeek,
            'jsOrderDataLastWeek' => $jsOrderDataLastWeek,
            'totalMoneyThisWeek' => $totalMoneyThisWeek,
            'totalMoneyLastWeek' => $totalMoneyLastWeek,
            'profitToday' => $profitToday,
            'profitYesterday' => $profitYesterday,
            'totalQuantityorder' => $totalQuantityorder,
            'totalMoneyor' => $totalMoneyor,
        ]);
    }
}