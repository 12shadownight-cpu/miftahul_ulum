<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pengurusName = $_SESSION['pengurus_name'] ?? 'Guest';
if ($_SESSION['pengurus_status'] !== 'sekretaris') {
    header('Location: ../../public/index.php');
    exit;
}

// Ensure $counts is valid
if (!is_array($counts)) {
    $counts = ['diterima' => 0, 'ditolak' => 0];
} else {
    $counts = array_merge(['diterima' => 0, 'ditolak' => 0], $counts);
}

// Check if all values are 0
$allZero = ($counts['diterima'] == 0 && $counts['ditolak'] == 0);

// Ensure $totals is valid
if (!is_array($totals)) {
    $totals = ['laki-laki' => 0, 'perempuan' => 0];
} else {
    $totals = array_merge(['laki-laki' => 0, 'perempuan' => 0], $totals);
}

// Check if all values are 0
$allVoid = ($totals['laki-laki'] == 0 && $totals['perempuan'] == 0);
?>
<!DOCTYPE html>
<html>
<?php include '../../partials/header/sekretaris_header.php'; ?>
<body>
    <?php include '../../partials/sidebar/sekretaris-sidebar.php'; ?>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg shadow-sm mb-3" style="background-color: #b8b8f3;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <!-- Left: Navbar Brand -->
                <span class="navbar-brand mb-0 h1">
                    Selamat datang di Dashboard Sekretaris!
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
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Dashboard</h2>
                <p class="text-muted">
                    Halaman ini bertujuan untuk menampilkan jumlah data yang tersimpan, seperti jumlah siswa yang terdaftar dan terverifikasi.
                </p>
            </div>

            <!-- Info Boxes Row -->
            <div class="row gx-custom justify-content-center">
                <div class="col-md-3 me-5">
                    <div class="info-box h-100">
                        <div class="icon bg-green">
                            <i class="fa-solid fa-flag"></i>
                        </div>
                        <div class="content">
                            <h4>Bookmarks</h4>
                            <p>410</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 me-5">
                    <div class="info-box h-100">
                        <div class="icon bg-yellow">
                            <i class="fa-solid fa-upload"></i>
                        </div>
                        <div class="content">
                            <h4>Uploads</h4>
                            <p>13,648</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row gx-custom justify-content-center mt-3">
                <div class="col-md-3 me-5">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-center">User Engagement</h5>
                            <canvas id="pieChart1"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 me-5">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-center">Data Distribution</h5>
                            <canvas id="pieChart2"></canvas>
                        </div>
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
    <script>
        const counts = <?= json_encode($counts) ?>;
        const allZero = <?= $allZero ? 'true' : 'false' ?>;

        new Chart(document.getElementById('validasiChart'), {
            type: 'pie',
            data: {
                labels: ['Diterima', 'Ditolak'],
                datasets: [{
                    label: 'Hasil Validasi',
                    data: [counts.diterima, counts.ditolak],
                    backgroundColor: allZero ? ['#FFFFFF', '#FFFFFF'] : ['#36A2EB', '#FF6384'],
                    borderColor: '#ccc'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        const totals = <?= json_encode($totals) ?>;
        const allVoid = <?= $allVoid ? 'true' : 'false' ?>;
        
        new Chart(document.getElementById('muridChart'), {
            type: 'pie',
            data: {
                labels: ['Laki-Laki', 'Perempuan'],
                datasets: [{
                    label: 'Jenis Kelamin',
                    data: [counts.laki-laki, counts.perempuan],
                    backgroundColor: allZero ? ['#FFFFFF', '#FFFFFF'] : ['#54EF36FF', '#F5FF63FF'],
                    borderColor: '#ccc'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>
</body>
</html>