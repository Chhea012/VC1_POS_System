<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/AdminController.php";
require_once "Controllers/AddproductController.php";
require_once "Controllers/EditProfileController.php";
require_once "Controllers/SettingSecurityController.php";
require_once "Controllers/BillingSettingController.php";
require_once "Controllers/ChartController.php";
require_once "Controllers/WeatherController.php";
require_once "Controllers/LoginController.php";
require_once "Controllers/RegisterController.php";
require_once "Controllers/ForgotPasswordController.php";

$route = new Router();

$route->get("/", [LoginController::class, 'login']);
$route->get("/register", [RegisterController::class, 'register']);
$route->get("/forgotpassword", [ForgotPasswordController::class, 'forgotpassword']);

$route->get("/dashboard", [AdminController::class, 'index']);
$route->get("/edit_profile", [EditProfileController::class, 'index']);
$route->get("/setting_security", [SettingSecurityController::class, 'index']);
$route->get("/billing_setting", [BillingSettingController::class, 'index']);
$route->get("/weather", [WeatherController::class, 'index']);
$route->get("/chart", [ChartController::class, 'index']);
$route->get("/addproduct", [AddproductController::class, 'index']);

$route->route();