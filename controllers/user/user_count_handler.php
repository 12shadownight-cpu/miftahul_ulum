<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/UserController.php';

$db = (new Database())->connect();
$controller = new UserController($db);

// Get total users
$totalUsers = $controller->getTotalUsers();

// Include them in Dashboard
include __DIR__ . '/../../views/pengurus/admin/dashboard.php'
?>