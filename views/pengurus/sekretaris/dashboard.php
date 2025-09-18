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

// Ensure $counts is valid
if (!is_array($counts)) {
    $counts = ['diterima' => 0, 'ditolak' => 0];
} else {
    $counts = array_merge(['diterima' => 0, 'ditolak' => 0], $counts);
}

// Check if all values are 0
$allZero = ($counts['diterima'] == 0 && $counts['ditolak'] == 0);

// Ensure $totals is valid
if (!is_array($totals)) {
    $totals = ['laki-laki' => 0, 'perempuan' => 0];
} else {
    $totals = array_merge(['laki-laki' => 0, 'perempuan' => 0], $totals);
}

// Check if all values are 0
$allVoid = ($totals['laki-laki'] == 0 && $totals['perempuan'] == 0);
?>
<!DOCTYPE html>
<html>
<?php include '../../partials/header/sekretaris_header.php'; ?>
<body>
    <?php include '../../partials/sidebar/sekretaris-sidebar.php'; ?>



    <?php include '../../partials/footer/pengurus_footer.php'; ?>
    <script>
        const counts = <?= json_encode($counts) ?>;
        const allZero = <?= $allZero ? 'true' : 'false' ?>;

        new Chart(document.getElementById('validasiChart'), {
            type: 'pie',
            data: {
                labels: ['Diterima', 'Ditolak'],
                datasets: [{
                    label: 'Hasil Validasi',
                    data: [counts.diterima, counts.ditolak],
                    backgroundColor: allZero ? ['#FFFFFF', '#FFFFFF'] : ['#36A2EB', '#FF6384'],
                    borderColor: '#ccc'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        const totals = <?= json_encode($totals) ?>;
        const allVoid = <?= $allVoid ? 'true' : 'false' ?>;
        
        new Chart(document.getElementById('muridChart'), {
            type: 'pie',
            data: {
                labels: ['Laki-Laki', 'Perempuan'],
                datasets: [{
                    label: 'Jenis Kelamin',
                    data: [counts.laki-laki, counts.perempuan],
                    backgroundColor: allZero ? ['#FFFFFF', '#FFFFFF'] : ['#54EF36FF', '#F5FF63FF'],
                    borderColor: '#ccc'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>
</body>
</html>