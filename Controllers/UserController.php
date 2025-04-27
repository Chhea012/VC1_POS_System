<?php
// /Controllers/UserController.php
require_once 'Models/UserModel.php';

class UserController extends BaseController {
    private $user;

    public function __construct() {
        $this->user = new UserModel();
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            $this->redirect('/');
            return;
        }

        // Check if the user is an admin
        $isAdmin = $this->user->isAdmin($_SESSION['user']['user_id']);
        $roles = $this->user->getRoles();

        if ($isAdmin) {
            // Admins see all users
            $users = $this->user->getUsers();
        } else {
            // Non-admins (User, Staff) see only their own data
            $user = $this->user->getCurrentUser($_SESSION['user']['user_id']);
            $users = $user ? [$user] : []; // Wrap in array for view compatibility
        }

        $this->view('users/user', [
            'users' => $users,
            'roles' => $roles,
            'isAdmin' => $isAdmin
        ]);
    }

    public function create() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            $this->redirect('/');
            return;
        }
        if (!$this->user->isAdmin($_SESSION['user']['user_id'])) {
            $_SESSION['error'] = "Only admins can create users.";
            $this->redirect('/users');
            return;
        }
        $roles = $this->user->getRoles();
        $this->view('users/create', ['roles' => $roles]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/users');
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirect('/');
            return;
        }

        if (!$this->user->isAdmin($_SESSION['user']['user_id'])) {
            $_SESSION['error'] = "Only admins can create users.";
            $this->redirect('/users');
            return;
        }

        if (empty($_POST['user_name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role_id'])) {
            $_SESSION['error'] = "All required fields must be filled.";
            $this->redirect('/users');
            return;
        }

        $role_id = (int)$_POST['role_id'];
        if ($role_id === 1 && $this->user->hasAdmin()) {
            $_SESSION['error'] = "An admin user already exists. Only one admin is allowed.";
            $this->redirect('/users');
            return;
        }

        $profileImage = null;
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['profile_image'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024;

            if (!in_array($file['type'], $allowedTypes) || $file['size'] > $maxSize) {
                $_SESSION['error'] = "Invalid file type or size. Only JPG, PNG, GIF (max 2MB) allowed.";
                $this->redirect('/users');
                return;
            }

            $uploadDir = __DIR__ . '/../Views/assets/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid() . '-' . basename($file['name']);
            $uploadFile = $uploadDir . $fileName;
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $profileImage = '/Views/assets/uploads/' . $fileName;
            } else {
                $_SESSION['error'] = "Failed to upload image.";
                $this->redirect('/users');
                return;
            }
        }

        $data = [
            'user_name' => $_POST['user_name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'role_id' => $role_id,
            'profile_image' => $profileImage,
            'phone_number' => $_POST['phone_number'] ?? null
        ];

        try {
            $this->user->createUser($data);
            $_SESSION['success'] = "User created successfully.";
            $this->redirect('/users');
        } catch (Exception $e) {
            $_SESSION['error'] = "Error creating user: " . $e->getMessage();
            $this->redirect('/users');
        }
    }

    public function edit($user_id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            $this->redirect('/');
            return;
        }
        if (!$this->user->isAdmin($_SESSION['user']['user_id'])) {
            $_SESSION['error'] = "Only admins can edit users.";
            $this->redirect('/users');
            return;
        }
        $user = $this->user->getUserById($user_id);
        if (!$user) {
            $_SESSION['error'] = "User not found.";
            $this->redirect('/users');
            return;
        }
        $roles = $this->user->getRoles();
        $this->view('users/edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/users');
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirect('/');
            return;
        }

        if (!$this->user->isAdmin($_SESSION['user']['user_id'])) {
            $_SESSION['error'] = "Only admins can update users.";
            $this->redirect('/users');
            return;
        }

        $user_id = (int)$_POST['user_id'];
        if (empty($_POST['user_name']) || empty($_POST['email']) || empty($_POST['role_id'])) {
            $_SESSION['error'] = "All required fields must be filled.";
            $this->redirect("/users/edit/$user_id");
            return;
        }

        $user = $this->user->getUserById($user_id);
        if (!$user) {
            $_SESSION['error'] = "User not found.";
            $this->redirect('/users');
            return;
        }

        $role_id = (int)$_POST['role_id'];
        if ($role_id === 1 && $user['role_id'] !== 1 && $this->user->hasAdmin()) {
            $_SESSION['error'] = "An admin user already exists. Only one admin is allowed.";
            $this->redirect("/users/edit/$user_id");
            return;
        }

        $profileImage = $user['profile_image'];
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['profile_image'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024;

            if (!in_array($file['type'], $allowedTypes) || $file['size'] > $maxSize) {
                $_SESSION['error'] = "Invalid file type or size. Only JPG, PNG, GIF (max 2MB) allowed.";
                $this->redirect("/users/edit/$user_id");
                return;
            }

            $uploadDir = __DIR__ . '/../Views/assets/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid() . '-' . basename($file['name']);
            $uploadFile = $uploadDir . $fileName;
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $profileImage = '/Views/assets/uploads/' . $fileName;
                if (!empty($user['profile_image']) && file_exists($uploadDir . basename($user['profile_image']))) {
                    unlink($uploadDir . basename($user['profile_image']));
                }
            }
        }

        $data = [
            'user_name' => $_POST['user_name'],
            'email' => $_POST['email'],
            'role_id' => $role_id,
            'profile_image' => $profileImage,
            'phone_number' => $_POST['phone_number'] ?? null
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = $_POST['password'];
        }

        try {
            $this->user->update($user_id, $data);
            $_SESSION['success'] = "User updated successfully.";
            $this->redirect('/users');
        } catch (Exception $e) {
            $_SESSION['error'] = "Error updating user: " . $e->getMessage();
            $this->redirect("/users/edit/$user_id");
        }
    }

    public function delete($user_id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirect('/');
            return;
        }

        if (!$this->user->isAdmin($_SESSION['user']['user_id'])) {
            $_SESSION['error'] = "Only admins can delete users.";
            $this->redirect('/users');
            return;
        }

        $user = $this->user->getUserById($user_id);
        if (!$user) {
            $_SESSION['error'] = "User not found.";
            $this->redirect('/users');
            return;
        }

        if ($user['role_id'] === 1) {
            $_SESSION['error'] = "Admin accounts cannot be deleted.";
            $this->redirect('/users');
            return;
        }

        if (isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id'] == $user_id) {
            $_SESSION['error'] = "You cannot delete your own account.";
            $this->redirect('/users');
            return;
        }

        $uploadDir = __DIR__ . '/../Views/assets/uploads/';
        $imagePath = $uploadDir . basename($user['profile_image']);
        if (!empty($user['profile_image']) && file_exists($imagePath)) {
            if (!unlink($imagePath)) {
                $_SESSION['error'] = "Failed to delete profile image.";
                $this->redirect('/users');
                return;
            }
        }

        try {
            $this->user->deleteUser($user_id);
            $_SESSION['success'] = "User deleted successfully.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error deleting user: " . $e->getMessage();
        }
        $this->redirect('/users');
    }

    public function authentication() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
            return;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->user->login($email, $password);

        if ($user) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            $_SESSION['user'] = $user;
            $this->redirect('/dashboard');
        } else {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error'] = "Invalid email or password.";
            $this->redirect('/');
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
?>