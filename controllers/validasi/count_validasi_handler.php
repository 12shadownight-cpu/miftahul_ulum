<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/ValidasiController.php';

$db = (new Database())->connect();
$controller = new ValidasiController($db);

// Get counts of result by hasil
$counts = $controller->getCounts();

// Now include the view 
include __DIR__ . '/../../views/pengurus/sekretaris/dashboard.php';
