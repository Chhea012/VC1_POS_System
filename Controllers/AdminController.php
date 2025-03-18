<?php

class AdminController extends BaseController {
    public function index() {
        $this->view('admins/dashboard');
    }
}
