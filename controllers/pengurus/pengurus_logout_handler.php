<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengurusController.php';

$db = (new Database())->connect();
$controller = new PengurusController($db);

$result = $controller->logout();
$message = $result['message'] ?? 'Logout berhasil.';

$_SESSION['message'] = $message;
header('Location: ../../views/pengurus/login.php');
exit;

