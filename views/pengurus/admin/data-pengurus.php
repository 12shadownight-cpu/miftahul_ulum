<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pengurusName = $_SESSION['pengurus_name'] ?? 'Guest';
$pengurusId = $_SESSION['pengurus_id'] ?? '';
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
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Tabel Pengurus</h2>
                <p class="text-muted">Halaman ini bertujuan untuk menampilkan data pengurus yang telah tersimpan di Database.</p>
            </div>
            <div class="card">
                <div class="card-header bg-white" style="border-top: none; border-left: none; border-right: none;">
                    <h5 class="mb-0">Daftar Pengurus yang tersedia</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                            <th>Nama Pengurus</th>
                            <th>Nomor Handphone</th>
                            <th>Status Pengurus</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($allPengurus)) : ?>
                                <?php foreach ($allPengurus as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['nama_pengurus']) ?></td>
                                        <td><?= htmlspecialchars($row['no_hp']) ?></td>
                                        <td><?= htmlspecialchars($row['status']) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal" title="Edit"
                                            data-id="<?= htmlspecialchars($row['id_pengurus'], ENT_QUOTES) ?>"
                                            data-nama="<?= htmlspecialchars($row['nama_pengurus'], ENT_QUOTES) ?>"
                                            data-user="<?= htmlspecialchars($row['username'], ENT_QUOTES) ?>"
                                            data-email="<?= htmlspecialchars($row['email'], ENT_QUOTES) ?>"
                                            data-hp="<?= htmlspecialchars($row['no_hp'], ENT_QUOTES) ?>"
                                            data-status="<?= htmlspecialchars($row['status'], ENT_QUOTES) ?>">
                                                <i class="bi bi-pencil-square me-1"></i>Ubah
                                            </button>
                                            <?php if ($row['id_pengurus'] != $pengurusId) : ?>
                                                <button class="btn btn-sm btn-danger deleteBtn" data-id="<?= htmlspecialchars($row['id_pengurus']) ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                    <i class="bi bi-trash me-1"></i>Hapus
                                                </button>
                                            <?php endif; ?>
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
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="editModalLabel">
                            <i class="bi bi-pencil-square me-2"></i>Edit Data Pengurus
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="../../../controllers/pengurus/edit_pengurus_handler.php" method="post" id="editForm">
                            <input type="hidden" name="id_pengurus" id="editId">
                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" id="editNama" class="form-control" name="nama_pengurus" required />
                            </div>
                            <!-- Username -->
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" id="editUser" class="form-control" name="username" required />
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password"/>
                                    <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
                                    <i class="bi bi-eye-slash" id="iconPassword"></i>
                                    </span>
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" id="editEmail" class="form-control" name="email" placeholder="@example.mail.com" required />
                            </div>
                            <!-- No. Handphone -->
                            <div class="mb-3">
                                <label class="form-label">No. Handphone</label>
                                <input type="text" id="editHp" class="form-control" name="no_hp" required />
                            </div>
                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="editStatus" name="status" required>
                                    <option value="">~ Pilih ~</option>
                                    <option value="admin">Admin</option>
                                    <option value="sekretaris">Sekretaris</option>
                                </select>
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer justify-content-center">
                                <button type="submit" form="editForm" class="btn btn-success px-4">
                                    Simpan Data
                                </button>
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
                    <form action="../../../controllers/pengurus/delete_pengurus_handler.php" method="post">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title">Konfirmasi</h5>
                            <input type="hidden" name="id_pengurus" id="deleteId">
                        </div>
                        <div class="modal-body text-center">
                            Yakin ingin menghapus data?
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

        //Password Toogle
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        const iconPassword = document.querySelector("#iconPassword");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            // Toggle icon
            iconPassword.classList.toggle("bi-eye");
            iconPassword.classList.toggle("bi-eye-slash");
        });

        // when edit button clicked
        const editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const user = button.getAttribute('data-user');
                const email = button.getAttribute('data-email');
                const hp = button.getAttribute('data-hp');
                const status = button.getAttribute('data-status');

                document.getElementById('editId').value = id;
                document.getElementById('editNama').value = nama;
                document.getElementById('editUser').value = user;
                document.getElementById('editEmail').value = email;
                document.getElementById('editHp').value = hp;
                document.getElementById('editStatus').value = status;
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