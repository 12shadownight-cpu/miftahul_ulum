<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/ValidasiController.php';

$db = (new Database())->connect();
$controller = new ValidasiController($db);

// Ambil semua data validasi beserta relasi
$allValidasi = $controller->getAllWithRelations();

// Tampilkan di view
include __DIR__ . '/../../views/pengurus/sekretaris/tabel-validasi.php';
?>
