<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/ValidasiController.php';
require_once __DIR__ . '/../murid/MuridController.php';

$db = (new Database())->connect();
$validasiController = new ValidasiController($db);
$muridController = new MuridController($db);

// Get counts of result by hasil
$counts = $validasiController->getCounts();

// Get totals of murid gender
$totals = $muridController->getCounts();

// Now include the view 
include __DIR__ . '/../../views/pengurus/sekretaris/dashboard.php';
