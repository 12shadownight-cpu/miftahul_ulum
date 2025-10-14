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
                    Welcome to Dashboard Sekretaris !
                </span>
                <!-- Right: User & Logout -->
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-semibold">
                        <?= $userName ?>
                    </span>
                    <a href="../../../controllers/pengurus/pengurus_logout_handler.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content container-fluid">
            <div class="px-3 py-2">
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Biodata Siswa</h2>
                <p class="text-muted">Halaman ini bertujuan untuk menampilkan biodata siswa yang telah tersimpan didalam database.</p>
            </div>
            <div class="card">
                <div class="card-header bg-white" style="border-top: none; border-left: none; border-right: none;">
                    <h5 class="mb-0">Daftar Nama Calon Siswa</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                            <th>Nama</th>
                            <th>Umur</th>
                            <th>Jenis Kelamin</th>
                            <th>Asal TK</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($allMurid)) : ?>
                                <?php foreach ($allMurid as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['nama_murid']) ?></td>
                                        <td><?= htmlspecialchars($row['umur_murid']) ?></td>
                                        <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                                        <td><?= htmlspecialchars($row['asal_tk']) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#infoModal">
                                                <i class="bi bi-info-circle me-1"></i>Info
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No data available</td>
                                </tr>
                            <?php endif; ?>
                            <!-- Add more rows if needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Info Modal -->
        <div class="modal fade" id="infoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form enctype="multipart/form-data">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title">
                                Informasi Data Calon Siswa
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Siswa</label>
                                    <input type="text" name="nama_murid" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Umur Siswa</label>
                                    <input type="number" name="umur_murid" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="laki-laki" readonly>
                                        <label class="form-check-label">Laki-Laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="perempuan" readonly>
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                    <input type="text" id="dateAdd" name="tanggal_lahir" value="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Asal TK</label>
                                    <input type="text" name="asal_tk" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" name="alamat" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK</label>
                                    <input type="text" name="no_kk" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Akta Kelahiran</label>
                                    <input type="file" name="file_akta" class="form-control" accept=".png,.jpeg,.jpg" >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Kartu Keluarga</label>
                                    <input type="file" name="file_kk" class="form-control" accept=".png,.jpeg,.jpg" >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Ijazah TK</label>
                                    <input type="file" name="file_ijazah" class="form-control" accept=".png,.jpeg,.jpg" >
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sticky Footer -->
        <footer>
            &copy; 2025 Creative Tim Inspired Layout. All rights reserved.
        </footer>
    </div>

    <?php include '../../partials/footer/pengurus_footer.php'; ?>
    
    <script>
    //Prepare the table
    $(document).ready(function () {
        $('#example').DataTable();
    });
    </script>
</body>
</html>