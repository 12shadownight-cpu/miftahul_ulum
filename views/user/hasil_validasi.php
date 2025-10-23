<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userName = $_SESSION['user_name'] ?? 'Guest';

// Normalise hasil validasi data to an indexed list so the table renders consistently
$validasiRows = [];
if (!empty($getValidasi)) {
    if (is_array($getValidasi)) {
        $isAssociative = array_keys($getValidasi) !== range(0, count($getValidasi) - 1);
        $validasiRows = $isAssociative ? [$getValidasi] : $getValidasi;
    }
}
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

    .main-content {
      flex: 1;
      padding: 1rem;
    }

    .no-border {
      border-top: none;
      border-left: none;
      border-right: none;
    }

    footer {
      background-color: #f2d0a4;
      padding: 1rem;
      text-align: center;
      font-size: 0.9rem;
      border-top: 1px solid #dee2e6;
    }

    #example {
      border-collapse: collapse;
      width: 100%;
    }

    #example th,
    #example td {
      text-align: center;
      vertical-align: middle;
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
                    Selamat datang di Dashboard User !
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
                            <?php if (!empty($validasiRows)) : ?>
                                <?php foreach ($validasiRows as $row) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['hasil'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
                                        <?php if (isset($row['hasil']) && strtolower($row['hasil']) === "diterima") : ?>
                                            <td>
                                                <a href="../../controllers/validasi/print_validasi_handler.php?id=<?= htmlspecialchars($row['id_validasi']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary me-1">
                                                    <i class="bi bi-printer me-1"></i>Cetak
                                                </a>
                                            </td>
                                        <?php else : ?>
                                            <td>
                                                <a class="btn btn-sm btn-secondary disabled me-1">
                                                    <i class="bi bi-printer me-1"></i>Cetak
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
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

    <?php require_once __DIR__ . '/../partials/footer/user_footer.php'; ?>

    <script>
        //Prepare the table
        $(document).ready(function () {
            $('#example').DataTable({
                language: {
                    emptyTable: 'Belum ada hasil validasi',
                    zeroRecords: 'Data tidak ditemukan'
                }
            });
        });
    </script>
</body>
</html>