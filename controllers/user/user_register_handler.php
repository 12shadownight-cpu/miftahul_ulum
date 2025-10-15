<?php
// Start Session
session_start();

// Load database configuration
require_once __DIR__ . '/../../config/Database.php';

// Load the controller
require_once __DIR__ . '/UserController.php';

// Create the database connection
$db = (new Database())->connect();

// Create the controller
$controller = new UserController($db);

// Check request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama'     => trim($_POST['nama'] ?? ''),
        'username' => trim($_POST['username'] ?? ''),
        'password' => trim($_POST['password'] ?? ''),
        'email'    => trim($_POST['email'] ?? ''),
        'no_hp'    => trim($_POST['no_hp'] ?? '')
    ];

    $result = $controller->register($data);

    // Store message using scoped session key
    $_SESSION['register_message'] = $result['message'];

    // Redirect to appropriate page
    $redirect = $result['success']
        ? '../../views/user/login.php'
        : '../../views/user/register.php';

    header("Location: $redirect");
    exit;
} else {
    // If accessed without POST, redirect back to register
    header('Location: ../../views/user/register.php');
    exit;
}
?>
