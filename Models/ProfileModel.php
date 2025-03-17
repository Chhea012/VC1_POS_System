<?php
require_once "Database/Database.php";

class ProfileModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Fetch the first admin user
    public function getAdminUser() {
        try {
            $stmt = $this->db->query("
                SELECT u.user_id, u.user_name, u.email, u.profile_image, u.phone_number
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

    // Update user data
    public function updateUser($user_id, $user_name, $email, $phone_number, $address, $city_province) {
        try {
            $stmt = $this->db->query("
                UPDATE users 
                SET user_name = :user_name, email = :email, phone_number = :phone_number 
                WHERE user_id = :user_id
            ", [
                ':user_name' => $user_name,
                ':email' => $email,
                ':phone_number' => $phone_number,
                ':user_id' => $user_id
            ]);
            return true;
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    // Delete user
    public function deleteUser($user_id) {
        try {
            $stmt = $this->db->query("DELETE FROM users WHERE user_id = :user_id", [':user_id' => $user_id]);
            return true;
        } catch (Exception $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }
}