<?php

require_once 'Models/UserModel.php';

class UserController extends BaseController {
    private $user;

    public function __construct() {
        $this->user = new UserModel();
    }

    public function index() {
        $users = $this->user->getUsers();
        $this->view('users/user', ['users' => $users]);
    }

    public function create() {
        $roles = $this->user->getRoles();
        $this->view('users/create', ['roles' => $roles]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Basic validation
            if (empty($_POST['user_name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role_id'])) {
                die("All required fields must be filled.");
            }

            // Handle file upload
            $profileImage = '';
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../images/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '-' . basename($_FILES['profile_image']['name']);
                $uploadFile = $uploadDir . $fileName;
                if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
                    die("Failed to upload image.");
                }
                $profileImage = $fileName;
            }

            // Prepare data with encrypted password
            $data = [
                'user_name' => $_POST['user_name'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role_id' => (int)$_POST['role_id'],
                'profile_image' => $profileImage,
                'phone_number' => $_POST['phone_number'] ?? '',
                'address' => $_POST['address'] ?? '',
                'city_province' => $_POST['city_province'] ?? ''
            ];

            // Save to database
            try {
                $this->user->createUser($data);
                session_start();
                $_SESSION['user'] = $data['user_name'];
                $this->redirect('/users');
            } catch (Exception $e) {
                die("Error saving user: " . $e->getMessage());
            }
        } else {
            $this->redirect('/users/create');
        }
    }

    // Added method to show edit form
    public function edit($user_id) {
        $user = $this->user->getUserById($user_id);
        if (!$user) {
            die("User not found.");
        }
        $roles = $this->user->getRoles();
        $this->view('users/edit', ['user' => $user, 'roles' => $roles]);
    }

    // Added method to update user
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = (int)$_POST['user_id'];
            if (empty($_POST['user_name']) || empty($_POST['email']) || empty($_POST['role_id'])) {
                die("All required fields must be filled.");
            }

            // Handle file upload (optional update)
            $profileImage = $_POST['existing_image'] ?? '';
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../images/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '-' . basename($_FILES['profile_image']['name']);
                $uploadFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
                    $profileImage = $fileName;
                    // Delete old image if it exists
                    if (!empty($_POST['existing_image']) && file_exists($uploadDir . $_POST['existing_image'])) {
                        unlink($uploadDir . $_POST['existing_image']);
                    }
                }
            }

            // Prepare data
            $data = [
                'user_name' => $_POST['user_name'],
                'email' => $_POST['email'],
                'role_id' => (int)$_POST['role_id'],
                'profile_image' => $profileImage,
                'phone_number' => $_POST['phone_number'] ?? '',
                'address' => $_POST['address'] ?? '',
                'city_province' => $_POST['city_province'] ?? ''
            ];

            // Update password only if provided
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            // Update in database
            try {
                $this->user->updateUser($user_id, $data);
                $this->redirect('/users');
            } catch (Exception $e) {
                die("Error updating user: " . $e->getMessage());
            }
        } else {
            $this->redirect('/users');
        }
    }

    // Added method to delete user
    public function delete($user_id) {
        $user = $this->user->getUserById($user_id);
        if ($user) {
            $uploadDir = '../images/';
            $imagePath = $uploadDir . $user['profile_image'];
            if (!empty($user['profile_image']) && file_exists($imagePath)) {
                if (!unlink($imagePath)) {
                    die("Failed to delete image: $imagePath");
                }
            }
            $this->user->deleteUser($user_id);
        }
        $this->redirect('/users');
    }

    public function authentication()  {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = $this->user->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user'] = $user; // Store user ID or relevant data
            $this->redirect("/dashboard");   // Redirect to dashboard
        } else {
            $data = ['error' => 'Invalid Email or Password!'];
            $this->redirect('/'); // Show login with error
        }
    }
   

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        $this->redirect('/');
    }
}