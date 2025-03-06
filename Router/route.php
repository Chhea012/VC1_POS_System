<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/AdminController.php";
require_once "Controllers/AddproductController.php";
require_once "Controllers/EditProfileController.php";
require_once "Controllers/SettingSecurityController.php";
require_once "Controllers/BillingSettingController.php";

require_once "Controllers/WeatherController.php";


$route = new Router();
$route->get("/", [AdminController::class, 'index']);
$route->get("/edit_profile", [EditProfileController::class, 'index']);
$route->get("/setting_security", [SettingSecurityController::class, 'index']);
$route->get("/billing_setting", [BillingSettingController::class, 'index']);
$route->get("/weather", [WeatherController::class, 'index']);

//add product
$route->get("/addproduct", [AddproductController::class, 'index']);
$route->route();