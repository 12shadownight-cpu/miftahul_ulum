<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/OrangtuaController.php';

$db = (new Database())->connect();
$controller = new OrangtuaController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $file_ktp_ayah = handleFileUpload('file_ktp_ayah', $uploadDir, $allowedTypes);
    $file_ktp_ibu  = handleFileUpload('file_ktp_ibu', $uploadDir, $allowedTypes);

    $data = [
        'id_user'           => $_POST['id_user'] ?? '',

        'nama_ayah'         => $_POST['nama_ayah'] ?? '',
        'tempat_lahir_ayah' => $_POST['tempat_lahir_ayah'] ?? '',
        'tanggal_lahir_ayah'=> $_POST['tanggal_lahir_ayah'] ?? '',
        'pekerjaan_ayah'    => $_POST['pekerjaan_ayah'] ?? '',
        'hp_ayah'           => $_POST['hp_ayah'] ?? '',
        'nik_ayah'          => $_POST['nik_ayah'] ?? '',
        'kk_ayah'           => $_POST['kk_ayah'] ?? '',
        'file_ktp_ayah'     => $file_ktp_ayah,

        'nama_ibu'          => $_POST['nama_ibu'] ?? '',
        'tempat_lahir_ibu'  => $_POST['tempat_lahir_ibu'] ?? '',
        'tanggal_lahir_ibu' => $_POST['tanggal_lahir_ibu'] ?? '',
        'pekerjaan_ibu'     => $_POST['pekerjaan_ibu'] ?? '',
        'hp_ibu'            => $_POST['hp_ibu'] ?? '',
        'nik_ibu'           => $_POST['nik_ibu'] ?? '',
        'kk_ibu'            => $_POST['kk_ibu'] ?? '',
        'file_ktp_ibu'      => $file_ktp_ibu,
    ];

    $result = $controller->create($data);

    $_SESSION['message'] = $result['message'];
    header('Location: ./get_orangtua_handler.php');
    exit;
} else {
    header('Location: ../../views/user/biodata_orangtua.php');
    exit;
}
?>
