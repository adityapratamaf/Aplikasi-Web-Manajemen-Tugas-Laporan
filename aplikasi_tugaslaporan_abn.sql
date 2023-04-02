-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jul 2022 pada 15.17
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasi_tugaslaporan_abn`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(3) NOT NULL,
  `id_tugas` int(3) NOT NULL,
  `nama_tugas` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `status_laporan` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `id_tugas`, `nama_tugas`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`, `waktu_mulai`, `waktu_selesai`, `status_laporan`) VALUES
(1, 0, 'Kusen & Pintur K. Ti', 'Ukuran Daun Pintu Tidak Sesuai Dengan Kusen', '2022-06-01', '2022-06-02', '17:40:42', '24:59:30', 2),
(2, 0, 'Pagar Proyek', 'Pemasangan Pagar Proyek Sesuai SOP', '2022-06-02', '2022-06-03', '12:59:36', '12:59:39', 1),
(3, 0, 'Kolom Praktis K2', 'Pembuatan Kolom Praktis K2', '2022-06-08', '2022-06-08', '13:01:34', '13:01:31', 1),
(4, 0, 'Stik Kolom', 'Pembuatan Stik Kolom', '2022-06-02', '2022-06-10', '13:02:32', '13:01:30', 2),
(5, 0, 'Penyediaan Air Kerja', 'Air Untuk Kebutuhan Pekerjaan', '2022-06-08', '2022-06-22', '13:02:55', '13:02:55', 1),
(6, 0, 'Pengukuran', 'Pengukuran Pondasi Setempat', '2022-06-23', '2022-06-30', '13:02:55', '13:06:56', 1),
(7, 0, 'Bouwplank', 'Pemasangan Bouwplank Pondasi Setempat', '2022-06-08', '2022-06-22', '13:02:55', '13:01:31', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id_pekerjaan` int(3) NOT NULL,
  `id_pengguna` int(3) NOT NULL,
  `id_tugas` int(3) NOT NULL,
  `id_laporan` int(3) NOT NULL,
  `nama_pekerjaan` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `klien` varchar(20) NOT NULL,
  `harga` varchar(30) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_pekerjaan` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pekerjaan`
--

INSERT INTO `pekerjaan` (`id_pekerjaan`, `id_pengguna`, `id_tugas`, `id_laporan`, `nama_pekerjaan`, `deskripsi`, `klien`, `harga`, `tanggal_mulai`, `tanggal_selesai`, `status_pekerjaan`) VALUES
(1, 0, 0, 0, 'Pembangunan Rumah', '', 'Aditya Pratama', '800000000', '2022-06-22', '2022-09-30', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(3) NOT NULL,
  `nama_depan` varchar(10) NOT NULL,
  `nama_belakang` varchar(10) NOT NULL,
  `jabatan` tinyint(3) NOT NULL,
  `email` varchar(10) NOT NULL,
  `password` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_depan`, `nama_belakang`, `jabatan`, `email`, `password`, `foto`) VALUES
(1, 'admin', ' ', 1, 'admin@abn.', 'admin', ''),
(3, 'manajer', '1', 2, 'manajer1@a', 'admin', ''),
(5, 'karyawan', '1', 3, 'karyawan1@', 'admin', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int(3) NOT NULL,
  `nama_tugas` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_tugas` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id_tugas`, `nama_tugas`, `deskripsi`, `status_tugas`) VALUES
(1, 'Stik Kolom', '20/40', 1),
(2, 'Plafon', 'gipsum', 1),
(3, 'Penyediaan Air Kerja', 'penyediaan air untuk kebutuhan pekerjaan', 1),
(4, 'Pengukuran', 'pengukuran pondasi setempat', 1),
(5, 'Pagar Proyek', 'pemasangan pagar proyek pada sekitar pada area setempat', 1),
(6, 'Kusen & Pintur K. Ti', 'pintu satu daun', 1),
(7, 'Kusen & Pintu Belaka', 'pintu jalusi kayu', 1),
(8, 'Kolom Praktis K2', '15/15 M3', 1),
(9, 'Bouwplank', 'pemasangan bouwplank pada pondasi setempat', 1),
(10, 'Bata Dinding', '1:4 M3', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`,`id_laporan`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `id_pekerjaan` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
