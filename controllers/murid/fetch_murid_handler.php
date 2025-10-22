<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/MuridController.php';

$db = (new Database())->connect();
$controller = new MuridController($db);

// Ambil semua data murid
$allMurid = $controller->getAll();

// Tampilkan berdasarkan request
$view = $_GET['view'] ?? 'murid';

// Tamplikan pada view
if ($view === 'validasi') {
    include __DIR__ . '/../../views/pengurus/sekretaris/validasi.php';
} else {
    include __DIR__ . '/../../views/pengurus/sekretaris/data-murid.php';
}


?>
