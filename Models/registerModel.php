<?php
require_once 'Database/Database.php';

class RegisterModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getRoles() {
        $result = $this->db->query("SELECT * FROM roles");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        $sql = "INSERT INTO users (user_name, email, password, role_id, profile_image, phone_number) 
                VALUES (:user_name, :email, :password, :role_id, :profile_image, :phone_number)";
        try {
            $this->db->query($sql, [
                'user_name' => $data['user_name'],
                'email' => $data['email'],
                'password' => $data['password'], // Already hashed
                'role_id' => $data['role_id'],
                'profile_image' => $data['profile_image'],
                'phone_number' => $data['phone_number']
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("SQL Error (create): " . $e->getMessage());
            throw $e;
        }
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->query($sql, ['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}