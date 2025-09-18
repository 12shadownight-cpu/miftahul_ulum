<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/MuridController.php';

$db = (new Database())->connect();
$controller = new MuridController($db);

// Ambil semua data murid
$allMurid = $controller->getAll();

// Tamplikan pada view
include __DIR__ . '/../../views/pengurus/sekretaris/data-murid.php';
?>
