<?php 
class FoodController extends BaseController {
    public function index() {
        $this->view('inventory/food');
    }
}