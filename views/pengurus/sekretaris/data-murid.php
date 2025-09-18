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
        <nav class="navbar navbar-expand-lg bg-light shadow-sm mb-3">
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
                <h2 class="fw-bold mb-1">Data Table</h2>
                <p class="text-muted">This table displays sample entries using DataTables plugin.</p>
            </div>
            <div class="card">
                <div class="card-header bg-white" style="border-top: none; border-left: none; border-right: none;">
                    <h5 class="mb-0">Data Table Example</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                            <th>Nama</th>
                            <th>Umur</th>
                            <th>Jenis Kelamin</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Asal TK</th>
                            <th>Alamat</th>
                            <th>NIK</th>
                            <th>No. KK</th>
                            <th>File Akta</th>
                            <th>File KK</th>
                            <th>File Ijazah</th>
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
                                        <td><?= htmlspecialchars($row['tempat_lahir']) ?></td>
                                        <td><?= htmlspecialchars($row['tanggal_lahir']) ?></td>
                                        <td><?= htmlspecialchars($row['asal_tk']) ?></td>
                                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                                        <td><?= htmlspecialchars($row['nik']) ?></td>
                                        <td><?= htmlspecialchars($row['no_kk']) ?></td>
                                        <td><?= htmlspecialchars($row['file_akta']) ?></td>
                                        <td><?= htmlspecialchars($row['file_kk']) ?></td>
                                        <td><?= htmlspecialchars($row['file_ijazah']) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal" title="Edit">
                                                <i class="bi bi-pencil-square me-1"></i>Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <a href="../../../controllers/murid/delete_murid_handler.php"><i class="bi bi-trash me-1"></i>Delete</a>
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

        <!-- Sticky Footer -->
        <footer>
            &copy; 2025 Creative Tim Inspired Layout. All rights reserved.
        </footer>
    </div>
    <?php include '../../partials/footer/pengurus_footer.php'; ?>
</body>
</html>