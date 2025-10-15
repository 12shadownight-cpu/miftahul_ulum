<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengurusController.php';

$db = (new Database())->connect();;
$controller = new PengurusController($db);

$result = $controller->logout();

$_SESSION['message'] = $result['message'] ?? 'Logout berhasil.';
header('Location: ../../views/pengurus/login.php');
exit;

