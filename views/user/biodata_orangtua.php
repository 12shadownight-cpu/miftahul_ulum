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
                    <span class="me-3 fw-semibold"><?= htmlspecialchars($userName) ?></span>
                    <a href="../../controllers/user/user_logout_handler.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content container-fluid">
            <div class="px-3 py-2">
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Biodata Orangtua</h2>
                <p class="text-muted">Halaman ini bertujuan untuk memasukkan data orangtua siswa dan mengubah data jika diperlukan.</p>
            </div>
            <div class="card mx-auto" style="max-width: 900px">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" class="form-control" name="nama_ayah" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" class="form-control" name="nama_ibu" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ayah</label>
                                    <input type="text" class="form-control" name="tempat_lahir_ayah"readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ibu</label>
                                    <input type="text" class="form-control" name="tempat_lahir_ibu"readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ayah</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="tanggal_lahir_ayah" readonly/>
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ibu</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="tanggal_lahir_ibu" readonly/>
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" class="form-control" name="pekerjaan_ayah" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" class="form-control" name="pekerjaan_ibu" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ayah</label>
                                    <input type="tel" class="form-control" name="hp_ayah" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ibu</label>
                                    <input type="tel" class="form-control" name="hp_ibu" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ayah</label>
                                    <input type="text" class="form-control" name="nik_ayah" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ibu</label>
                                    <input type="text" class="form-control" name="nik_ibu" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ayah</label>
                                    <input type="text" class="form-control" name="kk_ayah" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ibu</label>
                                    <input type="text" class="form-control" name="kk_ibu" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ayah</label>
                                    <input type="file" class="form-control" name="file_ktp_ayah" accept=".png,.jpeg,.jpg" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ibu</label>
                                    <input type="file" class="form-control" name="file_ktp_ibu" accept=".png,.jpeg,.jpg" readonly/>
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
                    <form action="../../controllers/orangtua/add_orangtua_handler.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Data Orangtua</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ayah</label>
                                    <input type="text" name="tempat_lahir_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ibu</label>
                                    <input type="text" name="tempat_lahir_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ayah</label>
                                    <div class="input-group">
                                        <input type="text" name="tanggal_lahir_ayah" class="form-control dateInput" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ibu</label>
                                    <div class="input-group">
                                        <input type="text" name="tanggal_lahir_ibu" class="form-control dateInput" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ayah</label>
                                    <input type="tel" name="hp_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ibu</label>
                                    <input type="tel" name="hp_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ayah</label>
                                    <input type="text" name="nik_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ibu</label>
                                    <input type="text" name="nik_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ayah</label>
                                    <input type="text" name="kk_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ibu</label>
                                    <input type="text" name="kk_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ayah</label>
                                    <input type="file" name="file_ktp_ayah" class="form-control" accept=".png,.jpeg,.jpg" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ibu</label>
                                    <input type="file" name="file_ktp_ibu" class="form-control" accept=".png,.jpeg,.jpg" required>
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
                    <form action="../../controllers/orangtua/edit_orangtua_handler.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Ubah Data Siswa</h5>
                            <input type="hidden" name="id_biodata" />
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ayah</label>
                                    <input type="text" name="tempat_lahir_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ibu</label>
                                    <input type="text" name="tempat_lahir_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ayah</label>
                                    <div class="input-group">
                                        <input type="text" name="tanggal_lahir_ayah" class="form-control dateInput" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ibu</label>
                                    <div class="input-group">
                                        <input type="text" name="tanggal_lahir_ibu" class="form-control dateInput" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ayah</label>
                                    <input type="tel" name="hp_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ibu</label>
                                    <input type="tel" name="hp_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ayah</label>
                                    <input type="text" name="nik_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ibu</label>
                                    <input type="text" name="nik_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ayah</label>
                                    <input type="text" name="kk_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ibu</label>
                                    <input type="text" name="kk_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ayah</label>
                                    <input type="file" name="file_ktp_ayah" class="form-control" accept=".png,.jpeg,.jpg" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ibu</label>
                                    <input type="file" name="file_ktp_ibu" class="form-control" accept=".png,.jpeg,.jpg" required>
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
        flatpickr(".dateInput", {
            dateFormat: "Y-m-d",      // Output format
            defaultDate: "1980-01-01" // Default date
        });
    </script>
</body>
</html>