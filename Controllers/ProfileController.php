<?php
// /Controllers/ProfileController.php
require_once "Models/ProfileModel.php";

class ProfileController extends BaseController {
    private $profileModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->profileModel = new ProfileModel();
    }

    // Display the profile page
    public function index() {
        if (!isset($_SESSION['user']['user_id'])) {
            $this->redirect('/login');
            return;
        }

        $user = $this->profileModel->getUserById($_SESSION['user']['user_id']);
        if (!$user) {
            $this->view("error", ["message" => "User not found."]);
            return;
        }
        $this->view("profile/profile", ["user" => $user]);
    }

    // Update profile including image upload
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/profile');
            return;
        }

        if (!isset($_SESSION['user']['user_id'])) {
            $this->redirect('/login');
            return;
        }

        // Validate CSRF token
        if (!isset($_POST['_csrf']) || $_POST['_csrf'] !== ($_SESSION['csrf_token'] ?? '')) {
            $user = $this->profileModel->getUserById($_SESSION['user']['user_id']);
            $this->view("profile/profile", ["user" => $user, "error" => "Invalid CSRF token."]);
            return;
        }

        $user_id = (int)$_SESSION['user']['user_id'];

        // Validate required fields
        if (empty($_POST['userName']) || empty($_POST['email'])) {
            $user = $this->profileModel->getUserById($user_id);
            $this->view("profile/profile", ["user" => $user, "error" => "All required fields must be filled."]);
            return;
        }

        // Validate email uniqueness
        if ($this->profileModel->isEmailTaken($_POST['email'], $user_id)) {
            $user = $this->profileModel->getUserById($user_id);
            $this->view("profile/profile", ["user" => $user, "error" => "Email is already in use."]);
            return;
        }

        // Validate phone number format
        if (!empty($_POST['phoneNumber']) && !preg_match('/^[0-9]{8,10}$/', $_POST['phoneNumber'])) {
            $user = $this->profileModel->getUserById($user_id);
            $this->view("profile/profile", ["user" => $user, "error" => "Invalid phone number format."]);
            return;
        }

        // Handle file upload for the profile image
        $profileImage = $_POST['existing_image'] ?? '';
        if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['profileImage'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            // Validate file type and size
            if (!in_array($file['type'], $allowedTypes)) {
                $user = $this->profileModel->getUserById($user_id);
                $this->view("profile/profile", ["user" => $user, "error" => "Invalid file type. Only JPG, PNG, and GIF are allowed."]);
                return;
            }
            if ($file['size'] > $maxSize) {
                $user = $this->profileModel->getUserById($user_id);
                $this->view("profile/profile", ["user" => $user, "error" => "File too large. Maximum size is 2MB."]);
                return;
            }

            // Move the uploaded file to the server
            $uploadDir = __DIR__ . '/../assets/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid() . '-' . basename($file['name']);
            $uploadFile = $uploadDir . $fileName;
            if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $user = $this->profileModel->getUserById($user_id);
                $this->view("profile/profile", ["user" => $user, "error" => "Failed to upload image."]);
                return;
            }
            $profileImage = '/assets/uploads/' . $fileName;

            // Delete the old profile image if it exists
            $oldImagePath = __DIR__ . '/../' . ltrim($_POST['existing_image'], '/');
            if (!empty($_POST['existing_image']) && file_exists($oldImagePath) && $_POST['existing_image'] !== $profileImage) {
                unlink($oldImagePath);
            }
        }

        // Prepare data for the update
        $data = [
            'user_name' => $_POST['userName'],
            'email' => $_POST['email'],
            'phone_number' => $_POST['phoneNumber'] ?? '',
            'profile_image' => $profileImage
        ];

        try {
            // Update the profile in the database
            $this->profileModel->update($user_id, $data);
            // Update session data
            $_SESSION['user'] = array_merge($_SESSION['user'], $data);
            $_SESSION['success'] = "Profile updated successfully.";
            $this->redirect('/profile');
        } catch (Exception $e) {
            $user = $this->profileModel->getUserById($user_id);
            $this->view("profile/profile", ["user" => $user, "error" => $e->getMessage()]);
        }
    }
}
?>