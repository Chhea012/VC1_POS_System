<?php
require_once 'Database/Database.php';

class RegisterModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getRoles() {
        $sql = "SELECT role_id, role_name FROM roles";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        $sql = "INSERT INTO users (user_name, email, password, role_id, profile_image, phone_number) 
                VALUES (:user_name, :email, :password, :role_id, :profile_image, :phone_number)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user_name' => $data['user_name'],
                ':email' => $data['email'],
                ':password' => $data['password'],
                ':role_id' => $data['role_id'],
                ':profile_image' => $data['profile_image'],
                ':phone_number' => $data['phone_number']
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("SQL Error (createUser): " . $e->getMessage());
            throw new Exception("Database error: Unable to create user.");
        }
    }

    public function getUserByEmail($email) {
        $sql = "SELECT user_id, email FROM users WHERE email = :email";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("SQL Error (getUserByEmail): " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser($userId) {
        try {
            // Fetch the user's profile image filename
            $sql = "SELECT profile_image FROM users WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                throw new Exception("User not found.");
            }

            // Delete the user from the database
            $sql = "DELETE FROM users WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId]);

            // Remove the profile image file if it exists
            $imagePath = 'views/assets/uploads/' . $user['profile_image'];
            if ($user['profile_image'] && file_exists($imagePath)) {
                if (!unlink($imagePath)) {
                    error_log("Failed to delete image file: $imagePath");
                }
            }
            return true;
        } catch (PDOException $e) {
            error_log("SQL Error (deleteUser): " . $e->getMessage());
            throw new Exception("Database error: Unable to delete user.");
        } catch (Exception $e) {
            error_log("Error (deleteUser): " . $e->getMessage());
            throw $e;
        }
    }
}