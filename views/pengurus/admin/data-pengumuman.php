<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pengurusName = $_SESSION['pengurus_name'] ?? 'Guest';
$status = $_SESSION['pengurus_status'] ?? null;
if ($status !== 'admin') {
    header('Location: ../../public/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<?php include '../../partials/header/admin_header.php'; ?>
<body>
    <?php include '../../partials/sidebar/admin-sidebar.php'; ?>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg shadow-sm mb-3" style="background-color: #e5d9f2;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <!-- Left: Navbar Brand -->
                <span class="navbar-brand mb-0 h1">
                    Welcome to Dashboard Admin !
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
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Tabel Pengumuman</h2>
                <p class="text-muted">Halaman ini bertujuan untuk menampilkan daftar pengumuman yang telah dibuat oleh admin.</p>
            </div>
            <div class="card">
                <div class="card-header bg-white" style="border-top: none; border-left: none; border-right: none;">
                    <h5 class="mb-0">Daftar Pengumuman yang dibuat</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                            <th>Nama Penulis</th>
                            <th>Judul Pengumuman</th>
                            <th>Waktu Terbit</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($allPengumuman)) : ?>
                                <?php foreach ($allPengumuman as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['nama_pengurus']) ?></td>
                                        <td><?= htmlspecialchars($row['judul']) ?></td>
                                        <td><?= htmlspecialchars($row['waktu_terbit']) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#infoModal">
                                                <i class="bi bi-info-circle me-1"></i>info
                                            </button>
                                            <button class="btn btn-sm btn-danger deleteBtn" data-id="<?= $row['id_pengumuman'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="bi bi-trash me-1"></i>Delete
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
        <div class="modal fade" id="infoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="editModalLabel">
                            Info Pengumuman
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="editForm" enctype="multipart/form-data">
                            <!-- Nama Admin -->
                            <div class="mb-3">
                                <label class="form-label">Nama Admin</label>
                                <input type="text" class="form-control" name="nama_pengurus" readonly />
                            </div>
                            <!-- Judul -->
                            <div class="mb-3">
                                <label class="form-label">Judul Pengumuman</label>
                                <input type="text" class="form-control" name="username" readonly />
                            </div>
                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Pengumuman</label>
                                <textarea class="form-control" name="deskripsi" style="height: 150px; resize: none; overflow-y: auto;" readonly></textarea>
                            </div>
                            <!-- File -->
                            <div class="mb-3">
                                <label class="form-label">File Pendukung</label>
                                <input type="file" class="form-control" name="email" accept=".pdf, .png, .jpeg, .jpg" readonly />
                            </div>
                            <!-- Waktu Terbit -->
                            <div class="mb-3">
                                <label class="form-label">Waktu Terbit</label>
                                <input type="text" class="form-control" name="no_hp" readonly />
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
                    <form action="../../../controllers/pengumuman/delete_pengumuman_handler.php" method="post">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title">Konfirmasi</h5>
                            <input type="hidden" name="id_pengumuman" id="deleteId">
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