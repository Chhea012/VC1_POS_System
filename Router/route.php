<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/AdminController.php";
<<<<<<< HEAD
require_once "Controllers/EditProfileController.php";
require_once "Controllers/SettingSecurityController.php";
require_once "Controllers/BillingSettingController.php";

=======
require_once "Controllers/WeatherController.php";
>>>>>>> 1d7f40634825601b52348fba09676452d2f75eed


$route = new Router();
$route->get("/", [AdminController::class, 'index']);
<<<<<<< HEAD
$route->get("/edit_profile", [EditProfileController::class, 'index']);
$route->get("/setting_security", [SettingSecurityController::class, 'index']);
$route->get("/billing_setting", [BillingSettingController::class, 'index']);
=======
$route->get("/weather", [WeatherController::class, 'index']);
>>>>>>> 1d7f40634825601b52348fba09676452d2f75eed

$route->route();