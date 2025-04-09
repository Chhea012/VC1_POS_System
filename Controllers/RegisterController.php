<?php
require_once 'Models/RegisterModel.php';

class RegisterController extends BaseController {
    private $registerModel;

    public function __construct() {
        $this->registerModel = new RegisterModel();
    }

    public function register() {
        $roles = $this->registerModel->getRoles();
        $this->view("authentications/register", ['roles' => $roles], null);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
            return;
        }

        // Validate required fields
        $requiredFields = ['user_name', 'email', 'password', 'role_id'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $error = "All required fields must be filled.";
                $roles = $this->registerModel->getRoles();
                $this->view("authentications/register", ['roles' => $roles, 'error' => $error], null);
                return;
            }
        }

        // Sanitize and validate email
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
            $roles = $this->registerModel->getRoles();
            $this->view("authentications/register", ['roles' => $roles, 'error' => $error], null);
            return;
        }

        // Validate password length
        if (strlen($_POST['password']) < 8) {
            $error = "Password must be at least 8 characters long.";
            $roles = $this->registerModel->getRoles();
            $this->view("authentications/register", ['roles' => $roles, 'error' => $error], null);
            return;
        }

        // Check for existing email
        if ($this->registerModel->getUserByEmail($email)) {
            $error = "Email already registered.";
            $roles = $this->registerModel->getRoles();
            $this->view("authentications/register", ['roles' => $roles, 'error' => $error], null);
            return;
        }

        // Handle image upload to views/assets/uploads/
        $profileImage = '';
        $uploadDir = 'views/assets/uploads/';
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($_FILES['profile_image']['tmp_name']);
            if (!in_array($fileType, $allowedTypes)) {
                $error = "Only JPEG, PNG, and GIF images are allowed.";
                $roles = $this->registerModel->getRoles();
                $this->view("authentications/register", ['roles' => $roles, 'error' => $error], null);
                return;
            }

            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    error_log("Failed to create directory: $uploadDir");
                    $error = "Server error: Unable to create upload directory.";
                    $roles = $this->registerModel->getRoles();
                    $this->view("authentications/register", ['roles' => $roles, 'error' => $error], null);
                    return;
                }
            }

            $fileExtension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('profile_', true) . '.' . strtolower($fileExtension);
            $uploadPath = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath)) {
                error_log("Failed to move file to: $uploadPath");
                $error = "Failed to upload image. Please try again.";
                $roles = $this->registerModel->getRoles();
                $this->view("authentications/register", ['roles' => $roles, 'error' => $error], null);
                return;
            }

            $profileImage = $fileName;
        } elseif ($_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $error = "Image upload error: " . $_FILES['profile_image']['error'];
            $roles = $this->registerModel->getRoles();
            $this->view("authentications/register", ['roles' => $roles, 'error' => $error], null);
            return;
        }

        // Prepare user data
        $data = [
            'user_name' => filter_var($_POST['user_name'], FILTER_SANITIZE_STRING),
            'email' => $email,
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role_id' => (int)$_POST['role_id'],
            'profile_image' => $profileImage,
            'phone_number' => filter_var($_POST['phone_number'] ?? '', FILTER_SANITIZE_STRING)
        ];

        try {
            $userId = $this->registerModel->createUser($data);
            session_start();
            $_SESSION['user'] = [
                'user_id' => $userId,
                'user_name' => $data['user_name'],
                'role_id' => $data['role_id']
            ];
            $this->redirect('/dashboard');
        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            $error = "Error saving user. Please try again.";
            $roles = $this->registerModel->getRoles();
            $this->view("authentications/register", ['roles' => $roles, 'error' => $error], null);
        }
    }

    public function delete($userId) {
        // Optional: Add authorization check (e.g., only admins can delete)
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 1) { // Assuming role_id 1 is admin
            $this->redirect('/dashboard');
            return;
        }

        try {
            $this->registerModel->deleteUser($userId);
            $this->redirect('/dashboard'); // Redirect to dashboard or user list
        } catch (Exception $e) {
            error_log("Delete user error: " . $e->getMessage());
            $error = "Failed to delete user: " . $e->getMessage();
            // Redirect or render an error page
            $this->redirect('/dashboard?error=' . urlencode($error));
        }
    }
}