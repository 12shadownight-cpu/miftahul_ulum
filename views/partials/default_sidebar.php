<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="sidebarLabel">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="notice.php" class="nav-link text-primary fw-semibold">
          Pengumuman
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark dropdown-toggle" data-bs-toggle="collapse" href="#biodataMenu" role="button" aria-expanded="false" aria-controls="biodataMenu">
          Input Biodata
        </a>
        <div class="collapse ps-3" id="biodataMenu">
          <a href="biodata_murid.php" class="nav-link">Murid</a>
          <a href="biodata_orangtua.php" class="nav-link">Orangtua</a>
        </div>
      </li>
      <li class="nav-item">
        <a href="hasil_validasi.php" class="nav-link text-dark">
          Hasil Verifikasi
        </a>
      </li>
    </ul>
  </div>
</div>
