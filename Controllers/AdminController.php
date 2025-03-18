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

        // Pass both the low and high stock products to the view
        $this->view('admins/dashboard', [
            'lowStockProducts' => $lowStockProducts,
            'highStockProducts' => $highStockProducts
        ]);

    }
}


