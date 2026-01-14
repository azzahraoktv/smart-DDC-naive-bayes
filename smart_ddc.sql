-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jan 12, 2026 at 11:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_ddc`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_training`
--

CREATE TABLE `data_training` (
  `id` int(11) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_pengujian`
--

CREATE TABLE `hasil_pengujian` (
  `id` int(11) NOT NULL,
  `tgl_uji` timestamp NOT NULL DEFAULT current_timestamp(),
  `jumlah_data_latih` int(11) NOT NULL,
  `jumlah_data_uji` int(11) NOT NULL,
  `akurasi` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_ddc`
--

CREATE TABLE `kategori_ddc` (
  `id` int(11) NOT NULL,
  `kode_ddc` varchar(20) NOT NULL,
  `nama_kategori` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_naive_bayes`
--

CREATE TABLE `model_naive_bayes` (
  `id` int(11) NOT NULL,
  `tgl_training` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_dokumen` int(11) NOT NULL,
  `total_kategori` int(11) NOT NULL,
  `model_data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_klasifikasi`
--

CREATE TABLE `riwayat_klasifikasi` (
  `id` int(11) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `kategori_hasil` int(11) NOT NULL,
  `confidence` decimal(5,2) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','pustakawan') DEFAULT 'pustakawan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(1, 'admin', 'admin123', 'Pustakawan', 'pustakawan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_training`
--
ALTER TABLE `data_training`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kategori` (`kategori_id`);
ALTER TABLE `data_training` ADD FULLTEXT KEY `idx_search` (`judul_buku`,`deskripsi`);

--
-- Indexes for table `hasil_pengujian`
--
ALTER TABLE `hasil_pengujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tgl` (`tgl_uji`);

--
-- Indexes for table `kategori_ddc`
--
ALTER TABLE `kategori_ddc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_ddc` (`kode_ddc`),
  ADD KEY `idx_kode` (`kode_ddc`);

--
-- Indexes for table `model_naive_bayes`
--
ALTER TABLE `model_naive_bayes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tgl` (`tgl_training`);

--
-- Indexes for table `riwayat_klasifikasi`
--
ALTER TABLE `riwayat_klasifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_waktu` (`waktu`),
  ADD KEY `idx_kategori` (`kategori_hasil`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_training`
--
ALTER TABLE `data_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil_pengujian`
--
ALTER TABLE `hasil_pengujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_ddc`
--
ALTER TABLE `kategori_ddc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `model_naive_bayes`
--
ALTER TABLE `model_naive_bayes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_klasifikasi`
--
ALTER TABLE `riwayat_klasifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_training`
--
ALTER TABLE `data_training`
  ADD CONSTRAINT `data_training_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_ddc` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `riwayat_klasifikasi`
--
ALTER TABLE `riwayat_klasifikasi`
  ADD CONSTRAINT `riwayat_klasifikasi_ibfk_1` FOREIGN KEY (`kategori_hasil`) REFERENCES `kategori_ddc` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
