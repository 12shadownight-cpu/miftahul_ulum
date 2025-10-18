<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userName = $_SESSION['user_name'] ?? 'Guest';

//Convert timestamp
function timeAgo($datetime) {
    $time = strtotime($datetime);
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
    } else {
        return floor($diff / 31536000) . ' tahun lalu'; 
    }
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
            <!-- Announcement list (static HTML instead of JS injection) -->
            <div id="announcement-list">
                <!-- Announcement list -->
                <?php foreach ($announcement as $row): ?>
                    <div class="card announcement-card" id="announcement<?= $row['id_pengumuman'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($row['deskripsi']) ?></p>
                            <?php if (!empty($row['file_url'])): ?>
                                <p class="attachment">
                                    <i class="bi bi-paperclip"></i>
                                    <a href="<?= htmlspecialchars($row['file_url']) ?>" target="_blank" rel="noopener noreferrer">
                                        <?= htmlspecialchars($row['nama_file']) ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            <p class="timestamp" data-time="<?= htmlspecialchars($row['waktu_terbit']) ?>">Published: <?= timeAgo($row['waktu_terbit']) ?> By <?= htmlspecialchars($row['nama_pengurus']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
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
            const announcements = document.querySelectorAll(".announcement-card .card-body");

            announcements.forEach((card, index) => {
                const title = card.querySelector(".card-title").innerText;
                const text = card.querySelector(".card-text") ? card.querySelector(".card-text").innerText : "";
                const pageUrl = window.location.href.split("#")[0] + "#announcement" + (index+1);

                // Encode text for sharing
                const shareText = encodeURIComponent(title + " - " + text + " " + pageUrl);
                const shareUrl = encodeURIComponent(pageUrl);

                // Create share buttons
                const btnWrapper = document.createElement("div");
                btnWrapper.classList.add("mt-3");

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
        });

        //2nd script
        //Automatic card-text URL detection
        function linkifySafe(element) {
            const urlPattern = /(https?:\/\/[^\s]+)/g;
            // Work with child nodes instead of textContent, so <a> stays untouched
            const nodes = Array.from(element.childNodes);
            element.textContent = ""; // clear container

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

        // Apply to all .card-text elements
        document.querySelectorAll(".card-text").forEach(el => {
        linkifySafe(el);
        });

        //ex script
        // function to convert timestamp into "time ago"
        function timeAgo(dateString) {
            const time = new Date(dateString).getTime(); // convert to timestamp
            const now = Date.now(); // current time
            const diff = Math.floor((now - time) / 1000); // difference in seconds

            if (diff < 60) return `${diff} seconds ago`;
            if (diff < 3600) return `${Math.floor(diff / 60)} minutes ago`;
            if (diff < 86400) return `${Math.floor(diff / 3600)} hours ago`;
            if (diff < 604800) return `${Math.floor(diff / 86400)} days ago`;
            if (diff < 2592000) return `${Math.floor(diff / 604800)} weeks ago`;
            if (diff < 31536000) return `${Math.floor(diff / 2592000)} months ago`;
            return `${Math.floor(diff / 31536000)} years ago`;
        }

        // function to update all timestamps
        function updateTimestamps() {
            document.querySelectorAll(".timestamp").forEach(el => {
                const original = el.getAttribute("data-time"); // read original time
                el.textContent = "Published: " + timeAgo(original);
            });
        }

        // save original timestamp into data attribute
        document.querySelectorAll(".timestamp").forEach(el => {
            const text = el.textContent.replace("Published:", "").trim();
            el.setAttribute("data-time", text);
        });

        // first run
        updateTimestamps();

        // auto-refresh every 60 seconds
        setInterval(updateTimestamps, 30000);
    </script>
</body>
</html>