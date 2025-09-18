<?php include '../partials/user_header.php'; ?>

<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="sidebarLabel">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="notice.php" class="nav-link text-dark">Pengumuman</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-primary fw-semibold dropdown-toggle" data-bs-toggle="collapse" href="#biodataMenu" role="button" aria-expanded="true" aria-controls="biodataMenu">
          Input Biodata
        </a>
        <div class="collapse show ps-3" id="biodataMenu">
          <a href="biodata_murid.php" class="nav-link fw-semibold">Murid</a>
          <a href="biodata_orangtua.php" class="nav-link">Orangtua</a>
        </div>
      </li>
      <li class="nav-item">
        <a href="hasil_validasi.php" class="nav-link text-dark">Hasil Verifikasi</a>
      </li>
    </ul>
  </div>
</div>

<!-- Main Content -->
<div class="container py-4">
  <h4 class="mb-4 fw-semibold">Form Biodata Murid</h4>

  <div class="card">
    <div class="card-body">
      <form action="../../controllers/user/biodata_murid_handler.php" method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="nama_murid" class="form-label">Nama Murid</label>
            <input type="text" class="form-control" id="nama_murid" name="nama_murid" required>
          </div>
          <div class="col-md-6">
            <label for="nisn" class="form-label">NISN</label>
            <input type="text" class="form-control" id="nisn" name="nisn" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
          </div>
          <div class="col-md-6">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
          </div>
        </div>

        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
        </div>

        <div class="mb-3">
          <label for="file_akta" class="form-label">Upload Akta Kelahiran</label>
          <input type="file" class="form-control" id="file_akta" name="file_akta" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
    </div>
  </div>
</div>

<?php include '../partials/user_footer.php'; ?>
