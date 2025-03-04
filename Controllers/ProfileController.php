<?php

class ProfileController extends BaseController {
    public function index() {
        $this->view('profile/edit_profile');
    }
}