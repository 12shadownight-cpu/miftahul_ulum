<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/UserController.php';

$db = (new Database())->connect();
$controller = new UserController($db);

$controller->logout();
header('Location: ../views/user/login.php');
exit;
?>
