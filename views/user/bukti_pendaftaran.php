<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userName = $_SESSION['user_name'] ?? 'Guest';
$validasiData = [];

if (isset($getValidasi) && is_array($getValidasi)) {
    $validasiData = $getValidasi;
}

$hasValidasi = !empty($validasiData);
$hasilValidasi = $validasiData['hasil'] ?? '';
$hasilLabel = $hasilValidasi !== '' ? ucfirst($hasilValidasi) : 'Belum Diverifikasi';
$nomorPendaftaran = $validasiData['id_validasi'] ?? $validasiData['id_biodata'] ?? '-';
$terbitTanggal = $validasiData['waktu_terbit'] ?? date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Surat Bukti Pendaftaran</title>
  <style>
    @page {
      size: A4;
      margin: 2.5cm 2cm 2.5cm 2cm;
    }

    body {
      font-family: "Times New Roman", serif;
      background: #ccc; /* light gray background like print preview */
      margin: 0;
      color: #000;
      font-size: 14px;
    }

    .page {
      width: 210mm;
      min-height: 297mm;
      padding: 30px 40px;
      margin: 20px auto;
      background: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      box-sizing: border-box;
      position: relative;
    }

    .header {
      text-align: center;
      line-height: 1.5;
      margin-bottom: 15px;
      color: #34a326;
    }

    .logo {
      width: 100px;
      position: absolute;
      top: 40px;
      left: 60px;
    }

    .school-name {
      font-weight: bold;
      font-size: 18px;
    }

    .sub-name {
      font-size: 16px;
      font-weight: bold;
    }

    .info {
      font-size: 13px;
      margin-top: 4px;
    }

    .address {
      background-color: #34a326;
      color: #e2e61a;
      padding: 4px 0;
    }

    hr {
      border: 1px solid #000;
      margin-top: 10px;
      margin-bottom: 10px;
    }

    .title {
      text-align: center;
      font-weight: bold;
      margin-top: 20px;
      text-decoration: underline;
      font-size: 16px;
    }

    .content {
      margin-top: 30px;
      font-size: 14px;
      width: 85%;
      margin-left: auto;
      margin-right: auto;
    }

    .content table {
      width: 100%;
      border-collapse: collapse;
    }

    .content td {
      vertical-align: top;
      padding: 3px 0;
    }

    .note {
      font-size: 13px;
      margin-top: 20px;
      text-align: justify;
      line-height: 1.5;
    }

    .signature {
      margin-top: 60px;
      width: 85%;
      margin-left: auto;
      margin-right: auto;
      text-align: right;
    }

    .signature img {
      width: 160px;
      height: auto;
      margin-top: 10px;
    }

    .signature strong {
      display: block;
      margin-top: 4px;
    }

    .empty-state {
      text-align: center;
      padding: 120px 40px;
      font-size: 16px;
      color: #555;
    }

    @media print {
      body {
        margin: 0;
        box-shadow: none;
        background: #fff;
      }
      .page {
        margin: 0;
        box-shadow: none;
      }
    }
  </style>
</head>
<body>

  <div class="page">
    <img src="../../assets/images/logo.svg" alt="Logo" class="logo">

    <div class="header">
      <div class="school-name">YAYASAN MIFTAHUL’ ULUM AL-MUNAWWAROH</div>
      <div class="sub-name">MADRASAH IBTIDAIYAH MIFTAHUL’ ULUM</div>
      <div class="info">
        NSM: 111221710002 &nbsp;&nbsp;&nbsp; NPSN: 60706103<br>
        TERAKREDITASI A<br>
        NOMOR: 1339/BAN-SM/SK/2019<br>
        <div class="address">
        Alamat: Bengkong Harapan II Blok L RT 002 RW 007 Kel. Bengkong Indah Kec. Bengkong<br>
        No. Telp: 0778-450042 &nbsp; E-mail: miftahululum_9988@yahoo.co.id
        </div>
      </div>
      <hr>
    </div>

    <div class="title">SURAT BUKTI PENDAFTARAN</div>

    <?php if (!$hasValidasi): ?>
      <div class="empty-state">
        Data validasi tidak ditemukan. Silakan kembali ke halaman hasil validasi untuk mencetak ulang.
      </div>
    <?php else: ?>
      <div class="content">
        <table>
          <tr><td width="40%">No. Pendaftaran</td><td>: <?= htmlspecialchars($nomorPendaftaran) ?></td></tr>
          <tr><td>Nama Calon Siswa</td><td>: <?= htmlspecialchars($validasiData['nama_murid']) ?></td></tr>
          <tr><td>Umur</td><td>: <?= htmlspecialchars($validasiData['umur_murid']) ?> Tahun</td></tr>
          <tr><td>Jenis Kelamin</td><td>: <?= htmlspecialchars($validasiData['jenis_kelamin']) ?></td></tr>
          <tr><td>Asal TK</td><td>: <?= htmlspecialchars($validasiData['asal_tk']) ?></td></tr>
          <tr><td>Nama Ayah</td><td>: <?= htmlspecialchars($validasiData['nama_ayah']) ?></td></tr>
          <tr><td>Nama Ibu</td><td>: <?= htmlspecialchars($validasiData['nama_ibu']) ?></td></tr>
          <tr><td>Status Verifikasi</td><td>: <?= htmlspecialchars($hasilLabel) ?></td></tr>
        </table>

        <div class="note">
          <strong>Catatan:</strong> Setelah mendapatkan bukti pendaftaran, diharapkan untuk segera membayar biaya pendaftaran sebesar Rp100.000, dengan cara transfer uang ke 
          <strong>Bank BNI 0245337166 a.n. Miftahul Ulum.</strong> Lalu bergabung ke grup Whatsapp dengan meng-klik link yang diberikan pada dashboard pengumuman.
        </div>
      </div>
    <?php endif; ?>

    <div class="signature">
      <p>Batam, <?= htmlspecialchars(date('d F Y', strtotime($terbitTanggal))) ?><br>Ketua Panitia PPDB 2024</p>
      <img src="../../assets/images/Pak Inten Signature.svg" alt="Tanda Tangan">
      <strong>Inten Hasannudin, S.Pd.I</strong>
    </div>
  </div>

</body>
</html>
