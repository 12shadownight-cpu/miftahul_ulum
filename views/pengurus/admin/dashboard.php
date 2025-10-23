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

// Ensure the dashboard metrics are always available
$counts = is_array($counts)
    ? array_merge([
        'users' => 0,
        'admins' => 0,
        'sekretaris' => 0,
        'pengumuman' => 0,
    ], $counts)
    : [
        'users' => 0,
        'admins' => 0,
        'sekretaris' => 0,
        'pengumuman' => 0,
    ];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap & icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables & buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" >
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Local CSS-->
    <style>
    html, body {
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
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      padding: 15px 20px;
      flex: 0 0 250px; /* fixed width instead of stretching */
      max-width: 250px; /* limit max size */
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .info-box:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
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
    .bg-blue { background: #17a2b8; }
    .bg-green { background: #28a745; }
    .bg-yellow { background: #ffc107; }
    .bg-red { background: #dc3545; }

    /* Sidebar */
    .sidebar {
      width: 250px;
      height: 100vh;
      background: linear-gradient(to bottom right, #2196f3, #0d47a1);
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

    footer {
      background-color: #e5d9f2;
      padding: 1rem;
      text-align: center;
      font-size: 0.9rem;
      border-top: 1px solid #dee2e6;
    }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/sidebar/admin-sidebar.php'; ?>

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
                <p class="text-muted">Halaman ini bertujuan untuk menampilkan jumlah data yang tersimpan. Seperti jumlah user, admin, sekretaris dan pengumuman.</p>
            </div>
            <div class="info-box-container">
                <div class="info-box">
                    <div class="icon bg-green"><i class="fa-solid fa-user"></i></div>
                    <div class="content">
                        <h4>Jumlah User</h4>
                        <p><?= number_format($counts['users']) ?> Orang</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="icon bg-red"><i class="fa-solid fa-user-tie"></i></div>
                    <div class="content">
                        <h4>Jumlah Sekretaris</h4>
                        <p><?= number_format($counts['sekretaris']) ?> Orang</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="icon bg-blue"><i class="fa-solid fa-user-tie"></i></div>
                    <div class="content">
                        <h4>Jumlah Admin</h4>
                        <p><?= number_format($counts['admins']) ?> Orang</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="icon bg-yellow"><i class="fa-solid fa-comment"></i></div>
                    <div class="content">
                        <h4>Jumlah Pengumuman</h4>
                        <p><?= number_format($counts['pengumuman']) ?> Postingan</p>
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
</body>
</html>