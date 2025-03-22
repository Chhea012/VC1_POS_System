<?php
require_once 'BaseController.php';
class OrderSummaryController extends BaseController{
    function index(){
        $this -> view('orders/order_summary');
    }
}