<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/ValidasiController.php';

$db = (new Database())->connect();
$controller = new ValidasiController($db);

// Ambil semua data validasi beserta relasi
$id_user = $_SESSION['user_id'] ?? null;
if ($id_user === null) {
    header('Location: ../../views/user/login.php');
    exit;
}
$getValidasi = $controller->getByIdWithRelations($id_user);

// Tampilkan di view
include __DIR__ . '/../../views/user/hasil_validasi.php';
?>
