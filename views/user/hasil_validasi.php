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
                    Selamat datang di Dashboard User !
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
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Hasil Validasi Data</h2>
                <p class="text-muted">Halaman ini bertujuan untuk menunjukkan apakah pendaftaran siswa diterima atau ditolak, serta bukti pendaftaran jika diterima.</p>
            </div>
            <div class="card">
                <div class="card-header bg-white" style="border-top: none; border-left: none; border-right: none;">
                    <h5 class="mb-0">Tabel hasil validasi</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Hasil Validasi</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Diterima</td>
                                <td>Tidak ada masalah</td>
                                <td>
                                <a href="" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary me-1">
                                    <i class="bi bi-printer me-1"></i>Cetak
                                </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Ditolak</td>
                                <td>Nomor KTP tidak terdafar</td>
                                <td>
                                <a class="btn btn-sm btn-secondary me-1 disabled">
                                    <i class="bi bi-printer me-1"></i>Cetak
                                </a>
                                </td>
                            </tr>
                            <!-- Add more rows if needed -->
                        </tbody>
                    </table>
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
        //Prepare the table
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
</body>
</html>