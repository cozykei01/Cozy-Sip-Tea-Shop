<?php

require_once '../app/models/User.php';
require_once '../app/models/Order.php';
require_once '../app/models/Exchange.php';

class ProfileController {
    private $userModel;
    private $orderModel;
    private $exchangeModel;

    public function __construct($db) {
        $this->userModel = new User($db);
        $this->orderModel = new Order($db);
        $this->exchangeModel = new Exchange($db);
    }

    /**
     * Display the user profile page
     */
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);
        
        if (!$user) {
            session_destroy();
            header("Location: index.php?page=login");
            exit();
        }

        $orders = $this->orderModel->getOrdersByUser($userId);
        $exchanges = $this->exchangeModel->getExchangesByUser($userId);

        // Update session points just in case
        $_SESSION['user_points'] = $user['point_balance'];

        $activePage = 'profile';
        require_once '../app/views/profile.view.php';
    }

    /**
     * Handle profile image upload
     */
    public function uploadProfileImage() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['profile_image'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $file = $_FILES['profile_image'];

        // Validate file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and WebP are allowed.']);
            return;
        }

        if ($file['size'] > 2 * 1024 * 1024) { // 2MB limit
            echo json_encode(['success' => false, 'message' => 'File size too large. Max 2MB.']);
            return;
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . $userId . '_' . time() . '.' . $extension;
        $targetPath = 'assets/uploads/profiles/' . $filename;
        $fullTargetPath = '../public/' . $targetPath;

        // Move file
        if (move_uploaded_file($file['tmp_name'], $fullTargetPath)) {
            // Delete old image if exists
            $user = $this->userModel->getUserById($userId);
            if (!empty($user['profile_image']) && file_exists('../public/' . $user['profile_image'])) {
                unlink('../public/' . $user['profile_image']);
            }

            // Update database
            if ($this->userModel->updateProfileImage($userId, $targetPath)) {
                $_SESSION['user_profile_img'] = $targetPath;
                echo json_encode([
                    'success' => true, 
                    'message' => 'Profile image updated successfully',
                    'image_path' => $targetPath
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update database']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
        }
    }
}
