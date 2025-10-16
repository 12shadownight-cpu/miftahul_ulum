<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pengurusName = $_SESSION['pengurus_name'] ?? 'Guest';
if ($_SESSION['pengurus_status'] !== 'admin') {
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
            Selamat datang di Dashboard Admin!
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
          <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Input Pengurus</h2>
          <p class="text-muted">Halaman ini bertujuan untuk menambahkan data pengurus untuk disimpan dalam database.</p>
        </div>
        <div class="card mx-auto" style="max-width: 400px">
          <div class="card">
            <div class="card-body">
              <form action="../../../controllers/pengurus/add_pengurus_handler.php" method="post">
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

    <?php include '../../partials/footer/pengurus_footer.php'; ?>

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