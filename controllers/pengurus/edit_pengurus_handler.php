<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengurusController.php';

$db = (new Database())->connect();
$controller = new PengurusController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_pengurus'] ?? '';

    //Periksa ID
    if (empty($id)) {
        $_SESSION['message'] = "Invalid request: ID is missing.";
        header('Location: ../../views/pengurus/admin/data-pengurus.php');
        exit;
    }

    $data = [
        'nama_pengurus' => $_POST['nama_pengurus'] ?? '',
        'username'      => $_POST['username'] ?? '',
        'password'      => $_POST['password'] ?? '',
        'email'         => $_POST['email'] ?? '',
        'no_hp'         => $_POST['no_hp'] ?? '',
        'status'        => $_POST['status'] ?? ''
    ];

    $result = $controller->update($id, $data);

    //Redirect back to data pengurus
    $_SESSION['message'] = $result['message'];
    header('Location: ./fetch_pengurus_handler.php');
    exit;
} else {
    header('Location: ../../views/pengurus/admin/data-pengurus.php');
    exit;
}

