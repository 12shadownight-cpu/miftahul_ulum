<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengumumanController.php';

$db = (new Database())->connect();
$controller = new PengumumanController($db);

$pengurusStatus = $_SESSION['pengurus_status'] ?? null;
$pengurusId = $_SESSION['pengurus_id'] ?? null;

if($pengurusStatus !== 'admin') {
    header('location: ../../views/pengurus/login.php');
    exit;
}

// Ambil semua data pengumuman berdasarkan ID pengurus
$getPengumuman = [];
if($pengurusId !== null) {
    $getPengumuman = $controller->getAllByPengurus((int) $pengurusId);
}

// Tampilkan di view
include __DIR__ . '/../../views/pengurus/admin/input-pengumuman.php';
?>