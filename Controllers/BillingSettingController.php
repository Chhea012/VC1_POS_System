<?php 
require_once "BaseController.php";
class BillingSettingController extends BaseController{
    public function index(){
        $this->view('profile/billing_setting');
    }
}
?>