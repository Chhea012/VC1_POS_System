<?php
// /Controllers/ProfileController.php
require_once "Models/ProfileModel.php";

class ProfileController extends BaseController {
    private $profileModel;

    public function __construct() {
        $this->profileModel = new ProfileModel();
    }

    // Display the profile page
    public function index() {
        $user = $this->profileModel->getAdminUser();
        if (!$user) {
            $this->view("error", ["message" => "No admin user found in the database."]);
            return;
        }
        $this->view("profile/profile", ["user" => $user]);
    }

    // Update profile including image upload
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = (int)$_POST['user_id'];
            if (empty($_POST['userName']) || empty($_POST['email'])) {
                $user = $this->profileModel->getAdminUser();
                $this->view("profile/profile", ["user" => $user, "error" => "All required fields must be filled."]);
                return;
            }

            // Handle file upload
            $profileImage = $_POST['existing_image'] ?? '';
            if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['profileImage'];
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 2 * 1024 * 1024; // 2MB

                // Validate file
                if (!in_array($file['type'], $allowedTypes)) {
                    $user = $this->profileModel->getAdminUser();
                    $this->view("profile/profile", ["user" => $user, "error" => "Invalid file type. Only JPG, PNG, and GIF are allowed."]);
                    return;
                }
                if ($file['size'] > $maxSize) {
                    $user = $this->profileModel->getAdminUser();
                    $this->view("profile/profile", ["user" => $user, "error" => "File too large. Maximum size is 2MB."]);
                    return;
                }

                // Define upload directory
                $uploadDir = __DIR__ . '/../Views/assets/uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '-' . basename($file['name']);
                $uploadFile = $uploadDir . $fileName;
                if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    $user = $this->profileModel->getAdminUser();
                    $this->view("profile/profile", ["user" => $user, "error" => "Failed to upload image."]);
                    return;
                }
                $profileImage = '/Views/assets/uploads/' . $fileName;

                // Delete old image if it exists
                $oldImagePath = $uploadDir . basename($_POST['existing_image']);
                if (!empty($_POST['existing_image']) && file_exists($oldImagePath) && $_POST['existing_image'] !== $profileImage) {
                    unlink($oldImagePath);
                }
            }

            // Prepare data
            $data = [
                'user_name' => $_POST['userName'],
                'email' => $_POST['email'],
                'phone_number' => $_POST['phoneNumber'] ?? '',
                'profile_image' => $profileImage
            ];

            // Update in database
            try {
                $this->profileModel->updateUser($user_id, $data);
                $this->redirect('/profile');
            } catch (Exception $e) {
                $user = $this->profileModel->getAdminUser();
                $this->view("profile/profile", ["user" => $user, "error" => "Error updating user: " . $e->getMessage()]);
            }
        } else {
            $this->redirect('/profile');
        }
    }
}