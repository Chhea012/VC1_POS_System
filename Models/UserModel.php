<?php
// /Models/UserModel.php
require_once 'Database/Database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUsers() {
        $sql = "SELECT u.*, r.role_name 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.role_id";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        $sql = "INSERT INTO users (user_name, email, password, role_id, profile_image, phone_number) 
                VALUES (:user_name, :email, :password, :role_id, :profile_image, :phone_number)";
        try {
            $this->db->query($sql, [
                'user_name' => $data['user_name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role_id' => $data['role_id'],
                'profile_image' => $data['profile_image'],
                'phone_number' => $data['phone_number']
            ]);
        } catch (PDOException $e) {
            error_log("SQL Error (create): " . $e->getMessage());
            throw $e;
        }
    }

    public function getRoles() {
        $result = $this->db->query("SELECT * FROM roles");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->query($sql, ['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getUserById($user_id) {
        $sql = "SELECT u.*, r.role_name 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.role_id 
                WHERE u.user_id = :user_id";
        $stmt = $this->db->query($sql, ['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($user_id, $data) {
        $sql = "UPDATE users SET 
                user_name = :user_name, 
                email = :email, 
                role_id = :role_id, 
                profile_image = :profile_image, 
                phone_number = :phone_number";
        $params = [
            'user_id' => $user_id,
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'profile_image' => $data['profile_image'],
            'phone_number' => $data['phone_number']
        ];

        if (isset($data['password'])) {
            $sql .= ", password = :password";
            $params['password'] = $data['password'];
        }

        $sql .= " WHERE user_id = :user_id";
        try {
            $this->db->query($sql, $params);
        } catch (PDOException $e) {
            error_log("SQL Error (update): " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteUser($user_id) {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $this->db->query($sql, ['user_id' => $user_id]);
    }

    public function getUserByEmail($email) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->db->query($sql, ['email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }
    public function getPasswordUser($userId) {
        try {
            // Prepare the SQL query with a placeholder for the user_id
            $stmt = $this->db->prepare("SELECT password FROM users WHERE user_id = :user_id");
            
            // Bind the actual value of userId to the placeholder
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    
            // Execute the query
            $stmt->execute();
    
            // Fetch the result as an associative array
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Check if a result was found and return the password, or false if no result
            if ($result) {
                return $result['password'];
            } else {
                return false; // No user found with that user_id
            }
        } catch (Exception $e) {
            // Log the error message in case of any exceptions
            error_log("Error fetching password for user with ID $userId: " . $e->getMessage());
            return false;
        }
    }
    
}