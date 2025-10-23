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
            Selamat datang di Dashboard Admin!
          </span>

          <!-- Right: User & Logout -->
          <div class="d-flex align-items-center">
            <span class="me-3 fw-semibold"><?= htmlspecialchars($pengurusName) ?></span>
            <a href="/mifahul_ulum/controllers/pengurus/pengurus_logout_handler.php" class="btn btn-outline-danger btn-sm">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
          </div>
        </div>
      </nav>

      <!-- Main Content -->
      <div class="main-content container-fluid">
        <div class="px-3 py-2">
          <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Input Pengurus</h2>
          <p class="text-muted">Halaman ini bertujuan untuk menambahkan data pengurus untuk disimpan dalam database.</p>
        </div>
        <div class="card mx-auto" style="max-width: 400px">
          <div class="card">
            <div class="card-body">
              <form action="/miftahul_ulum/controllers/pengurus/add_pengurus_handler.php" method="post">
                <!-- Nama Lengkap -->
                <div class="mb-3">
                  <label class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama_pengurus" required />
                </div>
                <!-- Username -->
                <div class="mb-3">
                  <label class="form-label">Username</label>
                  <input type="text" class="form-control" name="username" required />
                </div>
                <!-- Password -->
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required />
                    <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
                      <i class="bi bi-eye-slash" id="iconPassword"></i>
                    </span>
                  </div>
                </div>
                <!-- Email -->
                <div class="mb-3">
                  <label class="form-label">E-mail</label>
                  <input type="email" class="form-control" name="email" placeholder="@example.mail.com" required />
                </div>
                <!-- No. Handphone -->
                <div class="mb-3">
                  <label class="form-label">No. Handphone</label>
                  <input type="text" class="form-control" name="no_hp" required />
                </div>
                <!-- Status -->
                <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select class="form-select" name="status" required>
                    <option value="">~ Pilih ~</option>
                    <option value="admin">Admin</option>
                    <option value="sekretaris">Sekretaris</option>
                  </select>
                </div>
                <!-- Button -->
                <div class="text-center">
                  <button type="submit" class="btn btn-success px-4">Simpan</button>
                </div>
              </form>
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
      const togglePassword = document.querySelector("#togglePassword");
      const password = document.querySelector("#password");
      const iconPassword = document.querySelector("#iconPassword");

      togglePassword.addEventListener("click", function () {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // Toggle icon
        iconPassword.classList.toggle("bi-eye");
        iconPassword.classList.toggle("bi-eye-slash");
      });
    </script>
</body>
</html>