<?php
// /Controllers/UserController.php
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
                $file = $_FILES['profile_image'];
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 2 * 1024 * 1024; // 2MB

                // Validate file
                if (!in_array($file['type'], $allowedTypes)) {
                    die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
                }
                if ($file['size'] > $maxSize) {
                    die("File too large. Maximum size is 2MB.");
                }

                // Define upload directory
                $uploadDir = __DIR__ . '/../Views/assets/uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '-' . basename($file['name']);
                $uploadFile = $uploadDir . $fileName;
                if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    die("Failed to upload image.");
                }
                $profileImage = '/Views/assets/uploads/' . $fileName; // Web-accessible path
            }

            // Prepare data with encrypted password
            $data = [
                'user_name' => $_POST['user_name'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role_id' => (int)$_POST['role_id'],
                'profile_image' => $profileImage,
                'phone_number' => $_POST['phone_number'] ?? ''
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

    public function edit($user_id) {
        $user = $this->user->getUserById($user_id);
        if (!$user) {
            die("User not found.");
        }
        $roles = $this->user->getRoles();
        $this->view('users/edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = (int)$_POST['user_id'];
            if (empty($_POST['user_name']) || empty($_POST['email']) || empty($_POST['role_id'])) {
                die("All required fields must be filled.");
            }

            // Handle file upload (optional update)
            $profileImage = $_POST['existing_image'] ?? '';
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['profile_image'];
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 2 * 1024 * 1024; // 2MB

                // Validate file
                if (!in_array($file['type'], $allowedTypes)) {
                    die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
                }
                if ($file['size'] > $maxSize) {
                    die("File too large. Maximum size is 2MB.");
                }

                // Define upload directory
                $uploadDir = __DIR__ . '/../Views/assets/uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '-' . basename($file['name']);
                $uploadFile = $uploadDir . $fileName;
                if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    $profileImage = '/Views/assets/uploads/' . $fileName;

                    // Delete old image if it exists
                    $oldImagePath = $uploadDir . basename($_POST['existing_image']);
                    if (!empty($_POST['existing_image']) && file_exists($oldImagePath)) {
                        unlink($oldImagePath);
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
    // updateUser
    public function updateUser($user_id, $data) {
        $sql = "UPDATE users SET user_name = :user_name, email = :email, role_id = :role_id, 
                profile_image = :profile_image, phone_number = :phone_number, 
                address = :address, city_province = :city_province";
    
        if (isset($data['password'])) {
            $sql .= ", password = :password";
        }
    
        $sql .= " WHERE id = :user_id";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_name', $data['user_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role_id', $data['role_id'], PDO::PARAM_INT);
        $stmt->bindParam(':profile_image', $data['profile_image']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':city_province', $data['city_province']);
    
        if (isset($data['password'])) {
            $stmt->bindParam(':password', $data['password']);
        }
    
        return $stmt->execute();
    }    
    
    public function delete($user_id) {
        $user = $this->user->getUserById($user_id);
        if ($user) {
            $uploadDir = __DIR__ . '/../Views/assets/uploads/';
            $imagePath = $uploadDir . basename($user['profile_image']);
            if (!empty($user['profile_image']) && file_exists($imagePath)) {
                if (!unlink($imagePath)) {
                    die("Failed to delete image: $imagePath");
                }
            }
            $this->user->deleteUser($user_id);
        }
        $this->redirect('/users');
    }

    public function authentication() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = $this->user->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user'] = $user;
            $this->redirect("/dashboard");
        } else {
            $data = ['error' => 'Invalid Email or Password!'];
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