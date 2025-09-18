<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/OrangtuaController.php';

$db = (new Database())->connect();
$controller = new OrangtuaController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_orangtua = $_POST['id_orangtua'] ?? '';

    $result = $controller->delete($id_orangtua);

    $_SESSION['message'] = $result['message'];
    if ($result['success']) {
        header('Location: ../../views/pengurus/sekretaris/data-orangtua.php');
    } else {
        header('Location: ../../views/pengurus/sekretaris/data-orangtua.php');
    }
    exit;
} else {
    header('Location: ../../views/pengurus/sekretaris/data-orangtua.php');
    exit;
}
