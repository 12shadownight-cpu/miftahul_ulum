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
          <h2 class="fw-bold mb-1">Halaman Verifikasi Data</h2>
          <p class="text-muted">Halaman ini bertujuan untuk menentukan apakah data siswa yang telah terdaftar diterima atau ditolak.</p>
        </div>
        <div class="card mx-auto" style="max-width: 400px">
          <div class="card">
            <div class="card-body">
              <form action="../../../controllers/validasi/add_validasi_handler.php" method="post">
                <!-- Nama Siswa -->
                <div class="mb-3">
                  <label class="form-label">Nama Murid</label>
                  <select class="form-select" name="nama_murid" required>
                    <option value="">~ Pilih ~</option>
                    <option value="admin">Admin</option>
                    <option value="sekretaris">Sekretaris</option>
                  </select>
                </div>
                <!-- Hasil Validasi -->
                <div class="mb-3">
                  <label class="form-label">Hasil Validasi</label>
                  <select class="form-select" name="hasil" required>
                    <option value="">~ Pilih ~</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                  </select>
                </div>
                <!-- Keterangan -->
                <div class="mb-3">
                  <label class="form-label">Keterangan</label>
                  <input type="text" class="form-control" name="keterangan" required />
                </div>
                <!-- Button -->
                <div class="text-center">
                  <button type="submit" class="btn btn-success px-4">Simpan Data</button>
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