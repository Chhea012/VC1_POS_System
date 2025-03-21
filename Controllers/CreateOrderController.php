<?php
require_once 'BaseController.php';
class CreateOrderController extends BaseController{
    function index(){
        $this -> view('orders/create_order');
    }
}