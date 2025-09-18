<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengumumanController.php';

// Initialize DB & Controller
$db = (new Database())->connect();
$controller = new PengumumanController($db);

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input values
    $data = [
        'id_pengurus' => isset($_POST['id_pengurus']) ? intval($_POST['id_pengurus']) : 0,
        'judul'       => isset($_POST['judul']) ? trim(strip_tags($_POST['judul'])) : '',
        'deskripsi'   => isset($_POST['deskripsi']) ? trim(strip_tags($_POST['deskripsi'])) : '',
    ];

    // Handle file if uploaded
    $file = (isset($_FILES['file_pendukung']) && $_FILES['file_pendukung']['error'] !== UPLOAD_ERR_NO_FILE)
        ? $_FILES['file_pendukung']
        : null;

    // Call controller method
    $result = $controller->create($data, $file);

    // Store feedback message in session
    $_SESSION['message'] = $result['message'];
    $_SESSION['message_type'] = $result['success'] ? 'success' : 'error';

    // Redirect based on outcome
    $redirect = $result['success']
        ? '../../views/pengurus/admin/data-pengumuman.php'
        : '../../views/pengurus/admin/input-pengumuman.php';

    header('Location: ' . $redirect);
    exit;
}

// Fallback for non-POST requests
header('Location: ../../views/pengurus/admin/input-pengumuman.php');
exit;
