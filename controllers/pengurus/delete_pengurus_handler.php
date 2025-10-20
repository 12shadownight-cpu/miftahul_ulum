<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengurusController.php';

$db = (new Database())->connect();
$controller = new PengurusController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pengurus'])) {
    $id = $_POST['id_pengurus'];

    $result = $controller->delete($id, $_SESSION['pengurus_status']);

    $_SESSION['message'] = $result['message'];
    header('Location: ./fetch_pengurus_handler.php');
    exit;
} else {
    header('Location: ../../views/pengurus/admin/data-pengurus.php');
    exit;
}

