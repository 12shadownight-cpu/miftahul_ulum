<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/ValidasiController.php';

$db = (new Database())->connect();
$controller = new ValidasiController($db);

if (isset($_POST['id_validasi']) && intval($_POST['id_validasi']) > 0) {
    $id = intval($_POST['id_validasi']);
    $result = $controller->delete($id);
    $_SESSION['message'] = $result['message'];
} else {
    $_SESSION['message'] = 'ID tidak valid atau tidak ditemukan.';
}

header('Location: ./fetch_validasi_handler.php');
exit;
?>
