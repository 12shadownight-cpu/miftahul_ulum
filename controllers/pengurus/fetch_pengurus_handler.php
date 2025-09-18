<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengurusController.php';

$db = (new Database())->connect();
$controller = new PengurusController($db);

// Ambil semua data pengurus
$allPengurus = $controller->getAll();

if ($allPengurus === false || !is_array($allPengurus)) {
    $allPengurus = []; // fallback to empty array
    $_SESSION['message'] = "No data found or failed to fetch pengurus data.";
}

// Tampilkan di view
include __DIR__ . '/../../views/pengurus/admin/data-pengurus.php';

