<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/ValidasiController.php';

$db = (new Database())->connect();
$controller = new ValidasiController($db);

$userId = $_SESSION['user_id'] ?? null;

if ($userId === null) {
    header('Location: ../../views/user/login.php');
    exit;
}

$idValidasi = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$getValidasi = null;

if ($idValidasi > 0) {
    $candidate = $controller->getByValidasiIdWithRelations($idValidasi);
    if ($candidate && (int) ($candidate['id_user'] ?? 0) === (int) $userId) {
        $getValidasi = $candidate;
    }
}

if ($getValidasi === null) {
    $getValidasi = $controller->getByIdWithRelations($userId);
}

include __DIR__ . '/../../views/user/bukti_pendaftaran.php';