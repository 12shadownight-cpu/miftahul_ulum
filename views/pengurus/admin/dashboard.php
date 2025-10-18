<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pengurusName = $_SESSION['pengurus_name'] ?? 'Guest';
$status = $_SESSION['pengurus_status'] ?? null;
if ($status !== 'admin') {
    header('Location: ../../public/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<?php include '../../partials/header/admin_header.php'; ?>
<body>
    <?php include '../../partials/sidebar/admin-sidebar.php'; ?>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg shadow-sm mb-3" style="background-color: #e5d9f2;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <!-- Left: Navbar Brand -->
                <span class="navbar-brand mb-0 h1">
                    Selamat datang di Dashboard Admin !
                </span>

                <!-- Right: User & Logout -->
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-semibold"><?= htmlspecialchars($pengurusName) ?></span>
                    <a href="../../../controllers/pengurus/pengurus_logout_handler.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content container-fluid">
            <div class="px-3 py-2">
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Dashboard</h2>
                <p class="text-muted">Halaman ini bertujuan untuk menampilkan jumlah data yang tersimpan. Seperti jumlah user, admin, sekretaris dan pengumuman.</p>
            </div>
            <div class="info-box-container">
                <div class="info-box">
                    <div class="icon bg-green"><i class="fa-solid fa-user"></i></div>
                    <div class="content">
                        <h4>Jumlah User</h4>
                        <p>1,410 Orang</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="icon bg-red"><i class="fa-solid fa-user-tie"></i></div>
                    <div class="content">
                        <h4>Jumlah Sekretaris</h4>
                        <p>410 Orang</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="icon bg-blue"><i class="fa-solid fa-user-tie"></i></div>
                    <div class="content">
                        <h4>Jumlah Admin</h4>
                        <p>13,648 Orang</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="icon bg-yellow"><i class="fa-solid fa-comment"></i></div>
                    <div class="content">
                        <h4>Jumlah Pengumuman</h4>
                        <p>93,139 Postingan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Footer -->
        <footer>
            &copy; 2025 Madrasah Ibtidaiyah Miftahul Ulum.
        </footer>
    </div>

    <?php include '../../partials/footer/pengurus_footer.php'; ?>
</body>
</html>