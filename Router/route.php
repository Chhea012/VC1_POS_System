<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/AdminController.php";
require_once "Controllers/inventory/inventoryController.php";
require_once "Controllers/inventory/FoodController.php";
require_once "Controllers/inventory/IceController.php";


$route = new Router();
$route->get("/", [AdminController::class, 'index']);
$route->get("/inventory", [InventoryController::class, 'index']);
$route->get("/food", [FoodController::class, 'index']);
$route->get("/ice", [IceController::class, 'index']);


$route->route();