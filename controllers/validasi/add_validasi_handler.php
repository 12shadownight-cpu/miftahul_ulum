<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/ValidasiController.php';

$db = (new Database())->connect();
$controller = new ValidasiController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_user'     => $_POST['id_user'] ?? '',
        'id_biodata'  => $_POST['id_biodata'] ?? '',
        'id_orangtua' => $_POST['id_orangtua'] ?? '',
        'hasil'       => $_POST['hasil'] ?? '',
        'keterangan'  => $_POST['keterangan'] ?? ''
    ];

    $result = $controller->create($data);

    $_SESSION['message'] = $result['message'];
    if ($result['success']) {
        header('Location: ../../views/pengurus/sekretaris/tabel-validasi.php');
    } else {
        header('Location: ../../views/pengurus/sekretaris/validasi.php');
    }
    exit;
} else {
    header('Location: ../../views/pengurus/sekretaris/validasi.php');
    exit;
}
?>
