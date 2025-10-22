<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/ValidasiController.php';

$db = (new Database())->connect();
$controller = new ValidasiController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idBiodata = isset($_POST['id_biodata']) ? (int) $_POST['id_biodata'] : 0;
    $hasil = trim($_POST['hasil'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    if ($idBiodata <= 0 || $hasil === '' || $keterangan === '') {
        $_SESSION['message'] = 'Semua data harus diisi!';
        header('Location: ../../views/pengurus/sekretaris/validasi.php');
        exit;
    }

    try {
        // Ambil ID user berdasarkan biodata murid
        $stmtMurid = $db->prepare('SELECT id_user FROM biodata_murid WHERE id_biodata = :id_biodata LIMIT 1');
        $stmtMurid->bindValue(':id_biodata', $idBiodata, PDO::PARAM_INT);
        $stmtMurid->execute();
        $idUser = $stmtMurid->fetchColumn();

        if (!$idUser) {
            $_SESSION['message'] = 'Data murid tidak ditemukan.';
            header('Location: ../../views/pengurus/sekretaris/validasi.php');
            exit;
        }

        // Ambil ID orang tua berdasarkan user
        $stmtOrtu = $db->prepare('SELECT id_orangtua FROM biodata_orangtua WHERE id_user = :id_user LIMIT 1');
        $stmtOrtu->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        $stmtOrtu->execute();
        $idOrangtua = $stmtOrtu->fetchColumn();

        if (!$idOrangtua) {
            $_SESSION['message'] = 'Data orang tua tidak ditemukan.';
            header('Location: ../../views/pengurus/sekretaris/validasi.php');
            exit;
        }

        $data = [
            'id_user'     => (int) $idUser,
            'id_biodata'  => $idBiodata,
            'id_orangtua' => (int) $idOrangtua,
            'hasil'       => $hasil,
            'keterangan'  => $keterangan,
        ];

        $result = $controller->create($data);
    } catch (PDOException $e) {
        error_log('Add validasi error: ' . $e->getMessage());
        $result = ['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data validasi.'];
    }

    $_SESSION['message'] = $result['message'];
    if ($result['success'] ?? false) {
        header('Location: ./fetch_validasi_handler.php');
    } else {
        header('Location: ../../views/pengurus/sekretaris/validasi.php');
    }
    exit;
}
header('Location: ../../views/pengurus/sekretaris/validasi.php');
exit;
?>
