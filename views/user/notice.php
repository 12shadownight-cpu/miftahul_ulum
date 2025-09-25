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



    <!-- example: <p>Published: <?= timeAgo($row['waktu_terbit']) ?></p> -->
    <?php include '../partials/footer/user_footer.php'; ?>
</body>
</html>