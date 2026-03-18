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
}
