<?php
class OrangtuaController {
    private $orangtuaModel;

    public function __construct($db) {
        require_once __DIR__ . '/../../models/BiodataOrangtua.php';
        $this->orangtuaModel = new BiodataOrangtua($db);
    }

    // Add new parent biodata
    public function create($data) {
        if (
            empty($data['id_user']) ||
            empty($data['nama_ayah']) || empty($data['tempat_lahir_ayah']) || empty($data['tanggal_lahir_ayah']) ||
            empty($data['pekerjaan_ayah']) || empty($data['hp_ayah']) || empty($data['nik_ayah']) ||
            empty($data['kk_ayah']) || empty($data['file_ktp_ayah']) ||
            empty($data['nama_ibu']) || empty($data['tempat_lahir_ibu']) || empty($data['tanggal_lahir_ibu']) ||
            empty($data['pekerjaan_ibu']) || empty($data['hp_ibu']) || empty($data['nik_ibu']) ||
            empty($data['kk_ibu']) || empty($data['file_ktp_ibu'])
        ) {
            return ['success' => false, 'message' => 'All fields must be filled!'];
        }

        $created = $this->orangtuaModel->create(
            $data['id_user'],
            $data['nama_ayah'],
            $data['tempat_lahir_ayah'],
            $data['tanggal_lahir_ayah'],
            $data['pekerjaan_ayah'],
            $data['hp_ayah'],
            $data['nik_ayah'],
            $data['kk_ayah'],
            $data['file_ktp_ayah'],
            $data['nama_ibu'],
            $data['tempat_lahir_ibu'],
            $data['tanggal_lahir_ibu'],
            $data['pekerjaan_ibu'],
            $data['hp_ibu'],
            $data['nik_ibu'],
            $data['kk_ibu'],
            $data['file_ktp_ibu']
        );

        if ($created) {
            return ['success' => true, 'message' => 'Parent biodata added successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to add parent biodata.'];
        }
    }

    // Edit parent biodata
    public function update($data) {
        if (empty($data['id_orangtua'])) {
            return ['success' => false, 'message' => 'Parent ID is required.'];
        }

        // Only pass file values if they exist and are not empty
        $file_ktp_ayah = !empty($data['file_ktp_ayah']) ? $data['file_ktp_ayah'] : null;
        $file_ktp_ibu = !empty($data['file_ktp_ibu']) ? $data['file_ktp_ibu'] : null;

        $updated = $this->orangtuaModel->update(
            $data['id_orangtua'],
            $data['nama_ayah'],
            $data['tempat_lahir_ayah'],
            $data['tanggal_lahir_ayah'],
            $data['pekerjaan_ayah'],
            $data['hp_ayah'],
            $data['nik_ayah'],
            $data['kk_ayah'],
            $data['nama_ibu'],
            $data['tempat_lahir_ibu'],
            $data['tanggal_lahir_ibu'],
            $data['pekerjaan_ibu'],
            $data['hp_ibu'],
            $data['nik_ibu'],
            $data['kk_ibu'],
            $file_ktp_ayah,
            $file_ktp_ibu
        );

        if ($updated) {
            return ['success' => true, 'message' => 'Parent biodata updated successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to update parent biodata.'];
        }
    }

    // Delete parent biodata
    public function delete($id_orangtua) {
        if (empty($id_orangtua)) {
            return ['success' => false, 'message' => 'Parent ID is required.'];
        }

        $deleted = $this->orangtuaModel->delete($id_orangtua);

        if ($deleted) {
            return ['success' => true, 'message' => 'Parent biodata deleted successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to delete parent biodata.'];
        }
    }

    // Get parent biodata by user ID
    public function getByUserId($id_user) {
        return $this->orangtuaModel->getByUserId($id_user);
    }

    // Get all biodata orangtua
    public function getAll() {
        return $this->orangtuaModel->getAll();
    }
}
?>
