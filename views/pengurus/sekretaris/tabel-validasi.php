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
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Tabel Validasi</h2>
                <p class="text-muted">Halaman ini bertujuan untuk menampilkan tabel hasil verifikasi terhadap data siswa.</p>
            </div>
            <div class="card">
                <div class="card-header bg-white" style="border-top: none; border-left: none; border-right: none;">
                    <h5 class="mb-0">Daftar Hasil Verifikasi</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                            <th>Nama Murid</th>
                            <th>Hasil Validasi</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($allValidasi)) : ?>
                                <?php foreach ($allValidasi as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['nama_murid'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars(ucfirst($row['hasil'] ?? '-')) ?></td>
                                        <td><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-id="<?= htmlspecialchars($row['id_validasi'] ?? '', ENT_QUOTES) ?>"
                                            data-nama="<?= htmlspecialchars($row['nama_murid'] ?? '', ENT_QUOTES) ?>"
                                            data-hasil="<?= htmlspecialchars($row['hasil'] ?? '', ENT_QUOTES) ?>"
                                            data-keterangan="<?= htmlspecialchars($row['keterangan'] ?? '', ENT_QUOTES) ?>">
                                                <i class="bi bi-pencil-square me-1"></i>Ubah
                                            </button>
                                            <button class="btn btn-sm btn-danger deleteBtn" data-id="<?= htmlspecialchars($row['id_validasi'] ?? '') ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="bi bi-trash me-1"></i>Hapus
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <!-- Add more rows if needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="editModalLabel">
                            Ubah Validasi
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="/miftahul_ulum/controllers/validasi/edit_validasi_handler.php" method="post" id="editForm">
                            <input type="hidden" name="id_validasi" id="editId">
                            <!-- Nama Siswa -->
                            <div class="mb-3">
                                <label class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control" id="editNama" readonly>
                            </div>
                            <!-- Hasil Validasi -->
                            <div class="mb-3">
                                <label class="form-label">Hasil Validasi</label>
                                <select class="form-select" name="hasil" id="editHasil" required>
                                    <option value="">~ Pilih ~</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                            <!-- Keterangan -->
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" id="editKeterangan" required/>
                            </div>
                            <!-- Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-warning px-4">Ubah Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <form action="/miftahul_ulum/controllers/validasi/delete_validasi_handler.php" method="post">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title">Konfirmasi</h5>
                            <input type="hidden" name="id_validasi" id="deleteId">
                        </div>
                        <div class="modal-body text-center">
                            Yakin ingin Menghapus Data?
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger" id="confirmDelete">Hapus</button>
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
            $('#example').DataTable({
                language: {
                    emptyTable: 'Belum ada hasil validasi',
                    zeroRecords: 'Data tidak ditemukan'
                }
            });
        });

        // when edit button clicked
        const editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const hasil = button.getAttribute('data-hasil');
                const keterangan = button.getAttribute('data-keterangan');

                document.getElementById('editId').value = id;
                document.getElementById('editNama').value = nama;
                document.getElementById('editHasil').value = hasil;
                document.getElementById('editKeterangan').value = keterangan;
            });
        }

        // when delete button clicked
        document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            document.getElementById('deleteId').value = id;
            });
        });
    </script>
</body>
</html>