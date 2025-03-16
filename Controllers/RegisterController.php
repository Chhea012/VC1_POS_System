<?php
require_once 'Models/RegisterModel.php';

class RegisterController extends BaseController {
    private $registerModel;

    public function __construct() {
        $this->registerModel = new RegisterModel();
    }

    public function register() {
        $roles = $this->registerModel->getRoles();
        $this->view("authentications/register", ['roles' => $roles]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Basic validation
            if (empty($_POST['user_name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role_id'])) {
                $error = "All required fields must be filled.";
                $roles = $this->registerModel->getRoles();
                $this->view("authentications/register", ['roles' => $roles, 'error' => $error]);
                return;
            }

            // Check if email exists
            if ($this->registerModel->getUserByEmail($_POST['email'])) {
                $error = "Email already registered.";
                $roles = $this->registerModel->getRoles();
                $this->view("authentications/register", ['roles' => $roles, 'error' => $error]);
                return;
            }

            // Handle file upload
            $profileImage = '';
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'views/assets/uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '-' . basename($_FILES['profile_image']['name']);
                $uploadFile = $uploadDir . $fileName;
                if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
                    $error = "Failed to upload image.";
                    $roles = $this->registerModel->getRoles();
                    $this->view("authentications/register", ['roles' => $roles, 'error' => $error]);
                    return;
                }
                $profileImage = $fileName;
            }

            // Prepare data
            $data = [
                'user_name' => $_POST['user_name'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role_id' => (int)$_POST['role_id'],
                'profile_image' => $profileImage,
                'phone_number' => $_POST['phone_number'] ?? ''
            ];

            try {
                $userId = $this->registerModel->createUser($data);
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = [
                    'user_id' => $userId,
                    'user_name' => $data['user_name'],
                    'role_id' => $data['role_id']
                ];
                $this->redirect('/dashboard');
            } catch (Exception $e) {
                error_log("Registration error: " . $e->getMessage());
                $error = "Error saving user: " . $e->getMessage();
                $roles = $this->registerModel->getRoles();
                $this->view("authentications/register", ['roles' => $roles, 'error' => $error]);
            }
        } else {
            $this->redirect('/register');
        }
    }
}