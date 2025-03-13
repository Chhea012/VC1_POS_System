<?php
require_once "Database/Database.php";

class EditprofileModel {
    private $pdo;

    function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Get specific user by ID (fixed to retrieve a single user)
    function getUser($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return single user as associative array
    }

    // Get all users (fixed to use PDO::FETCH_ASSOC)
    function getUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all users as array of associative arrays
    }

    // Update user (uncommented and fixed)
    function updateUser($id, $userName, $phoneNumber, $address, $language, $province)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET user_name = ?, phone_number = ?, address = ?, language = ?, province = ? WHERE id = ?");
        $stmt->execute([$userName, $phoneNumber, $address, $language, $province, $id]);
        return $stmt->rowCount() > 0; // Return true if update was successful
    }
}