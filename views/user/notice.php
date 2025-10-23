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
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap & icon CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
        }

        h2 {
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .announcement-card {
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            margin-bottom: 1.5rem;
        }
        .announcement-card:hover {
            transform: translateY(-4px);
        }
        .timestamp {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .attachment {
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(to bottom right, #4caf50, #2e7d32);
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

        .no-border {
            border-top: none;
            border-left: none;
            border-right: none;
        }

        footer {
            background-color: #f2d0a4;
            padding: 1rem;
            text-align: center;
            font-size: 0.9rem;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/sidebar/user-sidebar.php'; ?>

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
                    <a href="/mifahul_ulum/controllers/user/user_logout_handler.php" class="btn btn-outline-danger btn-sm">
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

    <?php require_once __DIR__ . '/../partials/footer/user_footer.php'; ?>

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