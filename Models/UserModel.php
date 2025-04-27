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

    // New method to fetch only the logged-in user's data
    public function getCurrentUser($user_id) {
        $sql = "SELECT u.*, r.role_name 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.role_id 
                WHERE u.user_id = :user_id";
        $stmt = $this->db->query($sql, ['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function hasAdmin() {
        $sql = "SELECT COUNT(*) FROM users WHERE role_id = :role_id";
        $stmt = $this->db->query($sql, ['role_id' => 1]);
        return $stmt->fetchColumn() > 0;
    }

    public function isAdmin($user_id) {
        $sql = "SELECT role_id FROM users WHERE user_id = :user_id";
        $stmt = $this->db->query($sql, ['user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user && $user['role_id'] == 1;
    }

    public function createUser($data) {
        $sql = "INSERT INTO users (user_name, email, password, role_id, profile_image, phone_number) 
                VALUES (:user_name, :email, :password, :role_id, :profile_image, :phone_number)";
        try {
            $this->db->query($sql, [
                'user_name' => $data['user_name'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_BCRYPT),
                'role_id' => $data['role_id'],
                'profile_image' => $data['profile_image'] ?? null,
                'phone_number' => $data['phone_number'] ?? null
            ]);
            return true;
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
            ':phone_number' => $data['phone_number'] ?? null,
            ':user_id' => $user_id
        ];

        if (!empty($data['profile_image'])) {
            $sql .= ", profile_image = :profile_image";
            $params[':profile_image'] = $data['profile_image'];
        }

        if (!empty($data['password'])) {
            $sql .= ", password = :password";
            $params[':password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $sql .= " WHERE user_id = :user_id";

        try {
            $pdo = $this->db->getConnection();
            $stmt = $pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("SQL Error (update): " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteUser($user_id) {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        try {
            $this->db->query($sql, ['user_id' => $user_id]);
            return true;
        } catch (PDOException $e) {
            error_log("SQL Error (delete): " . $e->getMessage());
            throw $e;
        }
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->query($sql, ['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>