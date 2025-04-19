<?php
class LoginController extends BaseController {
    function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];
            global $pdo; // Assuming Database.php sets $pdo globally
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin'] = $user['id']; // Store user ID or relevant data
                $this->redirect("./dashboard");   // Redirect to dashboard
            } else {
                $data = ['error' => 'Invalid Email or Password!'];
                $this->view("authentications/login", $data, null); // Show login with error
            }
        } else {
            $this->view("authentications/login", [], null); // Initial load
        }
    }
}

