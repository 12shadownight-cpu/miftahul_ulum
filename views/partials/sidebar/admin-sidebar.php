<!-- Sidebar -->
<div class="sidebar">
  <div class="brand">MENU ADMIN</div>
  <nav class="nav flex-column mt-3">
    <a href="../../../controllers/pengurus/count_pengurus_handler.php" class="nav-link"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <!-- Expandable Dropdown -->
    <a class="nav-link" data-bs-toggle="collapse" href="#noticeLayouts" role="button">
      <i class="bi bi-card-heading"></i>Data Pengumuman
      <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <div class="collapse" id="noticeLayouts">
      <a href="../../../controllers/pengumuman/fetch_pengumuman_handler.php" class="nav-link"><i class="bi bi-table"></i>Tabel Pengumuman</a>
      <a href="../../../controllers/pengumuman/get_pengumuman_handler.php" class="nav-link"><i class="bi bi-keyboard"></i>Input Pengumuman</a>
    </div>
    <!-- Expandable Dropdown -->
    <a class="nav-link" data-bs-toggle="collapse" href="#staffLayouts" role="button">
      <i class="bi bi-person"></i>Data Pengurus
      <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <div class="collapse" id="staffLayouts">
      <a href="../../../controllers/pengurus/fetch_pengurus_handler.php" class="nav-link"><i class="bi bi-table"></i>Tabel Pengurus</a>
      <a href="../../pengurus/admin/input-pengurus.php" class="nav-link"><i class="bi bi-pencil-square"></i>Input Pengurus</a>
    </div>
  </nav>
</div>