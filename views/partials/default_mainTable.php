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

<!-- Main Content -->
<div class="container py-4">
    <h4 class="mb-4 fw-semibold">Pengumuman</h4>

    <!-- DataTable -->
    <div class="card">
        <div class="card-body">
            <table id="noticeTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Static Rows (replace with PHP loop) -->
                    <tr>
                        <td>1</td>
                        <td>Pendaftaran Dibuka</td>
                        <td>Pendaftaran siswa baru telah dibuka mulai 1 Juli.</td>
                        <td>2025-07-01</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jadwal Tes</td>
                        <td>Jadwal tes akan diumumkan tanggal 10 Juli.</td>
                        <td>2025-07-05</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables CSS & JS (place before footer if needed globally) -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = new DataTable('#noticeTable');
    });
</script>

<?php include '../partials/user_footer.php'; ?>


