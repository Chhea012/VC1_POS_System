<?php
require_once "Models/ProfileModel.php";

class ProfileController extends BaseController {
    private $profileModel;

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
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->profileModel->getAdminUser();
            if (!$user) {
                $this->view("error", ["message" => "No admin user found to update."]);
                return;
            }

            $user_id = $user['user_id'];
            $user_name = $_POST['userName'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone_number = $_POST['phoneNumber'] ?? '';
            $address = $_POST['address'] ?? '';
            $city_province = $_POST['province'] ?? '';
            $profile_image = $user['profile_image'];

            if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileTmpPath = $_FILES['profileImage']['tmp_name'];
                $fileName = basename($_FILES['profileImage']['name']);
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($fileExt, $allowedExts)) {
                    $newFileName = uniqid() . '.' . $fileExt;
                    $destPath = $uploadDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $profile_image = '/' . $destPath;
                    } else {
                        $this->view("profile/profile", [
                            "user" => $user,
                            "error" => "Failed to move uploaded image."
                        ]);
                        return;
                    }
                } else {
                    $this->view("profile/profile", [
                        "user" => $user,
                        "error" => "Invalid file type."
                    ]);
                    return;
                }
            }

            if ($this->profileModel->updateUser($user_id, $user_name, $email, $phone_number, $address, $city_province, $profile_image)) {
                header("Location: /profile?success=Profile updated successfully");
                exit();
            } else {
                $this->view("profile/profile", [
                    "user" => $this->profileModel->getAdminUser(),
                    "error" => "Failed to update profile."
                ]);
            }
        } else {
            header("Location: /profile?error=Invalid request");
            exit();
        }
    }

    // Update password
    public function updatePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->profileModel->getAdminUser();
            if (!$user) {
                $this->view("error", ["message" => "No admin user found to update."]);
                return;
            }

            $user_id = $user['user_id'];
            $currentPassword = $_POST['currentPassword'] ?? '';
            $newPassword = $_POST['newPassword'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            // Validate current password
            if (!password_verify($currentPassword, $user['password'])) {
                $this->view("profile/security", [
                    "user" => $user,
                    "error" => "Current password is incorrect."
                ]);
                return;
            }

            // Validate new password
            if ($newPassword !== $confirmPassword) {
                $this->view("profile/security", [
                    "user" => $user,
                    "error" => "New password and confirmation do not match."
                ]);
                return;
            }

            if (strlen($newPassword) < 8 || !preg_match("/[a-z]/", $newPassword) || !preg_match("/[0-9]|[!@#$%^&* ]/", $newPassword)) {
                $this->view("profile/security", [
                    "user" => $user,
                    "error" => "New password must be at least 8 characters, with one lowercase letter and one number or symbol."
                ]);
                return;
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            if ($this->profileModel->updatePassword($user_id, $hashedPassword)) {
                header("Location: /security?success=Password updated successfully");
                exit();
            } else {
                $this->view("profile/security", [
                    "user" => $user,
                    "error" => "Failed to update password."
                ]);
            }
        } else {
            header("Location: /security?error=Invalid request");
            exit();
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accountActivation'])) {
            $user = $this->profileModel->getAdminUser();
            if (!$user) {
                header("Location: /profile?error=No admin user found to delete");
                exit();
            }
            $user_id = $user['user_id'];
            if ($this->profileModel->deleteUser($user_id)) {
                header("Location: /profile?success=Account deleted successfully");
                exit();
            } else {
                header("Location: /profile?error=Failed to delete account");
                exit();
            }
        } else {
            header("Location: /profile?error=Confirmation required");
            exit();
        }
    }
}