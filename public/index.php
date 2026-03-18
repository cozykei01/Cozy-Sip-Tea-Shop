<?php
session_start();
require_once '../app/config/database.php';
require_once '../app/models/Product.php';
require_once '../app/models/User.php';

// Check the requested page
$page = $_GET['page'] ?? 'home';

// Basic routing
switch ($page) {
    case 'exchange':
        require_once '../app/models/Product.php';
        $database = new Database();
        $db = $database->getConnection();
        $productModel = new Product($db);
        $exchangeProducts = $productModel->getExchangeProducts();
        require_once '../app/views/exchange.view.php';
        break;
    case 'home':
    default:
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $database = new Database();
        $db = $database->getConnection();
        if ($db) {
             $productModel = new Product($db);
             $eventProducts = $productModel->getEventProducts(0);
        } else {
             $eventProducts = [];
        }
        // echo "Event Products Count: " . count($eventProducts); // Debugging
        require_once '../app/views/home.view.php';
        break;
    case 'login':
        require_once '../app/views/login.view.php';
        break;
    case 'menu':
        // Fetch products for Category 1
        $database = new Database();
        $db = $database->getConnection();
        if ($db) {
            $productModel = new Product($db);
            $products = $productModel->getProductsByCategory(1);
            $coldProducts = $productModel->getProductsByCategory(2);
            $teaProducts = $productModel->getProductsByCategory(3);
            $specialtyProducts = $productModel->getProductsByCategory(4);
            $bakeryProducts = $productModel->getProductsByCategory(5);
        } else {
            $products = [];
            $coldProducts = [];
            $teaProducts = [];
            $specialtyProducts = [];
            $bakeryProducts = [];
        }
        
        require_once '../app/views/menu.view.php';
        break;
    case 'register':
        require_once '../app/views/register.view.php';
        break;
    case 'register_process':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            $userModel = new User($db);

            $validation = $userModel->validate($_POST);

            if ($validation === true) {
                if ($userModel->create($_POST)) {
                    $userData = $userModel->getUserByEmail($_POST['email']);
                    $_SESSION['user_id'] = $userData['user_id'];
                    $_SESSION['user_email'] = $userData['email'];
                    $_SESSION['user_name'] = $userData['full_name'];
                    $_SESSION['user_points'] = $userData['point_balance'];
                    $_SESSION['success'] = "Registration successful! Welcome to Cozy Sip.";
                    header("Location: index.php?page=register");
                    exit();
                } else {
                    $_SESSION['errors'] = ["Something went wrong. Please try again."];
                }
            } else {
                $_SESSION['errors'] = $validation;
            }
            header("Location: index.php?page=register");
            exit();
        }
        break;
    case 'login_process':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            $userModel = new User($db);

            $user = $userModel->login($_POST['email'], $_POST['password']);

            if ($user) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_points'] = $user['point_balance'];
                
                header("Location: index.php?page=home");
                exit();
            } else {
                $_SESSION['errors'] = ["Invalid email or password."];
                header("Location: index.php?page=login");
                exit();
            }
        }
        break;
    case 'logout':
        session_destroy();
        header("Location: index.php?page=home");
        exit();
        break;
    case 'checkout':
        require_once '../app/controllers/OrderController.php';
        $database = new Database();
        $db = $database->getConnection();
        $controller = new OrderController($db);
        $controller->store();
        break;
    case 'exchange_process':
        require_once '../app/controllers/ExchangeController.php';
        $database = new Database();
        $db = $database->getConnection();
        $controller = new ExchangeController($db);
        $controller->process();
        break;
}
