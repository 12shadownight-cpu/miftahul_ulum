<?php
class UserController {
    private $userModel;

    public function __construct($db) {
        require_once __DIR__ . '/../../models/User.php';
        $this->userModel = new User($db);
    }

    //Mengontrol registrasi user
    public function register($data) {

        //Trim all data
        $data = array_map('trim', $data);

        //Check empty data
        if (
            empty($data['nama_user']) ||
            empty($data['username']) ||
            empty($data['password']) ||
            empty($data['email']) ||
            empty($data['no_hp']) 
        ) {
            return ['success' => false, 'message' => 'Semua form data harus diisi!'];
        }

        //Tambahan validasi
        //Format e-mail
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Format E-mail Salah!'];
        }

        //Panjang username
        if(strlen($data['username']) < 3 || strlen($data['username']) > 25){
            return ['success' => false, 'message' => 'Username harus berjumlah 3-25 karakter!'];
        }

        //Panjang password
        if(strlen($data['password']) < 6){
            return ['success' => false, 'message' => 'Password harus berjumlah minimal 6 karakter!'];
        }

        //Format nomor handphone
        if(!preg_match('/^[0-9]{10,15}$/', $data['no_hp'])) {
            return ['success' => false, 'message' => 'Nomor handphone harus berjumlah 10-15 digit!'];
        }

        //Periksa duplikasi username
        $existingUsername = $this->userModel->getByUsername($data['username']);
        if ($existingUsername) {
            return ['success' => false, 'message' => 'Username sudah terdaftar!'];
        }

        //Periksa duplikasi e-mail
        $existingEmail = $this->userModel->getByEmail($data['email']);
        if ($existingEmail) {
            return ['success' => false, 'message' => 'E-mail telah terdaftar!'];
        }

        //Menambahkan user
        $created = $this->userModel->create(
            $data['nama_user'],
            $data['username'],
            $data['password'],
            $data['email'],
            $data['no_hp']
        );

        if ($created) {
            return ['success' => true, 'message' => 'Pendaftaran akun berhasil!'];
        } else {
            return ['success' => false, 'message' => 'Pendaftaran akun gagal!'];
        }
    }

    public function getId($id) {
        return $this->userModel->getById($id);
    }

    //Mengontrol total user
    public function getTotalUsers() {
        return $this->userModel->countAllUsers();
    }

    //Mengontrol login user
    public function login($data) {

        //Trim all data
        $data = array_map('trim', $data);

        //check empty data
        if (
            empty($data['username']) ||
            empty($data['password'])
        ) {
            return ['success' => false, 'message' => 'Semua form login harus diisi!'];
        }

        $user = $this->userModel->verifyLogin(
            $data['username'],
            $data['password']
        );

        if ($user) {
            //Mulai Session
            session_start();
            $_SESSION['user_id']   = $user['id_user'];
            $_SESSION['user_name'] = $user['nama_user'];

            return ['success' => true, 'message' => 'Login akun berhasil!'];
        } else {
            return ['success' => false, 'message' => 'Akun tidak terdaftar, silahkan registrasi akun!'];
        }
    }

    //Mengontrol logout
    public function logout() {
        session_destroy();
        return ['success' => true, 'message' => 'Logout akun berhasil!'];
    }
}
?>