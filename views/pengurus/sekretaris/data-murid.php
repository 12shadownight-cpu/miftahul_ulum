<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pengurusName = $_SESSION['pengurus_name'] ?? 'Guest';
$status = $_SESSION['pengurus_status'] ?? null;
if ($status !== 'sekretaris') {
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
                    <span class="me-3 fw-semibold"><?= htmlspecialchars($pengurusName) ?></span>
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
                                            <button class="btn btn-sm btn-info me-1 infoBtn" data-bs-toggle="modal" data-bs-target="#infoModal"
                                            data-id="<?= htmlspecialchars($row['id_biodata'], ENT_QUOTES) ?>"
                                            data-nama="<?= htmlspecialchars($row['nama_murid'], ENT_QUOTES) ?>"
                                            data-umur="<?= htmlspecialchars($row['umur_murid'], ENT_QUOTES) ?>"
                                            data-jk="<?= htmlspecialchars($row['jenis_kelamin'], ENT_QUOTES) ?>"
                                            data-tempat="<?= htmlspecialchars($row['tempat_lahir'], ENT_QUOTES) ?>"
                                            data-tanggal="<?= htmlspecialchars($row['tanggal_lahir'], ENT_QUOTES) ?>"
                                            data-asal="<?= htmlspecialchars($row['asal_tk'], ENT_QUOTES) ?>"
                                            data-alamat="<?= htmlspecialchars($row['alamat'], ENT_QUOTES) ?>"
                                            data-nik="<?= htmlspecialchars($row['nik'], ENT_QUOTES) ?>"
                                            data-nokk="<?= htmlspecialchars($row['no_kk'], ENT_QUOTES) ?>"
                                            data-akta="<?= htmlspecialchars($row['file_akta'], ENT_QUOTES) ?>"
                                            data-kk="<?= htmlspecialchars($row['file_kk'], ENT_QUOTES) ?>"
                                            data-ijazah="<?= htmlspecialchars($row['file_ijazah'], ENT_QUOTES) ?>">
                                                <i class="bi bi-info-circle me-1"></i>Info
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada data</td>
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
                            <h5 class="modal-title">Informasi Data Calon Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            <input type="hidden" id="infoId">
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Siswa</label>
                                    <input type="text" id="infoNama" name="nama_murid" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Umur Siswa</label>
                                    <input type="number" id="infoUmur" name="umur_murid" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="infoJkLaki" type="radio" name="jenis_kelamin" value="laki-laki" disabled>
                                        <label class="form-check-label" for="infoJkLaki">Laki-Laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="infoJkPerempuan" type="radio" name="jenis_kelamin" value="perempuan" disabled>
                                        <label class="form-check-label" for="infoJkPerempuan">Perempuan</label>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" id="infoTempat" name="tempat_lahir" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                    <input type="text" id="infoTanggal" name="tanggal_lahir" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Asal TK</label>
                                    <input type="text" id="infoAsal" name="asal_tk" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" id="infoAlamat" name="alamat" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text" id="infoNik" name="nik" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK</label>
                                    <input type="text" id="infoNokk" name="no_kk" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Akta Kelahiran</label>
                                    <div id="infoAkta" class="small">-</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Kartu Keluarga</label>
                                    <div id="infoKk" class="small">-</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File Ijazah TK</label>
                                    <div id="infoIjazah" class="small">-</div>
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

    //When info button clicked
    const infoModal = document.getElementById('infoModal');
    if (infoModal) {
        infoModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            document.getElementById('infoId').value = button.dataset.id || '';
            document.getElementById('infoNama').value = button.dataset.nama || '';
            document.getElementById('infoUmur').value = button.dataset.umur || '';
            document.getElementById('infoTempat').value = button.dataset.tempat || '';
            document.getElementById('infoTanggal').value = button.dataset.tanggal || '';
            document.getElementById('infoAsal').value = button.dataset.asal || '';
            document.getElementById('infoAlamat').value = button.dataset.alamat || '';
            document.getElementById('infoNik').value = button.dataset.nik || '';
            document.getElementById('infoNokk').value = button.dataset.nokk || '';

            const gender = button.dataset.jk || '';
            document.getElementById('infoJkLaki').checked = gender === 'laki-laki';
            document.getElementById('infoJkPerempuan').checked = gender === 'perempuan';

            const updateLink = (containerId, filename) => {
                const container = document.getElementById(containerId);
                if (!container) return;
                if (filename) {
                    const url = '../../assets/uploads/' + encodeURIComponent(filename);
                    container.innerHTML = `<a href="${url}" target="_blank">${filename}</a>`;
                } else {
                    container.textContent = '-';
                }
            };
            updateLink('infoAkta', button.dataset.akta);
            updateLink('infoKk', button.dataset.kk);
            updateLink('infoIjazah', button.dataset.ijazah);
        });
    }
    </script>
</body>
</html>