<?php
require_once 'BaseController.php';
class SettingSecurityController extends BaseController{

    public function index(){
        $this->view('profile/setting_security');
    }
}
?>