<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pengurusName = $_SESSION['pengurus_name'] ?? 'Guest';
$status = $_SESSION['pengurus_status'] ?? null;
if ($status !== 'sekretaris') {
    header('Location: ../../public/index.php');
    exit;
}

// Ensure $counts is always populated
if (!is_array($counts)) {
    $counts = [];
}

$counts = array_merge([
    'diterima'   => 0,
    'ditolak'    => 0,
    'id_biodata' => 0,
    'hasil'      => 0,
], $counts);

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
<head>
    <meta charset="UTF-8">
    <title>Dashboard Sekretaris</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap & icon CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Local CSS-->
    <style>
    html,
    body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f9;
    }

    h2 {
      font-weight: 600;
      margin-bottom: 20px;
      color: #333;
    }

    .info-box-container {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }

    .info-box {
      display: flex;
      align-items: center;
      background: #fff;
      border-radius: 6px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      padding: 15px 20px;
      flex: 0 0 250px; /* fixed width instead of stretching */
      max-width: 250px; /* limit max size */
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .info-box:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .info-box .icon {
      width: 50px;
      height: 50px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 22px;
      margin-right: 15px;
    }

    .info-box .content h4 {
      margin: 0;
      font-size: 14px;
      color: #555;
    }

    .info-box .content p {
      margin: 5px 0 0;
      font-weight: bold;
      font-size: 16px;
    }

    /* Colors */
    .bg-student {
      background: linear-gradient(45deg, #28a745, #ffff00);
    }
    .bg-result {
      background: linear-gradient(45deg, #3191d1ff, #ee4d70ff);
    }

    .d-flex .card + .card {
      margin-left: 80px; /* adjust the px value as needed */
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      height: 100vh;
      background: linear-gradient(to bottom right, #f44336, #b71c1c);
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
    }

    .nav-link i {
      margin-right: 1rem;
      font-size: 1.2rem;
    }

    .collapse .nav-link {
      padding-left: 3.5rem;
      font-size: 0.95rem;
    }

    .upgrade-btn {
      margin: auto 1.5rem 1.5rem 1.5rem;
      padding: 0.6rem;
      background: rgba(255, 255, 255, 0.2);
      border: none;
      border-radius: 10px;
      color: white;
      font-weight: 600;
      text-align: center;
      transition: background 0.3s;
    }

    .upgrade-btn:hover {
      background: rgba(255, 255, 255, 0.3);
    }

    /* Wrapper for navbar + main content + footer */
    .main-wrapper {
      margin-left: 250px;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      width: 100%;
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

    .row.gx-custom {
      --bs-gutter-x: 1rem; /* adjust value */
    }


    footer {
      background-color: #b8b8f3;
      padding: 1rem;
      text-align: center;
      font-size: 0.9rem;
      border-top: 1px solid #dee2e6;
    }

    #pieChart1,
    #pieChart2 {
      width: 200px !important;
      height: 200px !important;
      margin: 0 auto; /* keeps chart centered inside the card */
      display: block;
    }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/sidebar/sekretaris-sidebar.php'; ?>

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
                    <span class="me-3 fw-semibold"><?= htmlspecialchars($pengurusName) ?></span>
                    <a href="/miftahul_ulum/controllers/pengurus/pengurus_logout_handler.php" class="btn btn-outline-danger btn-sm">
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
                        <div class="icon bg-student">
                            <i class="fa-solid fa-flag"></i>
                        </div>
                        <div class="content">
                            <h4>Jumlah calon siswa terdaftar</h4>
                            <p><?= number_format($counts['id_biodata']) ?> orang</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 me-5">
                    <div class="info-box h-100">
                        <div class="icon bg-result">
                            <i class="fa-solid fa-upload"></i>
                        </div>
                        <div class="content">
                            <h4>Jumlah hasil verifikasi terdaftar</h4>
                            <p><?= number_format($counts['hasil']) ?> daftar</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row gx-custom justify-content-center mt-3">
                <div class="col-md-3 me-5">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-center">Persentase Calon Siswa</h5>
                            <canvas id="studentChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 me-5">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-center">Persentase Hasil Validasi</h5>
                            <canvas id="resultChart"></canvas>
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

    <?php require_once __DIR__ . '/../../partials/footer/pengurus_footer.php'; ?>
    <script>
        const counts = <?= json_encode($counts) ?>;
        const totals = <?= json_encode($totals) ?>;
        const allZero = <?= $allZero ? 'true' : 'false' ?>;
        const allVoid = <?= $allVoid ? 'true' : 'false' ?>;

        new Chart(document.getElementById('resultChart'), {
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
        
        new Chart(document.getElementById('studentChart'), {
            type: 'pie',
            data: {
                labels: ['Laki-Laki', 'Perempuan'],
                datasets: [{
                    label: 'Jenis Kelamin',
                    data: [totals['laki-laki'], totals.perempuan],
                    backgroundColor: allVoid ? ['#FFFFFF', '#FFFFFF'] : ['#54EF36FF', '#F5FF63FF'],
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