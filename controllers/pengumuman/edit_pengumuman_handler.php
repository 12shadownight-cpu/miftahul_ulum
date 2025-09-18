<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/PengumumanController.php';

// Initialize DB & Controller
$db = (new Database())->connect();
$controller = new PengumumanController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input values
    $data = [
        'id_pengumuman' => isset($_POST['id_pengumuman']) ? intval($_POST['id_pengumuman']) : 0,
        'judul'         => isset($_POST['judul']) ? trim(strip_tags($_POST['judul'])) : '',
        'deskripsi'     => isset($_POST['deskripsi']) ? trim(strip_tags($_POST['deskripsi'])) : '',
    ];

    // Check if a file was uploaded
    $file = (isset($_FILES['file_pendukung']) && $_FILES['file_pendukung']['error'] !== UPLOAD_ERR_NO_FILE)
        ? $_FILES['file_pendukung']
        : null;

    // Update record using controller
    $result = $controller->update($data, $file);

    // Store feedback message and type
    $_SESSION['message'] = $result['message'];
    $_SESSION['message_type'] = $result['success'] ? 'success' : 'error';

    // Always redirect back to the data list
    header('Location: ../../views/pengurus/admin/data-pengumuman.php');
    exit;
}

// Fallback if not a POST request
header('Location: ../../views/pengurus/admin/data-pengumuman.php');
exit;
