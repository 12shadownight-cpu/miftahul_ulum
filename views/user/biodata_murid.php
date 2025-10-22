<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userName = $_SESSION['user_name'] ?? 'Guest';
$userId = $_SESSION['user_id'] ?? '';
$muridData = [];

if (isset($getMurid) && is_array($getMurid)) {
    $muridData = $getMurid;
}

$hasMurid = !empty($muridData);
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
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Biodata Siswa</h2>
                <p class="text-muted">Halaman ini bertujuan untuk memasukkan data calon siswa dan mengubah data jika diperlukan.</p>
            </div>
            <div class="card mx-auto" style="max-width: 900px">
                <div class="card">
                    <div class="card-body">
                        <?php if (!$hasMurid): ?>
                            <div class="alert alert-info" role="alert">
                                Silahkan isi form pendaftaran calon siswa!
                            </div>
                        <?php endif; ?>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Siswa</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($muridData['nama_murid'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Umur Siswa</label>
                                    <input type="number" class="form-control" value="<?= htmlspecialchars($muridData['umur_murid'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="laki-laki" <?= ($muridData['jenis_kelamin'] ?? '') === 'laki-laki' ? 'checked' : '' ?> disabled/>
                                            <label class="form-check-label">Laki-Laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="perempuan" <?= ($muridData['jenis_kelamin'] ?? '') === 'perempuan' ? 'checked' : '' ?> disabled/>
                                            <label class="form-check-label">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($muridData['tempat_lahir'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" value="<?= htmlspecialchars($muridData['tanggal_lahir'] ?? '') ?>" readonly/>
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Asal TK</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($muridData['asal_tk'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($muridData['alamat'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($muridData['nik'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($muridData['no_kk'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Akta Kelahiran</label>
                                    <?php if (!empty($muridData['file_akta'])): ?>
                                        <div class="small mb-2">
                                            <a href="../../assets/uploads/<?= rawurlencode($muridData['file_akta']) ?>" target="_blank">
                                                <?= htmlspecialchars($muridData['file_akta']) ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">Belum ada file terunggah.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Kartu Keluarga</label>
                                    <?php if (!empty($muridData['file_kk'])): ?>
                                        <div class="small mb-2">
                                            <a href="../../assets/uploads/<?= rawurlencode($muridData['file_kk']) ?>" target="_blank">
                                                <?= htmlspecialchars($muridData['file_kk']) ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">Belum ada file terunggah.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Ijazah TK</label>
                                    <?php if (!empty($muridData['file_ijazah'])): ?>
                                        <div class="small mb-2">
                                            <a href="../../assets/uploads/<?= rawurlencode($muridData['file_ijazah']) ?>" target="_blank">
                                                <?= htmlspecialchars($muridData['file_ijazah']) ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">Belum ada file terunggah.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <div class="text-center mt-4">
                                    <?php if ($hasMurid && !empty($muridData['id_biodata'])): ?>
                                        <button type="button" class="btn btn-warning px-4" data-bs-toggle="modal" data-bs-target="#modalUbah">
                                            Ubah Data
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                            Tambah Data
                                        </button>
                                    <?php endif; ?>
                                </div>
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
                    <form action="../../controllers/murid/add_murid_handler.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Data Siswa</h5>
                            <input type="hidden" name="id_user" value="<?= htmlspecialchars($userId) ?>">
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
                    <form action="../../controllers/murid/edit_murid_handler.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Ubah Data Siswa</h5>
                            <input type="hidden" name="id_biodata" value="<?= htmlspecialchars($muridData['id_biodata'] ?? '') ?>"/>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Siswa</label>
                                    <input type="text" name="nama_murid" class="form-control" value="<?= htmlspecialchars($muridData['nama_murid'] ?? '') ?>" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Umur Siswa</label>
                                    <input type="number" name="umur_murid" value="<?= htmlspecialchars($muridData['umur_murid'] ?? '') ?>" class="form-control"  required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="laki-laki" <?= ($muridData['jenis_kelamin'] ?? '') === 'laki-laki' ? 'checked' : '' ?>/>
                                            <label class="form-check-label">Laki-Laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="perempuan" <?= ($muridData['jenis_kelamin'] ?? '') === 'perempuan' ? 'checked' : '' ?>/>
                                            <label class="form-check-label">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($muridData['tempat_lahir'] ?? '') ?>" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input type="text" id="dateEdit" name="tanggal_lahir" value="<?= htmlspecialchars($muridData['tanggal_lahir'] ?? '') ?>" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Asal TK</label>
                                    <input type="text" name="asal_tk" value="<?= htmlspecialchars($muridData['asal_tk'] ?? '') ?>" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" name="alamat" value="<?= htmlspecialchars($muridData['alamat'] ?? '') ?>" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" value="<?= htmlspecialchars($muridData['nik'] ?? '') ?>" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK</label>
                                    <input type="text" name="no_kk" value="<?= htmlspecialchars($muridData['no_kk'] ?? '') ?>" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Akta Kelahiran</label>
                                    <?php if (!empty($muridData['file_akta'])): ?>
                                        <div class="small mb-2">
                                            <a href="../../assets/uploads/<?= rawurlencode($muridData['file_akta']) ?>" target="_blank">
                                                <?= htmlspecialchars($muridData['file_akta']) ?>
                                            </a>
                                        </div>
                                        <input type="hidden" name="existing_file_akta" value="<?= htmlspecialchars($muridData['file_akta']) ?>">
                                    <?php endif; ?>
                                    <input type="file" name="file_akta" class="form-control" accept=".png,.jpeg,.jpg"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Kartu Keluarga</label>
                                    <?php if (!empty($muridData['file_kk'])): ?>
                                        <div class="small mb-2">
                                            <a href="../../assets/uploads/<?= rawurlencode($muridData['file_kk']) ?>" target="_blank">
                                                <?= htmlspecialchars($muridData['file_kk']) ?>
                                            </a>
                                        </div>
                                        <input type="hidden" name="existing_file_kk" value="<?= htmlspecialchars($muridData['file_kk']) ?>">
                                    <?php endif; ?>
                                    <input type="file" name="file_kk" class="form-control" accept=".png,.jpeg,.jpg"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Ijazah TK</label>
                                    <?php if (!empty($muridData['file_ijazah'])): ?>
                                        <div class="small mb-2">
                                            <a href="../../assets/uploads/<?= rawurlencode($muridData['file_ijazah']) ?>" target="_blank">
                                                <?= htmlspecialchars($muridData['file_ijazah']) ?>
                                            </a>
                                        </div>
                                        <input type="hidden" name="existing_file_ijazah" value="<?= htmlspecialchars($muridData['file_ijazah']) ?>">
                                    <?php endif; ?>
                                    <input type="file" name="file_ijazah" class="form-control" accept=".png,.jpeg,.jpg"/>
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