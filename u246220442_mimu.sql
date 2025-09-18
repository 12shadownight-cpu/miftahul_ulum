-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 13 Jul 2025 pada 12.51
-- Versi server: 10.11.10-MariaDB-log
-- Versi PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u246220442_mimu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `biodata_murid`
--

CREATE TABLE `biodata_murid` (
  `id_biodata` int(15) NOT NULL,
  `id_user` int(15) NOT NULL,
  `nama_murid` varchar(255) NOT NULL,
  `umur_murid` int(255) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `asal_tk` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `no_kk` varchar(16) NOT NULL,
  `file_akta` varchar(255) NOT NULL,
  `file_kk` varchar(255) NOT NULL,
  `file_ijazah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `biodata_orangtua`
--

CREATE TABLE `biodata_orangtua` (
  `id_orangtua` int(15) NOT NULL,
  `id_user` int(15) NOT NULL,
  `nama_ayah` varchar(255) NOT NULL,
  `tempat_lahir_ayah` varchar(255) NOT NULL,
  `tanggal_lahir_ayah` date NOT NULL,
  `pekerjaan_ayah` varchar(255) NOT NULL,
  `hp_ayah` varchar(15) NOT NULL,
  `nik_ayah` varchar(16) NOT NULL,
  `kk_ayah` varchar(16) NOT NULL,
  `file_ktp_ayah` varchar(255) NOT NULL,
  `nama_ibu` varchar(255) NOT NULL,
  `tempat_lahir_ibu` varchar(255) NOT NULL,
  `tanggal_lahir_ibu` date NOT NULL,
  `pekerjaan_ibu` varchar(255) NOT NULL,
  `hp_ibu` varchar(15) NOT NULL,
  `nik_ibu` varchar(16) NOT NULL,
  `kk_ibu` varchar(16) NOT NULL,
  `file_ktp_ibu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pengurus`
--

CREATE TABLE `data_pengurus` (
  `id_pengurus` int(15) NOT NULL,
  `nama_pengurus` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `status` enum('admin','sekretaris') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_user`
--

CREATE TABLE `data_user` (
  `id_user` int(15) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(15) NOT NULL,
  `id_pengurus` int(15) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `file_pendukung` varchar(255) NOT NULL,
  `waktu_terbit` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `validasi_data`
--

CREATE TABLE `validasi_data` (
  `id_validasi` int(15) NOT NULL,
  `id_user` int(15) NOT NULL,
  `id_biodata` int(15) NOT NULL,
  `id_orangtua` int(15) NOT NULL,
  `hasil` enum('diterima','ditolak') NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `biodata_murid`
--
ALTER TABLE `biodata_murid`
  ADD PRIMARY KEY (`id_biodata`),
  ADD KEY `biodata_user` (`id_user`);

--
-- Indeks untuk tabel `biodata_orangtua`
--
ALTER TABLE `biodata_orangtua`
  ADD PRIMARY KEY (`id_orangtua`),
  ADD KEY `orangtua_user` (`id_user`);

--
-- Indeks untuk tabel `data_pengurus`
--
ALTER TABLE `data_pengurus`
  ADD PRIMARY KEY (`id_pengurus`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `notice_pengurus` (`id_pengurus`);

--
-- Indeks untuk tabel `validasi_data`
--
ALTER TABLE `validasi_data`
  ADD PRIMARY KEY (`id_validasi`),
  ADD KEY `validasi_user` (`id_user`),
  ADD KEY `validasi_biodata` (`id_biodata`),
  ADD KEY `validasi_orangtua` (`id_orangtua`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `biodata_murid`
--
ALTER TABLE `biodata_murid`
  MODIFY `id_biodata` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `biodata_orangtua`
--
ALTER TABLE `biodata_orangtua`
  MODIFY `id_orangtua` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_pengurus`
--
ALTER TABLE `data_pengurus`
  MODIFY `id_pengurus` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id_user` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `validasi_data`
--
ALTER TABLE `validasi_data`
  MODIFY `id_validasi` int(15) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `biodata_murid`
--
ALTER TABLE `biodata_murid`
  ADD CONSTRAINT `biodata_user` FOREIGN KEY (`id_user`) REFERENCES `data_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `biodata_orangtua`
--
ALTER TABLE `biodata_orangtua`
  ADD CONSTRAINT `orangtua_user` FOREIGN KEY (`id_user`) REFERENCES `data_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `notice_pengurus` FOREIGN KEY (`id_pengurus`) REFERENCES `data_pengurus` (`id_pengurus`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `validasi_data`
--
ALTER TABLE `validasi_data`
  ADD CONSTRAINT `validasi_biodata` FOREIGN KEY (`id_biodata`) REFERENCES `biodata_murid` (`id_biodata`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `validasi_orangtua` FOREIGN KEY (`id_orangtua`) REFERENCES `biodata_orangtua` (`id_orangtua`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `validasi_user` FOREIGN KEY (`id_user`) REFERENCES `data_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
