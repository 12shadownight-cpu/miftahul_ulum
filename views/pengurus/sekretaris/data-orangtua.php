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
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Biodata Orangtua</h2>
                <p class="text-muted">Halaman ini bertujuan untuk menampilkan biodata orangtua yang telah tersimpan didalam database.</p>
            </div>
            <div class="card">
                <div class="card-header bg-white" style="border-top: none; border-left: none; border-right: none;">
                    <h5 class="mb-0">Data Table Example</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                            <th>Nama Ayah</th>
                            <th>Pekerjaan Ayah</th>
                            <th>Nama Ibu</th>
                            <th>Pekerjaan Ibu</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($allOrangtua)) : ?>
                                <?php foreach ($allOrangtua as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['nama_ayah']) ?></td>
                                        <td><?= htmlspecialchars($row['pekerjaan_ayah']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_ibu']) ?></td>
                                        <td><?= htmlspecialchars($row['pekerjaan_ibu']) ?></td>
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
                                Informasi Data Orangtua
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ayah</label>
                                    <input type="text" name="tempat_lahir_ayah" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ibu</label>
                                    <input type="text" name="tempat_lahir_ibu" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ayah</label>
                                    <div class="input-group">
                                    <input type="text" name="tanggal_lahir_ayah" value="" class="form-control dateInput" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ibu</label>
                                    <div class="input-group">
                                    <input type="text" name="tanggal_lahir_ibu" value="" class="form-control dateInput" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ayah</label>
                                    <input type="tel" name="hp_ayah" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ibu</label>
                                    <input type="tel" name="hp_ibu" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ayah</label>
                                    <input type="text" name="nik_ayah" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ibu</label>
                                    <input type="text" name="nik_ibu" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ayah</label>
                                    <input type="text" name="kk_ayah" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ibu</label>
                                    <input type="text" name="kk_ibu" value="" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ayah</label>
                                    <input type="file" name="file_ktp_ayah" class="form-control" accept=".png,.jpeg,.jpg">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ibu</label>
                                    <input type="file" name="file_ktp_ibu" class="form-control" accept=".png,.jpeg,.jpg">
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