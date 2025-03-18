<?php
// /Models/ProfileModel.php
require_once "Database/Database.php";

class ProfileModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    
    // Fetch the first admin user with role name
    public function getAdminUser() {
        try {
            $stmt = $this->db->query("
                SELECT u.user_id, u.user_name, u.email, u.profile_image, u.phone_number, r.role_name
                FROM users u 
                JOIN roles r ON u.role_id = r.role_id 
                WHERE r.role_name = 'admin' 
                ORDER BY u.user_id ASC 
                LIMIT 1
            ");
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching admin user: " . $e->getMessage());
            return false;
        }
    }

    // Update user data including profile image
    public function updateUser($user_id, $data) {
        try {
            $sql = "UPDATE users 
                    SET user_name = :user_name, 
                        email = :email, 
                        phone_number = :phone_number, 
                        profile_image = :profile_image
                    WHERE user_id = :user_id";
            $params = [
                ':user_name' => $data['user_name'],
                ':email' => $data['email'],
                ':phone_number' => $data['phone_number'],
                ':profile_image' => $data['profile_image'],
                ':user_id' => $user_id
            ];
            $this->db->query($sql, $params);
            return true;
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            throw $e; // Throw exception to be caught in controller
        }
    }
    public function getPasswordUser($userId) {
        // Fetch the user's password from the database based on the user_id
        try {
            $stmt = $this->db->prepare("SELECT password FROM users WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching user password: " . $e->getMessage());
            return false;
        }
    }
    public function updatePassword($userId, $newHashedPassword) {
        // Update the user's password in the database
        try {
            $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
            $stmt->bindParam(':password', $newHashedPassword);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error updating user password: " . $e->getMessage());
            return false;
        }
    }
}