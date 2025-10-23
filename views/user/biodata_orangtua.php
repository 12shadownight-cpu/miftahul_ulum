<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userName = $_SESSION['user_name'] ?? 'Guest';
$userId     = $_SESSION['user_id'] ?? '';
$orangtuaData = [];

if (isset($getOrangtua) && is_array($getOrangtua)) {
    $orangtuaData = $getOrangtua;
}

$hasOrangtua = !empty($orangtuaData);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap & icon CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
    html,
    body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      font-family: 'Segoe UI', sans-serif;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      height: 100vh;
      background: linear-gradient(to bottom right, #4caf50, #2e7d32);
      color: white;
      position: fixed;
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
    }

    .sidebar .brand {
      padding: 1.5rem;
      font-size: 1.25rem;
      font-weight: bold;
      text-align: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .nav-link {
      color: white;
      padding: 0.75rem 1.5rem;
      display: flex;
      align-items: center;
      font-weight: 500;
      transition: background 0.3s;
      cursor: pointer;
    }

    .nav-link:hover,
    .nav-link.active {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 10px;
      color: white;
    }

    .nav-link i {
      margin-right: 1rem;
      font-size: 1.2rem;
    }

    .collapse .nav-link {
      padding-left: 3.5rem;
      font-size: 0.95rem;
    }

    /* Wrapper for navbar + main content + footer */
    .main-wrapper {
      margin-left: 250px;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      width: 100%;
    }

    .modal-header {
      position: relative;      /* anchor for absolute positioning */
      display: flex;
      justify-content: center; /* center title */
    }

    .modal-title {
      text-align: center;
      flex-grow: 1;
    }

    .modal-header .btn-close {
      position: absolute;
      right: 1rem;  /* adjust spacing */
      top: 50%;
      transform: translateY(-50%);
    }

    .main-content {
      flex: 1;
      padding: 1rem;
    }

    .no-border {
      border-top: none;
      border-left: none;
      border-right: none;
    }

    /* Shrink all form controls inside biodata form */
    .card form .form-control {
      height: 32px;
      padding: 4px 8px;
      font-size: 0.9rem;
      max-width: 400px; /* shorten the input width */
    }

    /* Shrink file input to match */
    .card form input[type='file'].form-control {
      padding: 3px;
      height: 32px;
      max-width: 400px; /* shorten the input width */
    }

    /* Shrink date input group (calendar) */
    .card form .input-group {
      max-width: 400px;
    }

    /* Shrink input-group add-ons (like calendar icon) */
    .card form .input-group-text {
      height: 32px;
      padding: 4px 8px;
      font-size: 0.9rem;
      max-width: 400px; /* shorten the input width */
    }

    /* Shrink radio buttons and labels */
    .card form .form-check-input {
      width: 14px;
      height: 14px;
      margin-top: 0.2rem; /* align vertically with label */
    }

    .card form .form-check-label {
      font-size: 0.9rem;
      margin-left: 2px;
    }

    footer {
      background-color: #f2d0a4;
      padding: 1rem;
      text-align: center;
      font-size: 0.9rem;
      border-top: 1px solid #dee2e6;
    }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/sidebar/user-sidebar.php'; ?>

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
                    <a href="/mifahul_ulum/controllers/user/user_logout_handler.php" class="btn btn-outline-danger btn-sm">
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
                        <?php if (!$hasOrangtua): ?>
                            <div class="alert alert-info" role="alert">
                                Silahkan isi data orangtua calon siswa!
                            </div>
                        <?php endif; ?>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($orangtuaData['nama_ayah'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($orangtuaData['nama_ibu'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ayah</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($orangtuaData['tempat_lahir_ayah'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ibu</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($orangtuaData['tempat_lahir_ibu'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ayah</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" value="<?= htmlspecialchars($orangtuaData['tanggal_lahir_ayah'] ?? '') ?>" readonly/>
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ibu</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" value="<?= htmlspecialchars($orangtuaData['tanggal_lahir_ibu'] ?? '') ?>" readonly/>
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($orangtuaData['pekerjaan_ayah'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($orangtuaData['pekerjaan_ibu'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ayah</label>
                                    <input type="tel" class="form-control" value="<?= htmlspecialchars($orangtuaData['hp_ayah'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ibu</label>
                                    <input type="tel" class="form-control" value="<?= htmlspecialchars($orangtuaData['hp_ibu'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ayah</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($orangtuaData['nik_ayah'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ibu</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($orangtuaData['nik_ibu'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ayah</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($orangtuaData['kk_ayah'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ibu</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($orangtuaData['kk_ibu'] ?? '') ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ayah</label>
                                    <?php if (!empty($orangtuaData['file_ktp_ayah'])): ?>
                                        <div class="small mb-2">
                                            <a href="../../assets/uploads/<?= rawurlencode($orangtuaData['file_ktp_ayah']) ?>" target="_blank">
                                                <?= htmlspecialchars($orangtuaData['file_ktp_ayah']) ?>
                                            </a>
                                        </div>
                                        <?php else: ?>
                                            <p class="text-muted mb-0">Belum ada file terunggah.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ibu</label>
                                    <?php if (!empty($orangtuaData['file_ktp_ibu'])): ?>
                                        <div class="small mb-2">
                                            <a href="../../assets/uploads/<?= rawurlencode($orangtuaData['file_ktp_ibu']) ?>" target="_blank">
                                                <?= htmlspecialchars($orangtuaData['file_ktp_ibu']) ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">Belum ada file terunggah.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <?php if ($hasOrangtua && !empty($orangtuaData['id_orangtua'])): ?>
                                    <button type="button" class="btn btn-warning px-4" data-bs-toggle="modal" data-bs-target="#modalUbah">
                                        Ubah Data
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                        Tambah Data
                                    </button>
                                <?php endif; ?>
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
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">Tambah Data Orangtua</h5>
                            <input type="hidden" name="id_user" value="<?= htmlspecialchars($userId) ?>">
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
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title">Ubah Data Siswa</h5>
                            <input type="hidden" name="id_orangtua" value="<?= htmlspecialchars($orangtuaData['id_orangtua'] ?? '') ?>"/>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" value="<?= htmlspecialchars($orangtuaData['nama_ayah'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" value="<?= htmlspecialchars($orangtuaData['nama_ibu'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ayah</label>
                                    <input type="text" name="tempat_lahir_ayah" value="<?= htmlspecialchars($orangtuaData['tempat_lahir_ayah'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ibu</label>
                                    <input type="text" name="tempat_lahir_ibu" value="<?= htmlspecialchars($orangtuaData['tempat_lahir_ibu'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ayah</label>
                                    <div class="input-group">
                                        <input type="text" name="tanggal_lahir_ayah" value="<?= htmlspecialchars($orangtuaData['tanggal_lahir_ayah'] ?? '') ?>" class="form-control dateInput" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ibu</label>
                                    <div class="input-group">
                                        <input type="text" name="tanggal_lahir_ibu" value="<?= htmlspecialchars($orangtuaData['tanggal_lahir_ibu'] ?? '') ?>" class="form-control dateInput" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" value="<?= htmlspecialchars($orangtuaData['pekerjaan_ayah'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" value="<?= htmlspecialchars($orangtuaData['pekerjaan_ibu'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ayah</label>
                                    <input type="tel" name="hp_ayah" value="<?= htmlspecialchars($orangtuaData['hp_ayah'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ibu</label>
                                    <input type="tel" name="hp_ibu" value="<?= htmlspecialchars($orangtuaData['hp_ibu'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ayah</label>
                                    <input type="text" name="nik_ayah" value="<?= htmlspecialchars($orangtuaData['nik_ayah'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ibu</label>
                                    <input type="text" name="nik_ibu" value="<?= htmlspecialchars($orangtuaData['nik_ibu'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ayah</label>
                                    <input type="text" name="kk_ayah" value="<?= htmlspecialchars($orangtuaData['kk_ayah'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ibu</label>
                                    <input type="text" name="kk_ibu" value="<?= htmlspecialchars($orangtuaData['kk_ibu'] ?? '') ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ayah</label>
                                    <?php if (!empty($orangtuaData['file_ktp_ayah'])): ?>
                                        <div class="small mb-2">
                                            <a href="../../assets/uploads/<?= rawurlencode($orangtuaData['file_ktp_ayah']) ?>" target="_blank">
                                                <?= htmlspecialchars($orangtuaData['file_ktp_ayah']) ?>
                                            </a>
                                        </div>
                                        <input type="hidden" name="existing_file_ktp_ayah" value="<?= htmlspecialchars($orangtuaData['file_ktp_ayah']) ?>">
                                    <?php endif; ?>
                                    <input type="file" name="file_ktp_ayah" class="form-control" accept=".png,.jpeg,.jpg" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ibu</label>
                                    <?php if (!empty($orangtuaData['file_ktp_ibu'])): ?>
                                        <div class="small mb-2">
                                            <a href="../../assets/uploads/<?= rawurlencode($orangtuaData['file_ktp_ibu']) ?>" target="_blank">
                                                <?= htmlspecialchars($orangtuaData['file_ktp_ibu']) ?>
                                            </a>
                                        </div>
                                        <input type="hidden" name="existing_file_ktp_ibu" value="<?= htmlspecialchars($orangtuaData['file_ktp_ibu']) ?>">
                                    <?php endif; ?>
                                    <input type="file" name="file_ktp_ibu" class="form-control" accept=".png,.jpeg,.jpg" />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-warning">Simpan Data</button>
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

    <?php require_once __DIR__ . '/../partials/footer/user_footer.php'; ?>

    <script>
        flatpickr(".dateInput", {
            dateFormat: "Y-m-d",      // Output format
            defaultDate: "1980-01-01" // Default date
        });
    </script>
</body>
</html>