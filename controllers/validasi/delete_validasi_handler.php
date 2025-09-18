<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/ValidasiController.php';

$db = (new Database())->connect();
$controller = new ValidasiController($db);

if (isset($_GET['id']) && intval($_GET['id']) > 0) {
    $id = intval($_GET['id']);
    $result = $controller->delete($id);
    $_SESSION['message'] = $result['message'];
} else {
    $_SESSION['message'] = 'ID tidak valid atau tidak ditemukan.';
}

header('Location: ../../views/pengurus/sekretaris/tabel-validasi.php');
exit;
?>
