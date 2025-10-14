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
                <h2 class="fw-bold mb-1">text-decoration-underline</h2>
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
                                        <td><?= htmlspecialchars($row['nama_murid']) ?></td>
                                        <td><?= htmlspecialchars($row['hasil']) ?></td>
                                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="bi bi-pencil-square me-1"></i>Ubah
                                            </button>
                                            <button class="btn btn-sm btn-danger deleteBtn" data-id="<?= $row['id_validasi'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="bi bi-trash me-1"></i>Hapus
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
                        <form action="" method="post" id="editForm">
                            <!-- Nama Siswa -->
                            <div class="mb-3">
                                <label class="form-label">Nama Siswa</label>
                                <select class="form-select" name="nama_murid" required>
                                    <option value="">~ Pilih ~</option>
                                    <option value="admin">Admin</option>
                                    <option value="sekretaris">Sekretaris</option>
                                </select>
                            </div>
                            <!-- Hasil Validasi -->
                            <div class="mb-3">
                                <label class="form-label">Hasil Validasi</label>
                                <select class="form-select" name="hasil" required>
                                    <option value="">~ Pilih ~</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                            <!-- Keterangan -->
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" required/>
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
                    <form action="" method="post">
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

    <?php include '../../partials/footer/pengurus_footer.php'; ?>

    <script>
        //Prepare the table
        $(document).ready(function () {
            $('#example').DataTable();
        });

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