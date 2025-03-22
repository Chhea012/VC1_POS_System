<?php
require_once 'Models/AdminModel.php';

class AdminController extends BaseController {

    private $adminHome;

    public function __construct()
    {
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
    
        // Store the new total money in the database
        $this->adminHome->storeTotalMoney($totalMoney['grand_total']);
    
        // Pass the necessary data to the view
        $this->view('admins/dashboard', [
            'lowStockProducts' => $lowStockProducts,
            'highStockProducts' => $highStockProducts,
            'totalStock' => $totalStock,
            'totalMoney' => $totalMoney,
            'increment' => $increment
        ]);
    }
}


