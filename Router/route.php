<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/AdminController.php";
require_once "Controllers/ProfileController.php";



$route = new Router();
$route->get("/", [AdminController::class, 'index']);
$route->get("/edit_profile", [ProfileController::class, 'index']);

$route->route();