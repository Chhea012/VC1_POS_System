<?php 
class InventoryController extends BaseController {
    public function index() {
        $this->view('inventory/drink');
    }
}