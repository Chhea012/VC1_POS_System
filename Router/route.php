<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/AdminController.php";
require_once "Controllers/ProductController.php";
require_once "Controllers/ProfileController.php";
require_once "Controllers/SettingSecurityController.php";
require_once "Controllers/ChartController.php";
require_once "Controllers/WeatherController.php";
require_once "Controllers/LoginController.php";
require_once "Controllers/RegisterController.php";
require_once "Controllers/ForgotPasswordController.php";
require_once "Controllers/CategoryController.php";
require_once "Controllers/IceController.php";
require_once "Controllers/DrinkController.php";
require_once "Controllers/FoodController.php";
require_once "Controllers/UserController.php";
require_once "Controllers/CalendarController.php";
require_once "Controllers/GeneratePdfController.php";
require_once "Controllers/OrderController.php";
require_once "Controllers/CreateOrderController.php";
require_once "Controllers/CreateOrderController.php";
require_once "Controllers/NotificationController.php";
require_once "Controllers/ExportExcelController.php";
require_once "Controllers/ExportInventoryController.php";
require_once "Controllers/DashboardKhmerController.php";


// Create an instance of the Router class
$route = new Router();

// GET routes
$route->get("/", [LoginController::class, 'login']);

$route->get("/register", [RegisterController::class, 'register']);
$route->post("/register/store", [RegisterController::class, 'store']);


$route->get("/forgotpassword", [ForgotPasswordController::class, 'forgotpassword']);
$route->get("/dashboard", [AdminController::class, 'index']);

$route->get("/edit_profile", [ProfileController::class, 'index']);

// Profile routes
$route->get("/profile", [ProfileController::class, 'index']); // Profile page
$route->post("/profile/update", [ProfileController::class, 'update']); // Profile update route

$route->get("/setting_security", [SettingSecurityController::class, 'index']);
$route->get("/weather", [WeatherController::class, 'index']);
$route->get("/chart", [ChartController::class, 'index']);
// category route
$route->get("/category", [categoryController::class, 'index']);
$route->post('/category/store', [categoryController::class, 'store']);
$route->get('/category/edit/{category_id}', [categoryController::class, 'edit']);
$route->post('/category/update/{category_id}', [categoryController::class, 'update']);
$route->post('/category/delete/{category_id}', [categoryController::class, 'delete']);
// $route->get("/food", [FoodController::class, 'index']);

$route->post('/checkBarcode', [ProductController::class, 'checkBarcode']);
$route->get("/drink", [InventoryController::class, 'index']);
$route->get("/food", [FoodController::class, 'index']);
$route->get("/ice", [IceController::class, 'index']);
// $route->post('/checkBarcode', [AddProductController::class, 'checkBarcode']);
$route->post('/category/store', [categoryController::class, 'store']);

// -product route -
$route->get("/products", [productController::class, 'index']);
$route->get("/products/create", [productController::class, 'create']);
$route->get("/products/updateQTY", [productController::class, 'updateQTY']);
$route->post("/products/updateQTY", [productController::class, 'updateQTY']);
$route->post("/products/store", [productController::class, 'store']);
$route->get("/products/view/{product_id}", [productController::class, 'show']);
$route->get("/products/edit/{product_id}", [productController::class, 'edit']);
$route->post("/products/update/{product_id}", [productController::class, 'update']);
$route->post("/products/updateQuantity", [productController::class, 'updateQuantity']);
$route->post("/products/delete/{product_id}", [productController::class, 'delete']);
//route user
$route->get("/users", [UserController::class, 'index']);
$route->get("/users/create", [UserController::class, 'create']);
$route->post("/users/authentication", [UserController::class, 'authentication']);
$route->get("/users/logout", [UserController::class, 'logout']);
$route->post('/users/store', [UserController::class, 'store']);
$route->get("/users/edit/{user_id}", [UserController::class, 'edit']); // Added
$route->post("/users/update", [UserController::class, 'update']); // Added
$route->get("/users/delete/{user_id}", [UserController::class, 'delete']); // Added

// calendar
$route->get("/calendar", [CalendarController::class, 'index']);
$route->get("/notification", [NotificationController::class, 'index']);

// order 
$route->get("/orders", [OrderController::class, 'index']);  
$route->get("/orders/view/{orderId}", [OrderController::class, 'show']); 
$route->post("/orders/delete/{orderId}", [OrderController::class, 'delete']);
$route->get("/orders/create", [CreateOrderController::class, 'index']);
$route->get("/orders/checkStock", [CreateOrderController::class, 'checkStock']);
$route->get("/orders/create/QR", [CreateOrderController::class, 'qrcode']);
$route->post("/orders/saveOrder", [CreateOrderController::class, 'placeOrder']); 
$route->get("/orders/summary", [CreateOrderController::class, 'summary']); 


$route->get("/orders/view", [ OrderViewController::class, '']);

// generate ---
$route->get('/generate/pdf', [GeneratePdfController::class, 'index']);
$route->post('/generate/generatepdf', [GeneratePdfController::class, 'generatepdf']);

//  export excel 
$route->get("/export", [ExportExcelController::class, 'index']);
$route->post("/export/excel", [ExportExcelController::class, 'exportToExcel']);

//delete inventory drinks
$route->get("/drink", [DrinkController::class, 'index']);
$route->post("/drink/delete/{product_id}", [DrinkController::class, 'delete']);
$route->get("/inventory/viewdrink/{product_id}", [DrinkController::class, 'show']);

// delete food inventory
$route->get("/food", [FoodController::class, 'index']);
$route->get("/inventory/viewfood/{product_id}", [FoodController::class, 'show']);
$route->post("/food/delete/{product_id}", [FoodController::class, 'delete']);


// delete ice inventory
$route->get("/ice", [IceController::class, 'index']);
$route->get("/inventory/viewice/{product_id}", [IceController::class, 'show']);
$route->post("/ice/delete/{product_id}", [IceController::class, 'delete']);

$route->get('/ExportInventory/exportInventory', [ExportInventoryController::class, 'index']);
$route->post('/ExportInventory/Inventorypdf', [ExportInventoryController::class, 'exportInventoryPdf']);





$route->route();
