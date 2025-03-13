<?php
require_once "Models/EditprofileModel.php";

class EditProfileController extends BaseController {
    private $model;

    function __construct()
    {
        $this->model = new EditprofileModel();
    }

    function index()
    {
        // Assuming user ID is stored in session or passed as parameter
        $userId = $_SESSION['user_id'] ?? 1; // Replace with your actual user ID retrieval method

        // Get the specific user's data
        $user = $this->model->getUser($userId);

        // If user not found, set default empty values
        if (!$user) {
            $user = [
                'user_name' => '',
                'phone_number' => '',
                'address' => '',
                'language' => '',
                'province' => ''
            ];
        }

        // Pass the user data to the view
        require_once "Views/edit_profile.php";
    }

    // Uncommented and fixed update method
    function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? $_SESSION['user_id']; // Get user ID from POST or session
            $userName = $_POST['userName'] ?? '';
            $phoneNumber = $_POST['phoneNumber'] ?? '';
            $address = $_POST['address'] ?? '';
            $language = $_POST['language'] ?? '';
            $province = $_POST['province'] ?? '';

            $success = $this->model->updateUser($id, $userName, $phoneNumber, $address, $language, $province);

            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'User updated successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'User update failed']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
    }
}