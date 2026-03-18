<?php

// Check the requested page
$page = $_GET['page'] ?? 'home';

// Basic routing
switch ($page) {
    case 'home':
        require_once '../app/views/home.view.php';
        break;
    case 'login':
        require_once '../app/views/login.view.php';
        break;
    case 'register':
        require_once '../app/views/register.view.php';
        break;
    default:
        // Optional 404 page, but default to home for now
        require_once '../app/views/home.view.php';
        break;
}
