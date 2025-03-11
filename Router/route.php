<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/AdminController.php";
require_once "Controllers/productController.php";
require_once "Controllers/EditProfileController.php";
require_once "Controllers/SettingSecurityController.php";
require_once "Controllers/BillingSettingController.php";
require_once "Controllers/ChartController.php";
require_once "Controllers/WeatherController.php";
require_once "Controllers/LoginController.php";
require_once "Controllers/RegisterController.php";
require_once "Controllers/ForgotPasswordController.php";
require_once "Controllers/addController.php";
require_once "Controllers/categoryController.php";

$route = new Router();

// GET routes
$route->get("/", [LoginController::class, 'login']);
$route->get("/register", [RegisterController::class, 'register']);
$route->get("/forgotpassword", [ForgotPasswordController::class, 'forgotpassword']);
$route->get("/dashboard", [AdminController::class, 'index']);
$route->get("/products", [productController::class, 'index']);
$route->get("/edit_profile", [EditProfileController::class, 'index']);
$route->get("/setting_security", [SettingSecurityController::class, 'index']);
$route->get("/billing_setting", [BillingSettingController::class, 'index']);
$route->get("/weather", [WeatherController::class, 'index']);
$route->get("/chart", [ChartController::class, 'index']);
$route->get("/add", [addController::class, 'index']);
$route->get("/category", [categoryController::class, 'index']);

$route->post('/category/store', [categoryController::class, 'store']);


$route->route();
