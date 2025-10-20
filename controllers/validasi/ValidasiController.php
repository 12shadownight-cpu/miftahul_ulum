<?php
class ValidasiController {
    private $validasiModel;

    public function __construct($db) {
        require_once __DIR__ . '/../../models/ValidasiData.php';
        $this->validasiModel = new ValidasiData($db);
    }

    public function create($data) {
        if (
            empty($data['id_user']) ||
            empty($data['id_biodata']) ||
            empty($data['id_orangtua']) ||
            empty($data['hasil']) ||
            empty($data['keterangan'])
        ) {
            return ['success' => false, 'message' => 'Semua data harus diisi!'];
        }

        $result = $this->validasiModel->create(
            $data['id_user'],
            $data['id_biodata'],
            $data['id_orangtua'],
            $data['hasil'],
            $data['keterangan']
        );

        if ($result) {
            return ['success' => true, 'message' => 'Validasi berhasil ditambahkan!'];
        } else {
            return ['success' => false, 'message' => 'Gagal menambahkan validasi.'];
        }
    }

    public function update($data) {
        if (
            empty($data['id_validasi']) ||
            empty($data['hasil']) ||
            empty($data['keterangan'])
        ) {
            return ['success' => false, 'message' => 'Semua data harus diisi!'];
        }

        $existing = $this->validasiModel->getById($data['id_validasi']);
        if (!$existing) {
            return ['success' => false, 'message' => 'Data validasi tidak ditemukan!'];
        }

        $result = $this->validasiModel->update(
            $data['id_validasi'],
            $data['hasil'],
            $data['keterangan']
        );

        if ($result) {
            return ['success' => true, 'message' => 'Validasi berhasil diperbarui!'];
        } else {
            return ['success' => false, 'message' => 'Gagal memperbarui validasi.'];
        }
    }

    public function delete($id) {
        $existing = $this->validasiModel->getById($id);
        if (!$existing) {
            return ['success' => false, 'message' => 'Data validasi tidak ditemukan!'];
        }

        $result = $this->validasiModel->delete($id);
        if ($result) {
            return ['success' => true, 'message' => 'Validasi berhasil dihapus!'];
        } else {
            return ['success' => false, 'message' => 'Gagal menghapus validasi.'];
        }
    }

    public function getAllWithRelations() {
        return $this->validasiModel->getAllWithRelations();
    }

    public function getByIdWithRelations($id_user) {
        return $this->validasiModel->getByIdWithRelations($id_user);
    }

    // Menghitung total hasil
    public function getCounts():array {
        return [
            'diterima' => $this->validasiModel->countByHasil('diterima'),
            'ditolak' => $this->validasiModel->countByHasil('ditolak')
        ];
    }
}
?>
