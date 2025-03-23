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
      // Update user data including profile image and password
      public function update($user_id, $data) {
        $sql = "UPDATE users SET 
                user_name = :user_name, 
                email = :email, 
                role_id = :role_id, 
                phone_number = :phone_number";
    
        $params = [
            ':user_name' => $data['user_name'],
            ':email' => $data['email'],
            ':role_id' => $data['role_id'],
            ':phone_number' => $data['phone_number']
        ];
    
        // Debugging: Check the incoming data
        error_log("Profile Image Data: " . print_r($data['profile_image'], true));
    
        // Add profile image if available
        if (!empty($data['profile_image'])) {
            $sql .= ", profile_image = :profile_image";
            $params[':profile_image'] = $data['profile_image'];
        }
    
        // Check if password needs updating
        if (!empty($data['password'])) {
            $sql .= ", password = :password";
            $params[':password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
    
        $sql .= " WHERE user_id = :user_id";
        $params[':user_id'] = $user_id;
    
        try {
            $stmt = $this->db->getConnection()->prepare($sql); // Use getConnection() to get PDO instance
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            error_log("SQL Query: " . $sql);
            error_log("SQL Params: " . print_r($params, true));
            throw $e;
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