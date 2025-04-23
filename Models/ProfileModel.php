<?php
// /Models/ProfileModel.php
require_once "Database/Database.php";

class ProfileModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Fetch user by ID with role name
    public function getUserById($user_id) {
        try {
            $stmt = $this->db->query("
                SELECT u.user_id, u.user_name, u.email, u.profile_image, u.phone_number, r.role_name
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.role_id 
                WHERE u.user_id = :user_id
            ", [':user_id' => $user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching user: " . $e->getMessage());
            return false;
        }
    }

    // Check if email is already used by another user
    public function isEmailTaken($email, $user_id) {
        try {
            $stmt = $this->db->query("
                SELECT user_id FROM users 
                WHERE email = :email AND user_id != :user_id
            ", [':email' => $email, ':user_id' => $user_id]);
            return $stmt->fetch() !== false;
        } catch (Exception $e) {
            error_log("Error checking email: " . $e->getMessage());
            return false;
        }
    }

    // Update user data including profile image
    public function update($user_id, $data) {
        try {
            $sql = "UPDATE users SET 
                    user_name = :user_name, 
                    email = :email, 
                    phone_number = :phone_number";

            $params = [
                ':user_name' => $data['user_name'],
                ':email' => $data['email'],
                ':phone_number' => $data['phone_number'],
                ':user_id' => $user_id
            ];

            if (!empty($data['profile_image'])) {
                $sql .= ", profile_image = :profile_image";
                $params[':profile_image'] = $data['profile_image'];
            }

            $sql .= " WHERE user_id = :user_id";

            $stmt = $this->db->getConnection()->prepare($sql);
            return $stmt->execute($params);
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            throw new Exception("Failed to update profile: " . $e->getMessage());
        }
    }
}
?>