<?php
class PengurusController {
    private $pengurusModel;

    public function __construct($db) {
        require_once __DIR__ . '/../../models/Pengurus.php';
        $this->pengurusModel = new Pengurus($db);
    }

    // Mengontrol tambah pengurus (by admin)
    public function create($data) {
        if (
            empty($data['nama_pengurus']) ||
            empty($data['username']) ||
            empty($data['password']) ||
            empty($data['email']) ||
            empty($data['no_hp']) ||
            empty($data['status'])
        ) {
            return ['success' => false, 'message' => 'Semua form data harus diisi!'];
        }

        //Tambahan validasi
        //Format e-mail
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Format E-mail Salah!'];
        }

        //Panjang username
        if (strlen($data['username']) < 3 || strlen($data['username']) > 25) {
            return ['success' => false, 'message' => 'Username harus berjumlah 3-25 karakter!'];
        }

        //Panjang password
        if (strlen($data['password']) < 6) {
            return ['success' => false, 'message' => 'Password harus berjumlah minimal 6 karakter!'];
        }

        //Format no handphone
        if (!preg_match('/^\+?[0-9]{10,15}$/', $data['no_hp'])) {
            return ['success' => false, 'message' => 'Nomor handphone harus berjumlah 10-15 digit!'];
        }

        //Periksa Status
        if ($data['status'] !== 'admin' && $data['status'] !== 'sekretaris') {
            return ['success' => false, 'message' => 'Status harus admin atau sekretaris!'];
        }

        //Periksa duplikasi username
        if ($this->pengurusModel->getByUsername($data['username'])) {
            return ['success' => false, 'message' => 'Username sudah terdaftar!'];
        }

        //Periksa duplikasi e-mail
        if ($this->pengurusModel->getByEmail($data['email'])) {
            return ['success' => false, 'message' => 'Email sudah terdaftar!'];
        }

        //Tambahkan
        $created = $this->pengurusModel->create(
            $data['nama_pengurus'],
            $data['username'],
            $data['password'],
            $data['email'],
            $data['no_hp'],
            $data['status']
        );

        if ($created) {
            return ['success' => true, 'message' => 'Pengurus berhasil dibuat!'];
        } else {
            return ['success' => false, 'message' => 'Gagal membuat pengurus!'];
        }
    }

    //Mengontrol edit pengurus (by admin)
    public function update($id, $data) {
        if (
            empty($data['nama_pengurus']) ||
            empty($data['username']) ||
            empty($data['email']) ||
            empty($data['no_hp']) ||
            empty($data['status'])
        ) {
            return ['success' => false, 'message' => 'Semua form data harus diisi kecuali password!'];
        }

        //Ubah validasi
        //Format e-mail
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Format E-mail salah!'];
        }

        //Panjang username
        if (strlen($data['username']) < 3 || strlen($data['username']) > 25) {
            return ['success' => false, 'message' => 'Username harus berjumlah 3-25 karakter!'];
        }

        //Panjang password
        if (!empty($data['password']) && strlen($data['password']) < 6) {
            return ['success' => false, 'message' => 'Password harus minimal 6 karakter!'];
        }

        //Format no handphone
        if (!preg_match('/^\+?[0-9]{10,15}$/', $data['no_hp'])) {
            return ['success' => false, 'message' => 'Nomor handphone harus berjumlah 10-15 digit!'];
        }

        //Periksa status
        if ($data['status'] !== 'admin' && $data['status'] !== 'sekretaris') {
            return ['success' => false, 'message' => 'Status harus admin atau sekretaris!'];
        }

        //Periksa duplikasi username
        $existingUser = $this->pengurusModel->getByUsername($data['username']);
        if (is_array($existingUser) && $existingUser['id_pengurus'] != $id) {
            return ['success' => false, 'message' => 'Username sudah digunakan oleh pengurus lain!'];
        }

        //Periksa duplikasi username
        $existingEmail = $this->pengurusModel->getByEmail($data['email']);
        if (is_array($existingEmail) && $existingEmail['id_pengurus'] != $id) {
            return ['success' => false, 'message' => 'E-mail sudah digunakan oleh pengurus lain!'];
        }


        //Ubahkan
        $updated = $this->pengurusModel->update(
            $id,
            $data['nama_pengurus'],
            $data['username'],
            !empty($data['password']) ? $data['password'] : null,
            $data['email'],
            $data['no_hp'],
            $data['status']
        );

        return [
            'success' => (bool) $updated,
            'message' => $updated
                ? 'Data pengurus berhasil diperbarui!'
                : 'Gagal memperbarui data pengurus!'
        ];
    }

    // Mengontrol hapus pengurus (by admin)
    public function delete($id, $currentStatus) {
        // Cek status
        if ($currentStatus !== 'admin') {
            return ['success' => false, 'message' => 'Akses ditolak!'];
        }

        // Validasi ID
        if (empty($id) || !is_numeric($id)) {
            return ['success' => false, 'message' => 'ID tidak ditemukan!'];
        }

        //Hapuskan
        $deleted = $this->pengurusModel->delete($id);

        if ($deleted) {
            return ['success' => true, 'message' => 'Data pengurus berhasil dihapus!'];
        } else {
            return ['success' => false, 'message' => 'Gagal menghapus data pengurus!'];
        }
    }

    // Mengontrol login pengurus
    public function login($data) {
        if (
            empty($data['username']) ||
            empty($data['password'])
        ) {
            return ['success' => false, 'message' => 'Semua form login harus diisi!'];
        }

        //Login
        $pengurus = $this->pengurusModel->verifyLogin(
            $data['username'],
            $data['password']
        );

        if ($pengurus) {
            $_SESSION['pengurus_id'] = $pengurus['id_pengurus'];
            $_SESSION['pengurus_name'] = $pengurus['nama_pengurus'];
            $_SESSION['pengurus_status'] = $pengurus['status'];

            return ['success' => true, 'message' => 'Login berhasil!'];
        } else {
            return ['success' => false, 'message' => 'Akun tidak ditemukan atau password salah!'];
        }
    }

    // Mengontrol logout pengurus
    public function logout() {
        if(session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_unset();
            session_regenerate_id(true);
        }
        return ['success' => true, 'message' => 'Logout berhasil!'];
    }

    // Mengambil semua data pengurus
    public function getAll() {
        $result = $this->pengurusModel->getAll();
        return is_array($result) ? $result : [];
    }

    // Menghitung total pengurus
    public function getCounts() {
    return [
        'admins' => $this->pengurusModel->countByStatus('admin'),
        'sekretaris' => $this->pengurusModel->countByStatus('sekretaris')
    ];
    }

}

