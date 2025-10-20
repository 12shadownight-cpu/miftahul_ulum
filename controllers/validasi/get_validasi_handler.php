<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/ValidasiController.php';

$db = (new Database())->connect();
$controller = new ValidasiController($db);

// Ambil semua data validasi beserta relasi
$id_user = $_SESSION['id_user'] ?? null;
$getValidasi = $controller->getByIdWithRelations($id_user);

// Tampilkan di view
include __DIR__ . '/../../views/user/hasil_validasi.php';
include __DIR__ . '/../../views/user/bukti_pendaftaran.php';
?>
