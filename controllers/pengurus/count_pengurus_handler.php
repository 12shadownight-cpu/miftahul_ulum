<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengurusController.php';
require_once __DIR__ . '/../user/UserController.php';
require_once __DIR__ . '/../pengumuman/PengumumanController.php';

$db = (new Database())->connect();
$pengurusController = new PengurusController($db);
$userController = new UserController($db);
$pengumumanController = new PengumumanController($db);

// Build a consolidated metrics array for the admin dashboard
$pengurusCounts = $pengurusController->getCounts();
$counts = [
    'users' => (int) $userController->getTotalUsers(),
    'admins' => $pengurusCounts['admins'] ?? 0,
    'sekretaris' => $pengurusCounts['sekretaris'] ?? 0,
    'pengumuman' => (int) $pengumumanController->countAllPengumuman(),
];

// Render the admin dashboard with the aggregated counts
include __DIR__ . '/../../views/pengurus/admin/dashboard.php';
