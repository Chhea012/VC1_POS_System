<?php
require_once "Models/ProfileModel.php";

class ProfileController extends BaseController {
    private $profileModel;
    private $user;

    public function __construct() {
        $this->profileModel = new ProfileModel();
    }

    // Profile page (with image)
    public function index() {
        $user = $this->profileModel->getAdminUser();
        if (!$user) {
            $this->view("error", ["message" => "No admin user found in the database."]);
            return;
        }
        $this->view("profile/profile", ["user" => $user]);
    }

    // Security page (with password change)
    public function security() {
        $user = $this->profileModel->getAdminUser();
        if (!$user) {
            $this->view("error", ["message" => "No admin user found in the database."]);
            return;
        }
        $this->view("profile/security", ["user" => $user]);
    }

    // Update profile (including image)
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
                'phone_number' => $_POST['phone_number'] ?? ''
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
}