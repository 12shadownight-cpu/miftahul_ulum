<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengurusController.php';

$db = (new Database())->connect();
$controller = new PengurusController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama'     => $_POST['nama'] ?? '',
        'username' => $_POST['username'] ?? '',
        'password' => $_POST['password'] ?? '',
        'email'    => $_POST['email'] ?? '',
        'no_hp'    => $_POST['no_hp'] ?? '',
        'status'   => $_POST['status'] ?? ''
    ];

    $result = $controller->create($data);

    if ($result['success']) {
        // Redirect back to admin dashboard with success
        $_SESSION['message'] = $result['message'];
        header('Location: ../views/pengurus/admin/data-pengurus.php');
        exit;
    } else {
        // Redirect back to registration form with error
        $_SESSION['message'] = $result['message'];
        header('Location: ../views/pengurus/admin/input-pengurus.php');
        exit;
    }
} else {
    header('Location: ../views/pengurus/admin/input-pengurus.php');
    exit;
}

