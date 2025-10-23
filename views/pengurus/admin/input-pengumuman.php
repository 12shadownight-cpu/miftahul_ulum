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
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap & icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables & buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" >
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
      background: linear-gradient(to bottom right, #2196f3, #0d47a1);
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
      background-color: #e5d9f2;
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
    <?php require_once __DIR__ . '/../../partials/sidebar/admin-sidebar.php'; ?>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg shadow-sm mb-3" style="background-color: #e5d9f2;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <!-- Left: Navbar Brand -->
                <span class="navbar-brand mb-0 h1">
                    Selamat datang di Dashboard Admin !
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
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Input Pengumuman</h2>
                <p class="text-muted">Halaman ini bertujuan untuk mengolah data pengumuman. Baik berupa menambah, mengubah ataupun menghapus data.</p>
            </div>
            <div class="card">
                <div class="card-header bg-white" style="border-top: none; border-left: none; border-right: none;">
                    <h5 class="mb-0">Daftar pengumuman yang dibuat</h5>
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
                            <?php foreach ($getPengumuman as $row) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nama_pengurus']) ?></td>
                                    <td><?= htmlspecialchars($row['judul']) ?></td>
                                    <td><?= htmlspecialchars($row['waktu_terbit']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-id="<?= htmlspecialchars($row['id_pengumuman'], ENT_QUOTES) ?>"
                                        data-nama="<?= htmlspecialchars($row['nama_pengurus'], ENT_QUOTES) ?>"
                                        data-judul="<?= htmlspecialchars($row['judul'], ENT_QUOTES) ?>"
                                        data-deskripsi="<?= htmlspecialchars($row['deskripsi'], ENT_QUOTES) ?>"
                                        data-file="<?= htmlspecialchars($row['file_pendukung'], ENT_QUOTES) ?>">
                                            <i class="bi bi-pencil-square me-1"></i>Ubah
                                        </button>
                                        <button class="btn btn-sm btn-danger deleteBtn" data-id="<?= $row['id_pengumuman'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash me-1"></i>Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- Add more rows if needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header bg-success">
                        <h5 class="modal-title" id="addModalLabel">
                            Tambah Pengumuman
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="/miftahul_ulum/controllers/pengumuman/add_pengumuman_handler.php" method="post" id="addForm" enctype="multipart/form-data">
                            <input type="hidden" name="id_pengurus" value="<?= htmlspecialchars($pengurusId) ?>">
                            <!-- Nama Admin -->
                            <div class="mb-3">
                                <label class="form-label">Nama Penulis</label>
                                <input type="text" class="form-control" name="nama_pengurus" value="<?= htmlspecialchars($pengurusName) ?>" readonly/>
                            </div>
                            <!-- Judul -->
                            <div class="mb-3">
                                <label class="form-label">Judul Pengumuman</label>
                                <input type="text" class="form-control" name="judul" required/>
                            </div>
                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Pengumuman</label>
                                <textarea class="form-control" name="deskripsi" style="height: 150px; resize: none; overflow-y: auto;" required></textarea>
                            </div>
                            <!-- File -->
                            <div class="mb-3">
                                <label class="form-label">File Pendukung</label>
                                <input type="file" class="form-control" name="file_pendukung" accept=".pdf, .docx, .png, .jpeg, .jpg" required/>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success">Simpan Data</button>
                            </div>
                        </form>
                    </div>
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
                            Ubah Pengumuman
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="/miftahul_ulum/controllers/pengumuman/edit_pengumuman_handler.php" method="post" id="editForm" enctype="multipart/form-data">
                            <input type="hidden" name="id_pengumuman" id="editId">
                            <!-- Nama Admin -->
                            <div class="mb-3">
                                <label class="form-label">Nama Admin</label>
                                <input type="text" id="editNama" class="form-control" name="nama_pengurus" value="" readonly/>
                            </div>
                            <!-- Judul -->
                            <div class="mb-3">
                                <label class="form-label">Judul Pengumuman</label>
                                <input type="text" id="editJudul" class="form-control" name="judul" value="" required/>
                            </div>
                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Pengumuman</label>
                                <textarea class="form-control" id="editDeskripsi" name="deskripsi"  style="height: 150px; resize: none; overflow-y: auto;" required></textarea>
                            </div>
                            <!-- File -->
                            <div class="mb-3">
                                <label class="form-label">File Pendukung</label>
                                <div class="small" id="editFile"></div>
                                <input type="file" class="form-control" name="file_pendukung" accept=".pdf, .docx, .png, .jpeg, .jpg"/>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-warning">Ubah Data</button>
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
                    <form action="/miftahul_ulum/controllers/pengumuman/delete_pengumuman_handler.php" method="post">
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
            &copy; 2025 Madrasah Ibtidaiyah Miftahul Ulum.
        </footer>
    </div>

    <?php require_once __DIR__ . '/../../partials/footer/pengurus_footer.php'; ?>

    <script>
        //Prepare the table
        $(document).ready(function () {
            $('#example').DataTable({
            dom: '<"d-flex justify-content-between align-items-center mb-2 me-5"lB>t<"d-flex justify-content-between"ip>',
            language: {
                    emptyTable: 'Belum ada hasil validasi',
                    zeroRecords: 'Data tidak ditemukan'
                },
            buttons: [
                {
                text: '<i class="bi bi-plus-circle me-1"></i>Tambah',
                className: 'btn btn-sm btn-success',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#addModal'
                }
                }
            ],
            searching: false
            });
        });

        // when edit button clicked
        const editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const judul = button.getAttribute('data-judul');
                const deskripsi = button.getAttribute('data-deskripsi');
                const file = button.getAttribute('data-file');
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

                document.getElementById('editId').value = id;
                document.getElementById('editNama').value = nama;
                document.getElementById('editJudul').value = judul;
                document.getElementById('editDeskripsi').value = deskripsi;
                updateLink('editFile', file);
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