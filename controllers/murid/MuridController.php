<?php
class MuridController {
    private $muridModel;

    public function __construct($db) {
        require_once __DIR__ . '/../../models/BiodataMurid.php';
        $this->muridModel = new BiodataMurid($db);
    }

    // Add new biodata
    public function create($data) {
        if (
            empty($data['id_user']) || empty($data['nama']) || empty($data['umur']) ||
            empty($data['jenis_kelamin']) || empty($data['tempat_lahir']) || empty($data['tanggal_lahir']) ||
            empty($data['asal_tk']) || empty($data['alamat']) || empty($data['nik']) ||
            empty($data['no_kk']) || empty($data['file_akta']) || empty($data['file_kk']) || empty($data['file_ijazah'])
        ) {
            return ['success' => false, 'message' => 'All fields must be filled!'];
        }

        $created = $this->muridModel->create(
            $data['id_user'],
            $data['nama_murid'],
            $data['umur_murid'],
            $data['jenis_kelamin'],
            $data['tempat_lahir'],
            $data['tanggal_lahir'],
            $data['asal_tk'],
            $data['alamat'],
            $data['nik'],
            $data['no_kk'],
            $data['file_akta'],
            $data['file_kk'],
            $data['file_ijazah']
        );

        if ($created) {
            return ['success' => true, 'message' => 'Student biodata added successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to add student biodata.'];
        }
    }

    // Edit biodata
    public function update($data) {
        if (empty($data['id_biodata'])) {
            return ['success' => false, 'message' => 'Biodata ID is required.'];
        }

        // Only pass file values if they exist and are not empty
        $file_akta = !empty($data['file_akta']) ? $data['file_akta'] : null;
        $file_kk = !empty($data['file_kk']) ? $data['file_kk'] : null;
        $file_ijazah = !empty($data['file_ijazah']) ? $data['file_ijazah'] : null;

        $updated = $this->muridModel->update(
            $data['id_biodata'],
            $data['nama_murid'],
            $data['umur_murid'],
            $data['jenis_kelamin'],
            $data['tempat_lahir'],
            $data['tanggal_lahir'],
            $data['asal_tk'],
            $data['alamat'],
            $data['nik'],
            $data['no_kk'],
            $file_akta,
            $file_kk,
            $file_ijazah
        );

        if ($updated) {
            return ['success' => true, 'message' => 'Student biodata updated successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to update student biodata.'];
        }
    }

    // Delete biodata
    public function delete($id_biodata) {
        if (empty($id_biodata)) {
            return ['success' => false, 'message' => 'Biodata ID is required.'];
        }

        $deleted = $this->muridModel->delete($id_biodata);

        if ($deleted) {
            return ['success' => true, 'message' => 'Student biodata deleted successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to delete student biodata.'];
        }
    }

    // Get biodata by user ID
    public function getByUserId($id_user) {
        return $this->muridModel->getByUserId($id_user);
    }

    // Get all biodata murid
    public function getAll() {
        return $this->muridModel->getAll();
    }

    // Menghitung total hasil
    public function getCounts():array {
        return [
            'laki-laki' => $this->muridModel->countByGender('laki-laki'),
            'perempuan' => $this->muridModel->countByGender('perempuan')
        ];
    }
    
}
?>
