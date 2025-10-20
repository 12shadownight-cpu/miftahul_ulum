<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/MuridController.php';

$db = (new Database())->connect();
$controller = new MuridController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_biodata = $_POST['id_biodata'] ?? '';

    $result = $controller->delete($id_biodata);

    $_SESSION['message'] = $result['message'];
    if ($result['success']) {
        header('Location: ./fetch_biodata_handler.php');
    } else {
        header('Location: ../../views/pengurus/sekretaris/data-murid.php');
    }
    exit;
} else {
    header('Location: ../../views/pengurus/sekretaris/data-murid.php');
    exit;
}
