<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/ValidasiController.php';

$db = (new Database())->connect();
$controller = new ValidasiController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_validasi' => $_POST['id_validasi'] ?? '',
        'hasil'       => $_POST['hasil'] ?? '',
        'keterangan'  => $_POST['keterangan'] ?? ''
    ];

    $result = $controller->update($data);

    $_SESSION['message'] = $result['message'];
    if ($result['success']) {
        header('Location: ./fetch_validasi_handler.php');
    } else {
        header('Location: ./fetch_validasi_handler.php');
    }
    exit;
} else {
    header('Location: ../../views/pengurus/sekretaris/tabel-validasi.php');
    exit;
}
?>
