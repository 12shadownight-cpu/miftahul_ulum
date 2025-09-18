<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengumumanController.php';

$db = (new Database())->connect();
$controller = new PengumumanController($db);

// Ambil semua data pengumuman beserta info pengurus
$allPengumuman = $controller->getAllWithPengurus();

// Tampilkan di view
include __DIR__ . '/../../views/pengurus/admin/data-pengumuman.php';
?>
