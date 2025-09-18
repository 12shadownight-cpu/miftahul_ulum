<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengurusController.php';

$db = (new Database())->connect();
$controller = new PengurusController($db);

// Get counts of pengurus by status
$counts = $controller->getCounts();

// Now include the view and you can access $counts['admins'] and $counts['sekretaris'] in that view
include __DIR__ . '/../../views/pengurus/admin/dashboard.php';
