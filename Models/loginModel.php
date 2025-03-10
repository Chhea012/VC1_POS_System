<?php
require_once 'Database/Database.php';

class RegisterModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function authenticate($email, $password) {
        $stmt = $this->db->prepare("
            SELECT a.admin_id, a.password, e.email 
            FROM admins a 
            JOIN employees e ON a.employee_id = e.employee_id 
            WHERE e.email = ?
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}