<?php
session_start();
require_once 'BaseController.php';

class SettingSecurityController extends BaseController{

    public function index(){
        // $this->view('profile/setting_security');

        // $userId = $_SESSION['user_id']; // Assuming you store user ID in session
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            // Here you can pass the passwords back to the view, but make sure not to display plain passwords
            $this->view('profile/setting_security', [
                'currentPassword' => $currentPassword, 
                'newPassword' => $newPassword, 
                'confirmPassword' => $confirmPassword
            ]);
        } else {
            // If no form is submitted, just display the page
            $this->view('profile/setting_security');
        }
    }
}
?>