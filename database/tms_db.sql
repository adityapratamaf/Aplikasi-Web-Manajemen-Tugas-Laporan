-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jun 2022 pada 08.08
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
-- Database: `tms_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `project_list`
--

CREATE TABLE `project_list` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `client` text NOT NULL,
  `price` decimal(11,0) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `manager_id` int(30) NOT NULL,
  `user_ids` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `project_list`
--

INSERT INTO `project_list` (`id`, `name`, `description`, `client`, `price`, `status`, `start_date`, `end_date`, `manager_id`, `user_ids`, `date_created`) VALUES
(5, 'Pembangunan Rumah', '																																																																																																																																																																																																						', 'Aditya Pratama', '800000000', 0, '2022-06-22', '2022-09-30', 7, '6', '2022-06-05 22:43:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Task Management System', 'info@sample.comm', '+6948 8542 623', '2102  Caldwell Road, Rochester, New York, 14608', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_list`
--

CREATE TABLE `task_list` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `task_list`
--

INSERT INTO `task_list` (`id`, `project_id`, `task`, `description`, `status`, `date_created`) VALUES
(31, 5, 'Pengukuran ', '				pengukuran pondasi setempat			', 3, '2022-06-22 19:32:19'),
(32, 5, 'Bouwplank', '				pemasangan bouwplank pada pondasi setempat			', 3, '2022-06-22 19:32:54'),
(33, 5, 'Penyediaan Air Kerja', '								penyediaan air untuk kebutuhan pekerjaan pada area setempat						', 3, '2022-06-22 19:33:43'),
(35, 5, 'Pagar Proyek', '								&lt;p&gt;pemasangan pagar proyek pada sekitar pada area setempat&lt;/p&gt;						', 3, '2022-06-22 19:35:30'),
(40, 5, 'Stik Kolom', '								20/40						', 4, '2022-06-22 19:39:10'),
(43, 5, 'Kolom Praktis K2', '																&lt;p&gt;15/15 M3&lt;/p&gt;												', 3, '2022-06-22 19:40:54'),
(46, 5, 'Bata Dinding ', '1:4 M3', 1, '2022-06-22 19:44:12'),
(49, 5, 'Kusen & Pintu Belakang', 'pintu jalusi kayu', 1, '2022-06-22 19:46:54'),
(50, 5, 'Kusen & Pintur K. Tidur', '				pintu satu daun			', 4, '2022-06-22 19:47:23'),
(67, 5, 'Plafon', 'gipsum', 1, '2022-06-22 19:55:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = admin, 2 = staff',
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `avatar`, `date_created`) VALUES
(1, 'Administrator', '  ', 'admin@abn.com', '21232f297a57a5a743894a0e4a801fc3', 1, '1655900880_icons8-admin-settings-male-96.png', '2020-11-26 10:57:04'),
(6, 'Karyawan', '1', 'karyawan1@abn.com', '21232f297a57a5a743894a0e4a801fc3', 3, '1655900940_icons8-user-skin-type-7-96.png', '2022-06-05 21:22:14'),
(7, 'Manajer', '1', 'manajer1@abn.com', '21232f297a57a5a743894a0e4a801fc3', 2, '1655900940_icons8-manager-96.png', '2022-06-05 21:24:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_productivity`
--

CREATE TABLE `user_productivity` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `subject` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `date_end` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `user_id` int(30) NOT NULL,
  `time_rendered` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_productivity`
--

INSERT INTO `user_productivity` (`id`, `project_id`, `task_id`, `comment`, `subject`, `date`, `date_end`, `start_time`, `end_time`, `user_id`, `time_rendered`, `date_created`) VALUES
(27, 5, 32, 'pemasangan bouwplank pondasi setempat', '3', '2022-06-23', '2022-06-23', '09:30:00', '14:00:00', 1, 4.5, '2022-06-22 20:33:58'),
(28, 5, 31, 'pengukuran pondasi setempat', '3', '2022-06-22', '2022-06-22', '20:41:00', '02:47:00', 1, -17.9, '2022-06-22 20:41:14'),
(30, 5, 33, 'air untuk kebutuhan pekerjaan', '3', '2022-06-23', '2022-06-23', '08:45:00', '08:50:00', 1, 0.0833333, '2022-06-23 09:45:45'),
(31, 5, 40, '							pembuatan stik kolom', '4', '2022-06-27', '2022-06-29', '09:48:00', '15:54:00', 1, 6.1, '2022-06-23 09:48:17'),
(32, 5, 43, '							pembuatan kolom praktis k2', '3', '2022-06-27', '2022-06-30', '10:29:00', '16:35:00', 1, 6.1, '2022-06-23 10:29:59'),
(33, 5, 35, 'pemasangan pagar proyek sesuai SOP', '3', '2022-06-27', '2022-06-25', '11:31:00', '16:37:00', 1, 5.1, '2022-06-23 10:31:04'),
(34, 5, 50, 'ukuran daun pintu tidak sesuai dengan kusen', '4', '2022-07-01', '2022-07-01', '11:33:00', '12:34:00', 1, 1.01667, '2022-06-23 10:32:18');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_productivity`
--
ALTER TABLE `user_productivity`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `task_list`
--
ALTER TABLE `task_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user_productivity`
--
ALTER TABLE `user_productivity`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
