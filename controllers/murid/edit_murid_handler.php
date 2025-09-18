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

    function handleFileUpload($fileKey, $uploadDir, $allowedTypes, $existingFile) {
        if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] === 4) {
            return $existingFile; // Gunakan file lama jika tidak ada file baru
        }

        $file = $_FILES[$fileKey];
        $fileType = $file['type'];
        $fileTmp = $file['tmp_name'];
        $fileName = time() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (!in_array($fileType, $allowedTypes)) {
            return $existingFile;
        }

        if (move_uploaded_file($fileTmp, $targetPath)) {
            return $fileName;
        }

        return $existingFile;
    }

    $existing_akta   = $_POST['existing_file_akta'] ?? '';
    $existing_kk     = $_POST['existing_file_kk'] ?? '';
    $existing_ijazah = $_POST['existing_file_ijazah'] ?? '';

    $file_akta   = handleFileUpload('file_akta', $uploadDir, $allowedTypes, $existing_akta);
    $file_kk     = handleFileUpload('file_kk', $uploadDir, $allowedTypes, $existing_kk);
    $file_ijazah = handleFileUpload('file_ijazah', $uploadDir, $allowedTypes, $existing_ijazah);

    $data = [
        'id_biodata'     => $_POST['id_biodata'] ?? '',
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

    $result = $controller->update($data);

    $_SESSION['message'] = $result['message'];
    if ($result['success']) {
        header('Location: ../../views/user/biodata_murid.php');
    } else {
        header('Location: ../../views/user/biodata_murid.php');
    }
    exit;
} else {
    header('Location: ../../views/user/biodata_murid.php');
    exit;
}
?>
