<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/OrangtuaController.php';

$db = (new Database())->connect();
$controller = new OrangtuaController($db);

// Ambil semua data murid
$allOrangtua = $controller->getAll();

// Tampilkan pada view
include __DIR__ . '/../../views/pengurus/sekretaris/data-orangtua.php';
?>
