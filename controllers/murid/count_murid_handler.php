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

// Now include the view 
include __DIR__ . '/../../views/pengurus/sekretaris/dashboard.php';
