<!-- Sidebar -->
<div class="sidebar">
  <div class="brand">SEKRETARIS MENU</div>
  <nav class="nav flex-column mt-3">
    <a href="../../../controllers/validasi/count_validasi_handler.php" class="nav-link"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <!-- Expandable Dropdown -->
    <a class="nav-link" data-bs-toggle="collapse" href="#bioLayouts" role="button">
      <i class="bi bi-card-list"></i>Tabel Biodata
      <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <div class="collapse" id="bioLayouts">
      <a href="../../../controllers/murid/fetch_murid_handler.php" class="nav-link"><i class="bi bi-person"></i>Biodata Siswa</a>
      <a href="../../../controllers/orangtua/fetch_orangtua_handler.php" class="nav-link"><i class="bi bi-person"></i>Biodata Orangtua</a>
    </div>
    <!-- Expandable Dropdown -->
    <a class="nav-link" data-bs-toggle="collapse" href="#checkLayouts" role="button">
      <i class="bi bi-folder-check"></i>Verifikasi Data
      <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <div class="collapse" id="checkLayouts">
      <a href="../../../controllers/validasi/fetch_validasi_handler.php" class="nav-link"><i class="bi bi-table"></i>Tabel Verifikasi</a>
      <a href="../../pengurus/sekretaris/validasi.php" class="nav-link"><i class="bi bi-file-earmark-check"></i>Verifikasi</a>
    </div>
  </nav>
</div>