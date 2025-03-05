<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/AdminController.php";
require_once "Controllers/productController.php";


$route = new Router();
$route->get("/", [AdminController::class, 'index']);
$route->get("/products", [productController::class, 'index']);

$route->route();