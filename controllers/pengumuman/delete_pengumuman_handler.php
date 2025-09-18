<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengumumanController.php';

// Initialize DB & Controller
$db = (new Database())->connect();
$controller = new PengumumanController($db);

if (isset($_GET['id']) && ctype_digit($_GET['id']) && intval($_GET['id']) > 0) {
    $id = intval($_GET['id']);

    // Delete record using controller
    $result = $controller->delete($id);

    // Store feedback message and type
    $_SESSION['message'] = $result['message'];
    $_SESSION['message_type'] = $result['success'] ? 'success' : 'error';
} else {
    // Invalid ID provided
    $_SESSION['message'] = 'ID pengumuman tidak valid.';
    $_SESSION['message_type'] = 'error';
}

// Redirect back to the data list
header('Location: ../../views/pengurus/admin/data-pengumuman.php');
exit;
