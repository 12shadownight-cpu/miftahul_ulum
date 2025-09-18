<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengurusController.php';

$db = (new Database())->connect();
$controller = new PengurusController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'username' => $_POST['username'] ?? '',
        'password' => $_POST['password'] ?? ''
    ];

    $result = $controller->login($data);

    if ($result['success']) {
        $status = $_SESSION['pengurus_status'] ?? '';

        // Redirect based on role
        if ($status === 'admin') {
            header('Location: ../views/pengurus/admin/dashboard.php');
        } elseif ($status === 'sekretaris') {
            header('Location: ../views/pengurus/sekretaris/dashboard.php');
        } else {
            $_SESSION['message'] = 'Status pengurus tidak valid!';
            header('Location: ../views/pengurus/login.php');
        }
        exit;
    } else {
        // Redirect back with error
        $_SESSION['message'] = $result['message'];
        header('Location: ../views/pengurus/login.php');
        exit;
    }
    exit;
} else {
    header('Location: ../views/pengurus/login.php');
    exit;
}

