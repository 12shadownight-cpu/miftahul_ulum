<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/MuridController.php';

$db = (new Database())->connect();
$controller = new MuridController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi dan pindahkan file upload
    $uploadDir = '../../assets/uploads/';
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    function handleFileUpload($fileKey, $uploadDir, $allowedTypes) {
        if (!isset($_FILES[$fileKey])) return '';

        $file = $_FILES[$fileKey];
        $fileType = $file['type'];
        $fileTmp = $file['tmp_name'];
        $fileName = time() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (!in_array($fileType, $allowedTypes)) {
            return '';
        }

        if (move_uploaded_file($fileTmp, $targetPath)) {
            return $fileName;
        }

        return '';
    }

    $file_akta   = handleFileUpload('file_akta', $uploadDir, $allowedTypes);
    $file_kk     = handleFileUpload('file_kk', $uploadDir, $allowedTypes);
    $file_ijazah = handleFileUpload('file_ijazah', $uploadDir, $allowedTypes);

    $data = [
        'id_user'        => $_POST['id_user'] ?? '',
        'nama'           => $_POST['nama'] ?? '',
        'umur'           => $_POST['umur'] ?? '',
        'jenis_kelamin'  => $_POST['jenis_kelamin'] ?? '',
        'tempat_lahir'   => $_POST['tempat_lahir'] ?? '',
        'tanggal_lahir'  => $_POST['tanggal_lahir'] ?? '',
        'asal_tk'        => $_POST['asal_tk'] ?? '',
        'alamat'         => $_POST['alamat'] ?? '',
        'nik'            => $_POST['nik'] ?? '',
        'no_kk'          => $_POST['no_kk'] ?? '',
        'file_akta'      => $file_akta,
        'file_kk'        => $file_kk,
        'file_ijazah'    => $file_ijazah
    ];

    $result = $controller->create($data);

    $_SESSION['message'] = $result['message'];
    if ($result['success']) {
        header('Location: ./get_biodata_handler.php');
    } else {
        header('Location: ../../views/user/biodata_murid.php');
    }
    exit;
} else {
    header('Location: ../../views/user/biodata_murid.php');
    exit;
}
?>
