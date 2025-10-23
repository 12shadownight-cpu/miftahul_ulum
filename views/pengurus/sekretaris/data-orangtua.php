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
<head>
    <meta charset="UTF-8">
    <title>Dashboard Sekretaris</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap & icon CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Local CSS-->
     <style>
        html, body {
        height: 100%;
        margin: 0;
        }

        body {
        display: flex;
        font-family: 'Segoe UI', sans-serif;
        }

        /* Sidebar */
        .sidebar {
        width: 250px;
        height: 100vh;
        background: linear-gradient(to bottom right, #f44336, #b71c1c);
        color: white;
        position: fixed;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        }

        .sidebar .brand {
        padding: 1.5rem;
        font-size: 1.25rem;
        font-weight: bold;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-link {
        color: white;
        padding: 0.75rem 1.5rem;
        display: flex;
        align-items: center;
        font-weight: 500;
        transition: background 0.3s;
        cursor: pointer;
        }

        .nav-link:hover,
        .nav-link.active {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        }

        .nav-link i {
        margin-right: 1rem;
        font-size: 1.2rem;
        }

        .collapse .nav-link {
        padding-left: 3.5rem;
        font-size: 0.95rem;
        }

        .upgrade-btn {
        margin: auto 1.5rem 1.5rem 1.5rem;
        padding: 0.6rem;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        text-align: center;
        transition: background 0.3s;
        }

        .upgrade-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        }

        /* Wrapper for navbar + main content + footer */
        .main-wrapper {
        margin-left: 250px;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        width: 100%;
        }

        .main-content {
        flex: 1;
        padding: 1rem;
        }

        .modal-header {
        position: relative;      /* anchor for absolute positioning */
        display: flex;
        justify-content: center; /* center title */
        }

        .modal-title {
        text-align: center;
        flex-grow: 1;
        }

        .no-border {
            border-top: none;
            border-left: none;
            border-right: none;
        }

        footer {
        background-color: #b8b8f3;
        padding: 1rem;
        text-align: center;
        font-size: 0.9rem;
        border-top: 1px solid #dee2e6;
        }

        #example {
        border-collapse: collapse;
        width: 100%;
        }

        #example th,
        #example td {
        text-align: center;
        vertical-align: middle;
        }
     </style>
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/sidebar/sekretaris-sidebar.php'; ?>
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
                    <a href="/mifahul_ulum/controllers/pengurus/pengurus_logout_handler.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content container-fluid">
            <div class="px-3 py-2">
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Biodata Orangtua</h2>
                <p class="text-muted">Halaman ini bertujuan untuk menampilkan biodata orangtua yang telah tersimpan di dalam database.</p>
            </div>
            <div class="card">
                <div class="card-header bg-white" style="border-top: none; border-left: none; border-right: none;">
                    <h5 class="mb-0">Daftar Biodata Orangtua</h5>
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
                                        <td><?= htmlspecialchars($row['nama_ayah'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['pekerjaan_ayah'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['nama_ibu'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['pekerjaan_ibu'] ?? '-') ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info me-1 infoBtn" data-bs-toggle="modal" data-bs-target="#infoModal"
                                            data-id="<?= htmlspecialchars($row['id_orangtua'] ?? '', ENT_QUOTES) ?>"
                                            data-na="<?= htmlspecialchars($row['nama_ayah'] ?? '', ENT_QUOTES) ?>"
                                            data-ni="<?= htmlspecialchars($row['nama_ibu'] ?? '', ENT_QUOTES) ?>"
                                            data-tela="<?= htmlspecialchars($row['tempat_lahir_ayah'] ?? '', ENT_QUOTES) ?>"
                                            data-teli="<?= htmlspecialchars($row['tempat_lahir_ibu'] ?? '', ENT_QUOTES) ?>"
                                            data-tala="<?= htmlspecialchars($row['tanggal_lahir_ayah'] ?? '', ENT_QUOTES) ?>"
                                            data-tali="<?= htmlspecialchars($row['tanggal_lahir_ibu'] ?? '', ENT_QUOTES) ?>"
                                            data-pa="<?= htmlspecialchars($row['pekerjaan_ayah'] ?? '', ENT_QUOTES) ?>"
                                            data-pi="<?= htmlspecialchars($row['pekerjaan_ibu'] ?? '', ENT_QUOTES) ?>"
                                            data-ha="<?= htmlspecialchars($row['hp_ayah'] ?? '', ENT_QUOTES) ?>"
                                            data-hi="<?= htmlspecialchars($row['hp_ibu'] ?? '', ENT_QUOTES) ?>"
                                            data-nia="<?= htmlspecialchars($row['nik_ayah'] ?? '', ENT_QUOTES) ?>"
                                            data-nii="<?= htmlspecialchars($row['nik_ibu'] ?? '', ENT_QUOTES) ?>"
                                            data-ka="<?= htmlspecialchars($row['kk_ayah'] ?? '', ENT_QUOTES) ?>"
                                            data-ki="<?= htmlspecialchars($row['kk_ibu'] ?? '', ENT_QUOTES) ?>"
                                            data-kta="<?= htmlspecialchars($row['file_ktp_ayah'] ?? '', ENT_QUOTES) ?>"
                                            data-kti="<?= htmlspecialchars($row['file_ktp_ibu'] ?? '', ENT_QUOTES) ?>">
                                                <i class="bi bi-info-circle me-1"></i>Info
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada data tersimpan</td>
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
                                <input type="hidden" id="infoId">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" id="infoNamaAyah" name="nama_ayah" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" id="infoNamaIbu" name="nama_ibu" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ayah</label>
                                    <input type="text" id="infoTempatAyah" name="tempat_lahir_ayah" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ibu</label>
                                    <input type="text" id="infoTempatIbu" name="tempat_lahir_ibu" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ayah</label>
                                    <div class="input-group">
                                    <input type="text" id="infoTanggalAyah" name="tanggal_lahir_ayah" class="form-control dateInput" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ibu</label>
                                    <div class="input-group">
                                    <input type="text" id="infoTanggalIbu" name="tanggal_lahir_ibu" class="form-control dateInput" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" id="infoKerjaAyah" name="pekerjaan_ayah" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" id="infoKerjaIbu" name="pekerjaan_ibu" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ayah</label>
                                    <input type="tel" id="infoNoAyah" name="hp_ayah" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone Ibu</label>
                                    <input type="tel" id="infoNoIbu" name="hp_ibu" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ayah</label>
                                    <input type="text" id="infoNikAyah" name="nik_ayah" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ibu</label>
                                    <input type="text" id="infoNikIbu" name="nik_ibu" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ayah</label>
                                    <input type="text" id="infoKkAyah" name="kk_ayah" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. KK Ibu</label>
                                    <input type="text" id="infoKkIbu" name="kk_ibu" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ayah</label>
                                    <div id="infoKtpAyah" class="small">-</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">File KTP Ibu</label>
                                    <div id="infoKtpIbu" class="small">-</div>
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

    <?php require_once __DIR__ . '/../../partials/footer/pengurus_footer.php'; ?>

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
                document.getElementById('infoNamaAyah').value = button.dataset.na || '';
                document.getElementById('infoNamaIbu').value = button.dataset.ni || '';
                document.getElementById('infoTempatAyah').value = button.dataset.tela || '';
                document.getElementById('infoTempatIbu').value = button.dataset.teli || '';
                document.getElementById('infoTanggalAyah').value = button.dataset.tala || '';
                document.getElementById('infoTanggalIbu').value = button.dataset.tali || '';
                document.getElementById('infoKerjaAyah').value = button.dataset.pa || '';
                document.getElementById('infoKerjaIbu').value = button.dataset.pi || '';
                document.getElementById('infoNoAyah').value = button.dataset.ha || '';
                document.getElementById('infoNoIbu').value = button.dataset.hi || '';
                document.getElementById('infoNikAyah').value = button.dataset.nia || '';
                document.getElementById('infoNikIbu').value = button.dataset.nii || '';
                document.getElementById('infoKkAyah').value = button.dataset.ka || '';
                document.getElementById('infoKkIbu').value = button.dataset.ki || '';

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
                updateLink('infoKtpAyah', button.dataset.kta);
                updateLink('infoKtpIbu', button.dataset.kti);
            });
        }
    </script>
</body>
</html>