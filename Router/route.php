<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/AdminController.php";
require_once "Controllers/AddproductController.php";


$route = new Router();
$route->get("/", [AdminController::class, 'index']);

//add product
$route->get("/addproduct", [AddproductController::class, 'index']);
$route->route();