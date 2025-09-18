<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/OrangtuaController.php';

$db = (new Database())->connect();
$controller = new OrangtuaController($db);

// Ambil semua data murid
$id_user = $_SESSION['id_user'];
$getOrangtua = $controller->getByUserId($id_user);

// Tampilkan pada view
include __DIR__ . '/../../views/user/biodata_orangtua.php';
?>
