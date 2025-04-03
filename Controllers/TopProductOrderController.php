<?php
require_once 'BaseController.php';
class TopProductOrderController extends BaseController{
    function index(){
        $this -> view('orders/top_product_order');
    }
}