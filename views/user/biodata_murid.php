<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userName = $_SESSION['user_name'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="id">
<?php include '../partials/header/user_header.php'; ?>
<body>
    <?php include '../partials/sidebar/user-sidebar.php'; ?>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg shadow-sm mb-3" style="background-color: #f2d0a4;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <!-- Left: Navbar Brand -->
                <span class="navbar-brand mb-0 h1">
                    Selamat datang di Dashboard User!
                </span>
                <!-- Right: User & Logout -->
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-semibold"> John Doe </span>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content container-fluid">
            <div class="px-3 py-2">
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Biodata Siswa</h2>
                <p class="text-muted">Halaman ini bertujuan untuk memasukkan data calon siswa dan mengubah data jika diperlukan.</p>
            </div>
            <div class="card mx-auto" style="max-width: 900px">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Siswa</label>
                                    <input type="text" class="form-control" name="nama_murid" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Umur Siswa</label>
                                    <input type="number" class="form-control" name="umur_murid" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin"/>
                                            <label class="form-check-label">Laki-Laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin"/>
                                            <label class="form-check-label">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir"readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="tanggal_lahir" readonly/>
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Asal TK</label>
                                    <input type="text" class="form-control" name="asal_tk" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text" class="form-control" name="nik" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK</label>
                                    <input type="text" class="form-control" name="no_kk" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Akta Kelahiran</label>
                                    <input type="file" class="form-control" name="file_akta" accept=".png,.jpeg,.jpg" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Kartu Keluarga</label>
                                    <input type="file" class="form-control" name="file_kk" accept=".png,.jpeg,.jpg" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Ijazah TK</label>
                                    <input type="file" class="form-control" name="file_ijazah" accept=".png,.jpeg,.jpg" readonly/>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                Tambah Data
                                </button>
                                <button type="button" class="btn btn-warning px-4" data-bs-toggle="modal" data-bs-target="#modalUbah">
                                Ubah Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="handler/insert.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Data Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Siswa</label>
                                    <input type="text" name="nama_murid" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Umur Siswa</label>
                                    <input type="number" name="umur_murid" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="laki-laki" required>
                                        <label class="form-check-label">Laki-Laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="perempuan" required>
                                        <label class="form-check-label">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input type="text" id="dateAdd" name="tanggal_lahir" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Asal TK</label>
                                    <input type="text" name="asal_tk" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" name="alamat" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK</label>
                                    <input type="text" name="no_kk" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Akta Kelahiran</label>
                                    <input type="file" name="file_akta" class="form-control" accept=".png,.jpeg,.jpg" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Kartu Keluarga</label>
                                    <input type="file" name="file_kk" class="form-control" accept=".png,.jpeg,.jpg" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Ijazah TK</label>
                                    <input type="file" name="file_ijazah" class="form-control" accept=".png,.jpeg,.jpg" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-success">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="modalUbah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="handler/edit.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Ubah Data Siswa</h5>
                            <input type="hidden" name="id_biodata" />
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Siswa</label>
                                    <input type="text" name="nama_murid" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Umur Siswa</label>
                                    <input type="number" name="umur_murid" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" required/>
                                        <label class="form-check-label">Laki-Laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" required/>
                                        <label class="form-check-label">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input type="text" id="dateEdit" name="tanggal_lahir" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Asal TK</label>
                                    <input type="text" name="asal_tk" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" name="alamat" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK</label>
                                    <input type="text" name="no_kk" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Akta Kelahiran</label>
                                    <input type="file" name="file_akta" class="form-control" accept=".png,.jpeg,.jpg" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Kartu Keluarga</label>
                                    <input type="file" name="file_kk" class="form-control" accept=".png,.jpeg,.jpg" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Ijazah TK</label>
                                    <input type="file" name="file_ijazah" class="form-control" accept=".png,.jpeg,.jpg" required/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-success">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sticky Footer -->
        <footer>
        &copy; 2025 Madrasah Ibtidaiyah Miftahul Ulum.
        </footer>
    </div>

    <?php include '../partials/footer/user_footer.php'; ?>

    <script>
        flatpickr("#dateAdd", {
            dateFormat: "Y-m-d",      // Output format
            defaultDate: "2018-01-01" // Default date
        });
        flatpickr("#dateEdit", {
            dateFormat: "Y-m-d",      // Output format
            defaultDate: "2018-01-01" // Default date
        });
    </script>
</body>
</html>