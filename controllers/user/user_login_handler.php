<?php
// Start Session
session_start();

// Load database configuration
require_once __DIR__ . '/../../config/Database.php';

// Load the controller
require_once __DIR__ . '/UserController.php';

// Create the database connection
$db = (new Database())->connect();

// Create the controller with the database
$controller = new UserController($db);

//Prevent from hitting login form again
if (isset($_SESSION['user_id'])) {
    header('Location: ../../views/user/notice.php');
    exit;
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'username' => trim($_POST['username'] ?? ''),
        'password' => trim($_POST['password'] ?? '')
    ];

    $result = $controller->login($data);

    if ($result['success']) {
        // Redirect to user notice page after login
        header('Location: ../../views/user/notice.php');
        exit;
    } else {
        // Redirect back to login form with error message
        $_SESSION['login_message'] = $result['message'];
        header('Location: ../../views/user/login.php');
        exit;
    }
} else {
    // If accessed without POST, redirect back to login
    header('Location: ../../views/user/login.php');
    exit;
}
?>
