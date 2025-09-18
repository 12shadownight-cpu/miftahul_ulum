<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/MuridController.php';

$db = (new Database())->connect();
$controller = new MuridController($db);

// Get counts of result by hasil
$totals = $controller->getCounts();

// Now include the view 
include __DIR__ . '/../../views/pengurus/sekretaris/dashboard.php';
