<?php
// /Controllers/ProfileController.php
require_once "Models/ProfileModel.php";

class ProfileController extends BaseController {
    private $profileModel;
    private $securityService;

    public function __construct() {
        $this->profileModel = new ProfileModel();
        // $this->securityService = $securityService;

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
        
        // Validate required fields
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
            'role_id' => 1, // Assuming role ID is 1 for admin
            'phone_number' => $_POST['phoneNumber'] ?? '',
            'profile_image' => $profileImage
        ];

        // Log the data to debug
        error_log("Update data: " . print_r($data, true));

        // Update in database
        try {
            $this->profileModel->update($user_id, $data);
            $this->redirect('/profile');
        } catch (Exception $e) {
            $user = $this->profileModel->getAdminUser();
            $this->view("profile/profile", ["user" => $user, "error" => "Error updating user: " . $e->getMessage()]);
        }
    } else {
        $this->redirect('/profile');
    }
}
    public function changePassword() {
        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];  // Assuming user is logged in and their user_id is stored in session
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            // Validate new password confirmation
            if ($newPassword !== $confirmPassword) {
                $error = "New password and confirmation do not match.";
                $this->view('profile/setting_security', ['error' => $error]);
                return;
            }

            // Call the service method to handle password change
            $result = $this->securityService->changePassword($userId, $currentPassword, $newPassword);

            if ($result === true) {
                $success = "Password updated successfully!";
                $this->view('profile/setting_security', ['success' => $success]);
            } else {
                $error = $result;
                $this->view('profile/setting_security', ['error' => $error]);
            }
        }
    }
}