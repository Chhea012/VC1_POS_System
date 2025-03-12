<?php
class productController extends BaseController {
    public function index() {
        $this->view('products/product-list');
    }
}
