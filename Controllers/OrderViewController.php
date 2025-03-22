<?php
require_once 'BaseController.php';
class OrderViewController extends BaseController{
    function index(){
        $this -> view('orders/order_view');
    }
}