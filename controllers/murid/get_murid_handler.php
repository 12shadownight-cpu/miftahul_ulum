<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/MuridController.php';

$db = (new Database())->connect();
$controller = new MuridController($db);

// Ambil semua data murid
$id_user = $_SESSION['id_user'];
$getMurid = $controller->getByUserId($id_user);

// Tamplikan pada view
include __DIR__ . '/../../views/user/biodata_murid.php';
?>
