<?php
require_once 'Database/Database.php';

class LoginModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    
}

