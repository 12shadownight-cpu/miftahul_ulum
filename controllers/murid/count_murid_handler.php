<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/MuridController.php';
require_once __DIR__ . '/../validasi/ValidasiController.php';

$db = (new Database())->connect();
$muridController = new MuridController($db);
$validasiController = new ValidasiController($db);

// Get counts of result by hasil
$totals = $muridController->getCounts();
$counts = $validasiController->getCounts();

$counts = array_merge($counts, [
    'id_biodata' => ($totals['laki-laki'] ?? 0) + ($totals['perempuan'] ?? 0),
    'hasil'    => ($counts['diterima'] ?? 0) + ($counts['ditolak'] ?? 0),
]);

// Now include the view 
include __DIR__ . '/../../views/pengurus/sekretaris/dashboard.php';
