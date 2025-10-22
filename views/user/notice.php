<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userName = $_SESSION['user_name'] ?? 'Guest';

//Convert timestamp
function timeAgo($datetime) {
    if (empty($datetime)) {
        return 'Waktu tidak diketahui';
    }
    $time = strtotime($datetime);
    if ($time === false) {
        return 'Waktu tidak diketahui';
    }
    $diff = time() - $time;

    if ($diff < 60) {
        return $diff . ' detik lalu';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . ' menit lalu';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . ' jam lalu';
    } elseif ($diff < 604800) {
        return floor($diff / 86400) . ' hari lalu';
    } elseif ($diff < 2592000) {
        return floor($diff / 604800) . ' minggu lalu';
    } elseif ($diff < 31536000) {
        return floor($diff / 2592000) . ' bulan lalu';
    } 
    return floor($diff / 31536000) . ' tahun lalu'; 
}
$announcementList = [];
if (isset($announcement) && is_array($announcement)) {
    $announcementList = $announcement;
}
?>
<!DOCTYPE html>
<html lang="id">
<?php include '../partials/header/user_header.php'; ?>
<body>
    <?php include '../partials/sidebar/user-sidebar.php'; ?>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg shadow-sm mb-3" style="background-color: #f2d0a4;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <!-- Left: Navbar Brand -->
                <span class="navbar-brand mb-0 h1">
                    Selamat datang di Dashboard User!
                </span>
                <!-- Right: User & Logout -->
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-semibold"><?= htmlspecialchars($userName) ?></span>
                    <a href="../../controllers/user/user_logout_handler.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content container-fluid">
            <div class="px-3 py-2">
                <h2 class="fw-bold mb-1 text-decoration-underline">Halaman Pengumuman</h2>
                <p class="text-muted">Halaman ini bertujuan untuk menyampaikan pengumuman kepada calon siswa dan siswi MI Miftahul Ulum Batam.</p>
            </div>
            <div id="announcement-list">
                <?php if (empty($announcementList)): ?>
                    <div class="alert alert-info" role="alert">
                        Belum ada pengumuman terbaru untuk ditampilkan.
                    </div>
                <?php else: ?>
                    <!-- Announcement list -->
                    <?php foreach ($announcement as $row): ?>
                        <?php
                            $fileName = $row['file_pendukung'] ?? '';
                            $fileUrl = $fileName !== '' ? '../../assets/uploads/' . rawurlencode($fileName) : '';
                            $pengurusName = $row['nama_pengurus'] ?? 'Administrator';
                            $publishedAt = $row['waktu_terbit'] ?? null;
                        ?>
                        <div class="card announcement-card" id="announcement<?= $row['id_pengumuman'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['judul'] ?? 'tanpa judul') ?></h5>
                                <p class="card-text"><?= htmlspecialchars($row['deskripsi'] ?? '-') ?></p>
                                <?php if ($fileUrl): ?>
                                    <p class="attachment">
                                        <i class="bi bi-paperclip"></i>
                                        <a href="<?= htmlspecialchars($fileUrl) ?>" target="_blank" rel="noopener noreferrer">
                                            <?= htmlspecialchars($fileName) ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                                <p class="timestamp" data-time="<?= htmlspecialchars($publishedAt ?? '') ?>" data-author="<?= htmlspecialchars($pengurusName) ?>">
                                    Published: <?= timeAgo($publishedAt) ?> By <?= htmlspecialchars($pengurusName) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sticky Footer -->
        <footer>
            &copy; 2025 Madrasah Ibtidaiyah Miftahul Ulum.
        </footer>
    </div>

    <?php include '../partials/footer/user_footer.php'; ?>

    <script>
        //1st script
        //Share announcement script
        document.addEventListener("DOMContentLoaded", function () {
            const cards = document.querySelectorAll('.announcement-card .card-body');
            cards.forEach((card, index) => {
                const title = card.querySelector('.card-title')?.innerText ?? '';
                const text = card.querySelector('.card-text')?.innerText ?? '';
                const cardId = card.closest('.announcement-card')?.id ?? `announcement${index + 1}`;
                const pageUrl = `${window.location.href.split('#')[0]}#${cardId}`;

                if (!title && !text) {
                    return;
                }

                // Create share buttons
                const shareText = encodeURIComponent(`${title} - ${text} ${pageUrl}`);
                const shareUrl = encodeURIComponent(pageUrl);

                const btnWrapper = document.createElement('div');
                btnWrapper.classList.add('mt-3');
                btnWrapper.innerHTML = `
                    <a href="https://www.facebook.com/sharer/sharer.php?u=${shareUrl}"
                        target="_blank" 
                        class="btn btn-primary btn-sm me-2">
                        <i class="bi bi-facebook"></i> Share
                    </a>
                    <a href="https://api.whatsapp.com/send?text=${shareText}"
                        target="_blank" 
                        class="btn btn-success btn-sm">
                        <i class="bi bi-whatsapp"></i> Share
                    </a>
                `;

                card.appendChild(btnWrapper);
            });
            // Automatic card-text URL detection
            document.querySelectorAll('.card-text').forEach(el => {
                linkifySafe(el);
            });

            updateTimestamps();
            setInterval(updateTimestamps, 30000);
        });

        //2nd script
        //Automatic card-text URL detection
        function linkifySafe(element) {
            const urlPattern = /(https?:\/\/[^\s]+)/g;
            const nodes = Array.from(element.childNodes);
            element.textContent = '';

            nodes.forEach(node => {
                if (node.nodeType === Node.TEXT_NODE) {
                    // For plain text nodes, split and convert URLs
                    const parts = node.textContent.split(urlPattern);
                    parts.forEach(part => {
                        if (urlPattern.test(part)) {
                            const a = document.createElement("a");
                            a.href = part;
                            a.target = "_blank";
                            a.rel = "noopener noreferrer";
                            a.textContent = part;
                            element.appendChild(a);
                        } else {
                            element.appendChild(document.createTextNode(part));
                        }
                    });
                } else {
                    // For non-text nodes (e.g., existing <a>), just append them back
                    element.appendChild(node);
                }
            });
        }

        //ex script
        // function to convert timestamp into "time ago"
        function timeAgo(dateString) {
            if (!dateString) {
                return 'Waktu tidak diketahui';
            }

            const time = new Date(dateString).getTime();
            if (Number.isNaN(time)) {
                return 'Waktu tidak diketahui';
            }

            const now = Date.now();
            const diff = Math.floor((now - time) / 1000);

            if (diff < 60) return `${diff} detik lalu`;
            if (diff < 3600) return `${Math.floor(diff / 60)} menit lalu`;
            if (diff < 86400) return `${Math.floor(diff / 3600)} jam lalu`;
            if (diff < 604800) return `${Math.floor(diff / 86400)} hari lalu`;
            if (diff < 2592000) return `${Math.floor(diff / 604800)} minggu lalu`;
            if (diff < 31536000) return `${Math.floor(diff / 2592000)} bulan lalu`;
            return `${Math.floor(diff / 31536000)} tahun lalu`;
        }

        // function to update all timestamps
        function updateTimestamps() {
            document.querySelectorAll('.timestamp').forEach(el => {
                const original = el.getAttribute('data-time');
                const author = el.getAttribute('data-author') || 'Administrator';
                el.textContent = `Diterbitkan: ${timeAgo(original)} oleh ${author}`;
            });
        }
    </script>
</body>
</html>