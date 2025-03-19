<?php
require_once 'BaseController.php';
class OrderController extends BaseController{
    function index(){
        $this -> view('orders/order_list');
    }
}