-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jan 22, 2026 at 08:29 PM
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

--
-- Dumping data for table `data_training`
--

INSERT INTO `data_training` (`id`, `judul_buku`, `deskripsi`, `kategori_id`, `created_at`) VALUES
(1, 'Switch & Multilayer Switch Cisco', 'Switch & Multilayer Switch Cisco', 6, '2026-01-22 19:11:05'),
(2, 'Belajar Jaringan Komputer Berbasis Mikrotik Os', 'Belajar Jaringan Komputer Berbasis Mikrotik Os', 6, '2026-01-22 19:11:06'),
(3, 'Home Networking Membuat Jaringan Komputer untuk Rumah dan Kantor Berskala Kecil', 'Home networking membuat jaringan komputer untuk rumah dan kantor berskala kecil', 6, '2026-01-22 19:11:06'),
(4, 'Pedoman Panduan Praktikum Pengantar Jaringan', 'Pedoman Panduan Praktikum Pengantar Jaringan', 6, '2026-01-22 19:11:06'),
(5, 'Special Workshop Pembuatan Situs Berita dengan Asp.net 2.0', 'Special Workshop Pembuatan Situs Berita dengan ASP.NET 2.0', 6, '2026-01-22 19:11:06'),
(6, 'Internet-tcp/ip Konsep & Implementasi', 'Internet-TCP/IP konsep & Implementasi', 7, '2026-01-22 19:11:06'),
(7, 'Dasar Pemrograman Internet untuk Proyek Berbasis Arduino', 'Dasar Pemrograman Internet untuk Proyek Berbasis Arduino', 7, '2026-01-22 19:11:06'),
(8, 'Membangun Toko Online dengan Joomla dan Virtue Mart', 'Membangun Toko online dengan Joomla dan Virtue Mart ', 7, '2026-01-22 19:11:06'),
(9, 'Mudah Menggunakan Internet untuk Pemula', 'Mudah Menggunakan Internet Untuk Pemula ', 7, '2026-01-22 19:11:06'),
(10, 'Google Sketch Up : Mudah dan Cepat Menggambar 3dimensi', 'Google Sketch Up : Mudah  dan Cepat Menggambar 3Dimensi', 7, '2026-01-22 19:11:06'),
(11, 'Panduan Praktis Membangun Mail Server Handal & Gratis Hingga Online', 'Panduan Praktis Membangun Mail Server Handal & Gratis Hingga Online', 7, '2026-01-22 19:11:06'),
(12, 'Advances In Mobile Cloud Computing Systems', 'Advances in Mobile Cloud Computing Systems', 7, '2026-01-22 19:11:06'),
(13, '30 Produk Google untuk Oprasional Blog', '30 Produk Google untuk Oprasional Blog', 7, '2026-01-22 19:11:06'),
(14, 'Membuat Blog dengan Blogger untuk Pemula', 'Membuat Blog dengan Blogger untuk Pemula', 7, '2026-01-22 19:11:06'),
(15, '3 Langkah Membuat Website', '3 Langkah Membuat Website', 7, '2026-01-22 19:11:06'),
(16, 'Pedoman Panduan Praktikum Merawat dan Merakit Komputer', 'Pedoman Panduan Praktikum Merawat Dan Merakit Komputer', 7, '2026-01-22 19:11:06'),
(17, 'Pedoman Panduan Praktikum Merawat dan Merakit Komputer', 'Pedoman Panduan Praktikum Merawat Dan Merakit Komputer', 7, '2026-01-22 19:11:06'),
(18, 'Pedoman Pamduan Praktikum Merawat dan Merakit Komputer', 'Pedoman Pamduan Praktikum Merawat Dan Merakit Komputer', 7, '2026-01-22 19:11:06'),
(19, 'Teknologi Jaringan Internet : Teori dan Pemahaman', 'Teknologi Jaringan Internet : Teori Dan Pemahaman ', 7, '2026-01-22 19:11:06'),
(20, 'Pedoman Panduan Pratikum Merawat dan Merakit Komputer', 'Pedoman Panduan Pratikum Merawat dan Merakit Komputer ', 7, '2026-01-22 19:11:06'),
(21, 'Nongkrong Asyik Diinternet dengan Facebook', 'Nongkrong Asyik Diinternet Dengan Facebook ', 7, '2026-01-22 19:11:06'),
(22, 'Tutorial Membuat Objek dengan 3ds Max', 'Tutorial membuat objek dengan 3ds max', 8, '2026-01-22 19:11:06'),
(23, 'Pengantar Logika Informatika, Algoritma, dan Pemrograman Komputer', 'Pengantar Logika Informatika, Algoritma, dan Pemrograman Komputer', 9, '2026-01-22 19:11:06'),
(24, 'Algoritma Pemrograman', 'Algoritma Pemrograman', 9, '2026-01-22 19:11:06'),
(25, 'Teknik Mudah dan Cepat Melakukan Analisis Data Penelitian dengan Sppss', 'Teknik Mudah Dan Cepat Melakukan Analisis Data Penelitian Dengan Sppss', 9, '2026-01-22 19:11:06'),
(26, 'Rekayasa Perangkat Lunak Berorientasi Objek Mengguanakan Php', 'Rekayasa perangkat lunak Berorientasi Objek Mengguanakan PHP', 9, '2026-01-22 19:11:06'),
(27, 'Tips dan Trik Microsoft Powerpoint', 'Tips Dan Trik Microsoft Powerpoint', 9, '2026-01-22 19:11:06'),
(28, 'Aplikasi Smart Report', 'Aplikasi Smart Report ', 9, '2026-01-22 19:11:06'),
(29, 'Belajar Sendiri Pasti Bisa Pemograman C', 'Belajar Sendiri Pasti bisa Pemograman C', 9, '2026-01-22 19:11:06'),
(30, 'Mengolah Database Excel untuk Pemula', 'Mengolah Database Excel untuk Pemula', 9, '2026-01-22 19:11:06'),
(31, 'Jaringan Wireless untuk Orang Awam', 'Jaringan Wireless untuk orang awam ', 9, '2026-01-22 19:11:06'),
(32, 'Mengolah Database dengan Microsoft Excel untuk Pemula', 'Mengolah Database Dengan Microsoft Excel Untuk Pemula', 9, '2026-01-22 19:11:06'),
(33, 'Teori dan Aplikasi Stuktur Data Menggunakan C++', 'Teori dan aplikasi Stuktur Data menggunakan C++', 10, '2026-01-22 19:11:06'),
(34, 'Dasar Pengolahan Citra dengan Delphi', 'Dasar pengolahan Citra dengan Delphi', 10, '2026-01-22 19:11:06'),
(35, 'Teori dan Aplikasi Struktur Data Mengunakan C++', 'Teori Dan Aplikasi Struktur Data Mengunakan C++', 10, '2026-01-22 19:11:06'),
(36, 'Pemrograman Berorientasi Objek Menggunakan Java', 'Pemrograman Berorientasi Objek Menggunakan Java', 11, '2026-01-22 19:11:06'),
(37, 'Menguasai Pemrograman Berorientasi Objek', 'Menguasai Pemrograman Berorientasi  Objek', 11, '2026-01-22 19:11:06'),
(38, 'Rekayasa Sistem Berorientasi Objek', 'Rekayasa sistem berorientasi objek', 11, '2026-01-22 19:11:06'),
(39, 'Dasar Analisis dan Perancangan Pemograman Berorientasi Objek Menggunakan Java', 'Dasar Analisis dan Perancangan Pemograman Berorientasi Objek menggunakan Java', 11, '2026-01-22 19:11:06'),
(40, 'Panduan Mudah Membuat Augmented Reality', 'Panduan Mudah Membuat Augmented Reality', 12, '2026-01-22 19:11:06'),
(41, 'Panduan Mudah Membuat Augmented Reality', 'Panduan Mudah Membuat Augmented Reality', 12, '2026-01-22 19:11:06'),
(42, 'Computer Vision dan Aplikasinya Menggunakan C# dan Emgucv', 'Computer Vision Dan Aplikasinya Menggunakan C# Dan EmguCV', 12, '2026-01-22 19:11:07'),
(43, 'Belajar Komputer Visual Basic', 'Belajar Komputer Visual Basic ', 12, '2026-01-22 19:11:07'),
(44, 'Belajar Komputer Visual Basic', 'Belajar Komputer Visual Basic ', 12, '2026-01-22 19:11:07'),
(45, 'Pemrograman Matlab 150 + Soal Penyelesaian', 'Pemrograman Matlab 150 + Soal Penyelesaian', 13, '2026-01-22 19:11:07'),
(46, 'Belajar Mudah Matlab Beserta Aplikasinya', 'Belajar Mudah Matlab beserta Aplikasinya ', 14, '2026-01-22 19:11:07'),
(47, 'Aplikasi Pemrograman Javascript untuk Halaman Web', 'Aplikasi Pemrograman JavaScript untuk halaman Web ', 14, '2026-01-22 19:11:07'),
(48, 'Mudah Belajar Ruby', 'Mudah belajar Ruby', 14, '2026-01-22 19:11:07'),
(49, 'Keterampilan Dasar Pengoperasian Komputer', 'Keterampilan Dasar Pengoperasian Komputer', 5, '2026-01-22 19:11:07'),
(50, 'Kamus Istilah Bisnis Online', 'Kamus Istilah Bisnis Online', 2, '2026-01-22 19:11:07'),
(51, 'Daftar Situs Bea Siswa Pendidikan Dunia', 'Daftar Situs Bea Siswa Pendidikan dunia ', 3, '2026-01-22 19:11:07'),
(52, 'Dasar Pemrograman 2', 'Dasar Pemrograman 2', 4, '2026-01-22 19:11:07'),
(53, 'Jaringan Komputer dengan Tcp/ip', 'Jaringan Komputer dengan TCP/IP', 5, '2026-01-22 19:11:07'),
(54, 'Trik dan Tip Jitu Windows 2003 Server', 'Trik Dan Tip Jitu Windows 2003 Server', 5, '2026-01-22 19:11:07'),
(55, 'Pengantar Jaringan Komputer Bagi Pemula', 'Pengantar Jaringan Komputer Bagi Pemula', 5, '2026-01-22 19:11:07'),
(56, 'Pengantar Jaringan Komputer Bagi Pemula', 'Pengantar Jaringan Komputer Bagi Pemula', 5, '2026-01-22 19:11:07'),
(57, 'Petunjuk Teoritis Pengantar Lan (local Area Network)', 'Petunjuk Teoritis Pengantar Lan (Local Area Network)', 5, '2026-01-22 19:11:07'),
(58, 'Petunjuk Teoritis Pengantar Lan (local Area Network)', 'Petunjuk Teoritis Pengantar Lan (Local Area Network)', 5, '2026-01-22 19:11:07'),
(59, 'Pengantar Jaringan Komputer Bagi Pemula', 'Pengantar Jaringan Komputer Bagi Pemula', 5, '2026-01-22 19:11:07'),
(60, 'Pengantar Jaringan Komputer Bagi Pemula', 'Pengantar Jaringan Komputer Bagi Pemula', 5, '2026-01-22 19:11:07'),
(61, 'Petunjuk Teoritis Pengantar Lan (local Area Network)', 'Petunjuk Teoritis Pengantar Lan (Local Area Network)', 5, '2026-01-22 19:11:07'),
(62, 'Kompresi Video', 'Kompresi video', 5, '2026-01-22 19:11:07'),
(63, 'Belajar Jaringan Komputer Berbasis Mikrotik Os', 'Belajar Jaringan Komputer Berbasis Mikrotik Os', 6, '2026-01-22 19:11:07'),
(64, 'Home Networking Membuat Jaringan Komputer untuk Rumah dan Kantor Berskala Kecil', 'Home networking membuat jaringan komputer untuk rumah dan kantor berskala kecil', 6, '2026-01-22 19:11:07'),
(65, 'Pedoman Panduan Praktikum Pengantar Jaringan', 'Pedoman Panduan Praktikum Pengantar Jaringan', 6, '2026-01-22 19:11:07'),
(66, 'Special Workshop Pembuatan Situs Berita dengan Asp.net 2.0', 'Special Workshop Pembuatan Situs Berita dengan ASP.NET 2.0', 6, '2026-01-22 19:11:07'),
(67, 'Internet-tcp/ip Konsep & Implementasi', 'Internet-TCP/IP konsep & Implementasi', 7, '2026-01-22 19:11:07'),
(68, 'Dasar Pemrograman Internet untuk Proyek Berbasis Arduino', 'Dasar Pemrograman Internet untuk Proyek Berbasis Arduino', 7, '2026-01-22 19:11:07'),
(69, 'Membangun Toko Online dengan Joomla dan Virtue Mart', 'Membangun Toko online dengan Joomla dan Virtue Mart ', 7, '2026-01-22 19:11:07'),
(70, 'Mudah Menggunakan Internet untuk Pemula', 'Mudah Menggunakan Internet Untuk Pemula ', 7, '2026-01-22 19:11:07'),
(71, 'Google Sketch Up : Mudah dan Cepat Menggambar 3dimensi', 'Google Sketch Up : Mudah  dan Cepat Menggambar 3Dimensi', 7, '2026-01-22 19:11:07'),
(72, 'Panduan Praktis Membangun Mail Server Handal & Gratis Hingga Online', 'Panduan Praktis Membangun Mail Server Handal & Gratis Hingga Online', 7, '2026-01-22 19:11:07'),
(73, 'Advances In Mobile Cloud Computing Systems', 'Advances in Mobile Cloud Computing Systems', 7, '2026-01-22 19:11:07'),
(74, '30 Produk Google untuk Oprasional Blog', '30 Produk Google untuk Oprasional Blog', 7, '2026-01-22 19:11:07'),
(75, 'Membuat Blog dengan Blogger untuk Pemula', 'Membuat Blog dengan Blogger untuk Pemula', 7, '2026-01-22 19:11:07'),
(76, '3 Langkah Membuat Website', '3 Langkah Membuat Website', 7, '2026-01-22 19:11:07'),
(77, 'Pedoman Panduan Praktikum Merawat dan Merakit Komputer', 'Pedoman Panduan Praktikum Merawat Dan Merakit Komputer', 7, '2026-01-22 19:11:07'),
(78, 'Pedoman Panduan Praktikum Merawat dan Merakit Komputer', 'Pedoman Panduan Praktikum Merawat Dan Merakit Komputer', 7, '2026-01-22 19:11:07'),
(79, 'Pedoman Pamduan Praktikum Merawat dan Merakit Komputer', 'Pedoman Pamduan Praktikum Merawat Dan Merakit Komputer', 7, '2026-01-22 19:11:07'),
(80, 'Teknologi Jaringan Internet : Teori dan Pemahaman', 'Teknologi Jaringan Internet : Teori Dan Pemahaman ', 7, '2026-01-22 19:11:07'),
(81, 'Pedoman Panduan Pratikum Merawat dan Merakit Komputer', 'Pedoman Panduan Pratikum Merawat dan Merakit Komputer ', 7, '2026-01-22 19:11:07'),
(82, 'Nongkrong Asyik Diinternet dengan Facebook', 'Nongkrong Asyik Diinternet Dengan Facebook ', 7, '2026-01-22 19:11:07'),
(83, 'Tutorial Membuat Objek dengan 3ds Max', 'Tutorial membuat objek dengan 3ds max', 8, '2026-01-22 19:11:07'),
(84, 'Pengantar Logika Informatika, Algoritma, dan Pemrograman Komputer', 'Pengantar Logika Informatika, Algoritma, dan Pemrograman Komputer', 9, '2026-01-22 19:11:08'),
(85, 'Algoritma Pemrograman', 'Algoritma Pemrograman', 9, '2026-01-22 19:11:08'),
(86, 'Teknik Mudah dan Cepat Melakukan Analisis Data Penelitian dengan Sppss', 'Teknik Mudah Dan Cepat Melakukan Analisis Data Penelitian Dengan Sppss', 9, '2026-01-22 19:11:08'),
(87, 'Rekayasa Perangkat Lunak Berorientasi Objek Mengguanakan Php', 'Rekayasa perangkat lunak Berorientasi Objek Mengguanakan PHP', 9, '2026-01-22 19:11:08'),
(88, 'Tips dan Trik Microsoft Powerpoint', 'Tips Dan Trik Microsoft Powerpoint', 9, '2026-01-22 19:11:08'),
(89, 'Aplikasi Smart Report', 'Aplikasi Smart Report ', 9, '2026-01-22 19:11:08'),
(90, 'Belajar Sendiri Pasti Bisa Pemograman C', 'Belajar Sendiri Pasti bisa Pemograman C', 9, '2026-01-22 19:11:08'),
(91, 'Mengolah Database Excel untuk Pemula', 'Mengolah Database Excel untuk Pemula', 9, '2026-01-22 19:11:08'),
(92, 'Jaringan Wireless untuk Orang Awam', 'Jaringan Wireless untuk orang awam ', 9, '2026-01-22 19:11:08'),
(93, 'Mengolah Database dengan Microsoft Excel untuk Pemula', 'Mengolah Database Dengan Microsoft Excel Untuk Pemula', 9, '2026-01-22 19:11:08'),
(94, 'Teori dan Aplikasi Stuktur Data Menggunakan C++', 'Teori dan aplikasi Stuktur Data menggunakan C++', 10, '2026-01-22 19:11:08'),
(95, 'Dasar Pengolahan Citra dengan Delphi', 'Dasar pengolahan Citra dengan Delphi', 10, '2026-01-22 19:11:08'),
(96, 'Teori dan Aplikasi Struktur Data Mengunakan C++', 'Teori Dan Aplikasi Struktur Data Mengunakan C++', 10, '2026-01-22 19:11:08'),
(97, 'Pemrograman Berorientasi Objek Menggunakan Java', 'Pemrograman Berorientasi Objek Menggunakan Java', 11, '2026-01-22 19:11:08'),
(98, 'Menguasai Pemrograman Berorientasi Objek', 'Menguasai Pemrograman Berorientasi  Objek', 11, '2026-01-22 19:11:08'),
(99, 'Rekayasa Sistem Berorientasi Objek', 'Rekayasa sistem berorientasi objek', 11, '2026-01-22 19:11:08'),
(100, 'Dasar Analisis dan Perancangan Pemograman Berorientasi Objek Menggunakan Java', 'Dasar Analisis dan Perancangan Pemograman Berorientasi Objek menggunakan Java', 11, '2026-01-22 19:11:08'),
(101, 'Panduan Mudah Membuat Augmented Reality', 'Panduan Mudah Membuat Augmented Reality', 12, '2026-01-22 19:11:08'),
(102, 'Panduan Mudah Membuat Augmented Reality', 'Panduan Mudah Membuat Augmented Reality', 12, '2026-01-22 19:11:08'),
(103, 'Computer Vision dan Aplikasinya Menggunakan C# dan Emgucv', 'Computer Vision Dan Aplikasinya Menggunakan C# Dan EmguCV', 12, '2026-01-22 19:11:08'),
(104, 'Belajar Komputer Visual Basic', 'Belajar Komputer Visual Basic ', 12, '2026-01-22 19:11:08'),
(105, 'Belajar Komputer Visual Basic', 'Belajar Komputer Visual Basic ', 12, '2026-01-22 19:11:08'),
(106, 'Pemrograman Matlab 150 + Soal Penyelesaian', 'Pemrograman Matlab 150 + Soal Penyelesaian', 13, '2026-01-22 19:11:08'),
(107, 'Belajar Mudah Matlab Beserta Aplikasinya', 'Belajar Mudah Matlab beserta Aplikasinya ', 14, '2026-01-22 19:11:08'),
(108, 'Aplikasi Pemrograman Javascript untuk Halaman Web', 'Aplikasi Pemrograman JavaScript untuk halaman Web ', 14, '2026-01-22 19:11:08'),
(109, 'Mudah Belajar Ruby', 'Mudah belajar Ruby', 14, '2026-01-22 19:11:08'),
(110, 'Kumpulan Solusi Pemrograman Ruby', 'Kumpulan Solusi Pemrograman Ruby', 14, '2026-01-22 19:11:08'),
(111, 'Belajar Coding Itu Penting di Era Revolusi Industri 4.0', 'Belajar Coding Itu Penting Di era Revolusi Industri 4.0', 14, '2026-01-22 19:11:08'),
(112, 'Handbook Jaringan Komputer', 'HandBook Jaringan Komputer', 14, '2026-01-22 19:11:08'),
(113, 'Arduino dan Sensor', 'Arduino dan Sensor', 14, '2026-01-22 19:11:08'),
(114, 'Belajar Singkat Pemrograman C', 'Belajar Singkat Pemrograman C', 15, '2026-01-22 19:11:08'),
(115, 'Ruby untuk Aplikasi Desktop dan Web', 'Ruby Untuk Aplikasi Desktop Dan Web ', 15, '2026-01-22 19:11:08'),
(116, 'Pemrograman Berorientasi Objek Menggunakan C#', 'Pemrograman Berorientasi Objek Menggunakan C#', 15, '2026-01-22 19:11:08'),
(117, 'Pemrograman Gui dengan C++ dan Qt', 'Pemrograman Gui Dengan C++ Dan Qt', 15, '2026-01-22 19:11:08'),
(118, 'Pengantar Algoritma dan Pemrograman Teknik Diagram Alur dan Bahasa Basic Dasar', 'Pengantar Algoritma Dan Pemrograman Teknik Diagram Alur Dan Bahasa Basic Dasar', 15, '2026-01-22 19:11:08'),
(119, 'Pemrograman Visual Basic 60 dan Microsoft Acces', 'Pemrograman Visual Basic 60 Dan Microsoft Acces', 15, '2026-01-22 19:11:08'),
(120, 'Pemograman Aplikasi Database Internet dengan Asp', 'Pemograman Aplikasi Database Internet Dengan asp', 15, '2026-01-22 19:11:08'),
(121, 'Panduan Menguasai Pemrograman Visual Wxpython', 'Panduan Menguasai Pemrograman Visual wxPython', 16, '2026-01-22 19:11:08'),
(122, 'Menguasai Bahasa R Teori dan Praktik', 'Menguasai Bahasa R Teori Dan Praktik', 16, '2026-01-22 19:11:08'),
(123, 'Belajar Otodidak Framework Codeigniter : Tenik Pemrograman Web dengan Php dan Framework Codeigniter 3', 'Belajar Otodidak Framework Codeigniter : Tenik Pemrograman Web dengan PHP dan Framework Codeigniter 3', 16, '2026-01-22 19:11:08'),
(124, 'Pemrograman C dan C++', 'Pemrograman C Dan C++', 16, '2026-01-22 19:11:08'),
(125, 'Proyek Website Super Wow dengan Php dan Jquery', 'Proyek Website Super WOW dengan PHP dan jQuery', 16, '2026-01-22 19:11:09'),
(126, 'From Zero To A Pro', 'From Zero to a Pro', 16, '2026-01-22 19:11:09'),
(127, 'Sistem Cepat dan Mudah Menguasai Visual Basic Net', 'Sistem Cepat dan Mudah Menguasai Visual Basic Net', 16, '2026-01-22 19:11:09'),
(128, 'Algoritma dan Pemograman dalam Bahasa Pascal,c,dan C++', 'Algoritma Dan Pemograman Dalam Bahasa Pascal,C,Dan C++', 16, '2026-01-22 19:11:09'),
(129, 'Visual Basic.net untuk Programmer', 'Visual Basic.Net Untuk Programmer', 16, '2026-01-22 19:11:09'),
(130, 'Pengantar Basis Data', 'Pengantar Basis Data', 16, '2026-01-22 19:11:09'),
(131, 'Visual Interdev 6', 'Visual Interdev 6', 16, '2026-01-22 19:11:09'),
(132, 'Visual Basic Net untuk Programmer', 'Visual Basic Net Untuk Programmer', 16, '2026-01-22 19:11:09'),
(133, 'Algoritma dan Pemograman dalam Bahasa Pascal,c,dan C++', 'Algoritma Dan Pemograman Dalam Bahasa Pascal,C,Dan C++', 16, '2026-01-22 19:11:09'),
(134, 'Pemrograman Ado .net dengan C#', 'Pemrograman ADO .NET dengan C#', 16, '2026-01-22 19:11:09'),
(135, 'Membanngun Aplikasi Vb.net', 'Membanngun Aplikasi VB.Net', 16, '2026-01-22 19:11:09'),
(136, 'Aplikasi Resto dan Cafe dengan Visual Basic untuk Orang Awam', 'Aplikasi Resto Dan Cafe Dengan Visual Basic Untuk Orang Awam', 16, '2026-01-22 19:11:09'),
(137, 'Visual Foxpro 9.0 untuk Orang Awam', 'Visual Foxpro 9.0 Untuk Orang Awam', 16, '2026-01-22 19:11:09'),
(138, 'Data Mining Algoritma dan Implementasi dengan Pemrograman Php', 'Data Mining Algoritma Dan Implementasi Dengan Pemrograman Php', 16, '2026-01-22 19:11:09'),
(139, 'Vb & Mysql Proyek Membuat Program General Ledger Seri 2', 'VB & Mysql Proyek Membuat Program General Ledger Seri 2', 16, '2026-01-22 19:11:09'),
(140, 'Membuat Aplikasi Kreatif Sesuai dengan Visual Basic Net 2013', 'Membuat Aplikasi Kreatif Sesuai Dengan Visual Basic Net 2013', 17, '2026-01-22 19:11:09'),
(141, 'Optimalisasi & Troubleshooting', 'Optimalisasi & Troubleshooting', 17, '2026-01-22 19:11:09'),
(142, 'Pintar Microsoft Office 2010 Komplit', 'Pintar Microsoft office 2010 Komplit ', 18, '2026-01-22 19:11:09'),
(143, 'Desain Kartun dan Karikatur dengan Adobe Ilustrator', 'Desain Kartun dan Karikatur dengan Adobe Ilustrator', 18, '2026-01-22 19:11:09'),
(144, 'Panduan Lengkap Belajar Coreldraw X8', 'Panduan Lengkap Belajar CorelDraw X8', 18, '2026-01-22 19:11:09'),
(145, 'Analisis Data dan Pemodelan Bisnis Menggunakan Excel', 'Analisis data dan Pemodelan Bisnis Menggunakan Excel', 18, '2026-01-22 19:11:09'),
(146, 'Kreasi Efek Film Spektakuler dengan Adobe Premiere', 'Kreasi efek film spektakuler dengan Adobe Premiere', 18, '2026-01-22 19:11:09'),
(147, 'Buku Pintar App Inventor', 'Buku Pintar App Inventor', 18, '2026-01-22 19:11:09'),
(148, 'Adobe Fireworks Cs6', 'Adobe Fireworks CS6', 18, '2026-01-22 19:11:09'),
(149, 'Kupas Tuntas Microsoft Excel 2016', 'Kupas Tuntas Microsoft Excel 2016 ', 18, '2026-01-22 19:11:09'),
(150, 'Rumus dan Fungsi Microsoft Access 2007', 'Rumus Dan Fungsi Microsoft Access 2007', 18, '2026-01-22 19:11:09'),
(151, 'Microsoft Word 2010 untuk Pemula', 'Microsoft Word 2010 Untuk Pemula', 18, '2026-01-22 19:11:09'),
(152, 'Adobe Fireworks Cs6', 'Adobe Fireworks CS6', 18, '2026-01-22 19:11:09'),
(153, 'Koleksi Program Vb . Net untuk Tugas Akhir dan Skripsi Edisi Revisi', 'Koleksi Program VB . NET untuk Tugas Akhir dan Skripsi Edisi Revisi', 18, '2026-01-22 19:11:09'),
(154, 'Tutorial Perancangan Hardware 3', 'Tutorial Perancangan Hardware 3', 18, '2026-01-22 19:11:09'),
(155, 'Dasar Raspberry Pi', 'Dasar Raspberry Pi', 18, '2026-01-22 19:11:09'),
(156, 'Microsoft Word 2010 untuk Pemula', 'Microsoft Word 2010 Untuk Pemula ', 18, '2026-01-22 19:11:09'),
(157, 'Belajar Komputer Animasi Macromedia Flash', 'Belajar Komputer Animasi Macromedia Flash', 18, '2026-01-22 19:11:09'),
(158, 'Buku Pintar Microsoft Office Word', 'Buku Pintar Microsoft Office Word', 18, '2026-01-22 19:11:09'),
(159, 'Ip Routing dan Firewal dalam Linux', 'Ip Routing Dan Firewal Dalam Linux', 19, '2026-01-22 19:11:09'),
(160, '101 Masalah Malware & Penangannya', '101 Masalah Malware & Penangannya', 19, '2026-01-22 19:11:09'),
(161, 'Ip Routing dan Firewel dalam Linux', 'Ip Routing Dan Firewel Dalam Linux', 19, '2026-01-22 19:11:09'),
(162, 'Mahir dalam 7 Hari Mikrosoft Excel 2016', 'Mahir Dalam 7 hari Mikrosoft Excel 2016', 20, '2026-01-22 19:11:09'),
(163, 'Kumpulan Top Minigame dan Event Rpg Maker Vx Ace', 'Kumpulan Top Minigame dan Event RPG Maker VX Ace', 20, '2026-01-22 19:11:09'),
(164, 'Cara Mudah Menguasai Microsoft Word 2007 dalam Seminggu', 'Cara Mudah Menguasai Microsoft Word 2007 dalam Seminggu', 20, '2026-01-22 19:11:09'),
(165, 'Autocad 2014 untuk Pemula', 'Autocad 2014 Untuk Pemula', 20, '2026-01-22 19:11:09'),
(166, 'Pengolahan Suara dengan Audacity', 'Pengolahan Suara Dengan Audacity', 20, '2026-01-22 19:11:09'),
(167, 'Kumpulan Utility Dahsyat untuk Os Windows & Jaringan Komputer', 'Kumpulan Utility Dahsyat untuk OS Windows & Jaringan Komputer', 21, '2026-01-22 19:11:09'),
(168, 'Teknik Instalasi dan Re-mastering Sistem Operasi Windows', 'Teknik Instalasi dan Re-mastering sistem operasi Windows', 21, '2026-01-22 19:11:10'),
(169, '500 Trik dan Tips Excel', '500 Trik dan Tips Excel', 21, '2026-01-22 19:11:10'),
(170, 'Membuat Database dengan Microsoft Access', 'Membuat Database dengan Microsoft Access', 21, '2026-01-22 19:11:10'),
(171, 'Microsoft Word untuk Administrasi Perkantoran Modern', 'Microsoft Word Untuk Administrasi Perkantoran Modern', 21, '2026-01-22 19:11:10'),
(172, 'Autocad untuk Desain Rumah Revisi Kedua', 'Autocad Untuk desain Rumah REVISI KEDUA', 21, '2026-01-22 19:11:10'),
(173, 'Aplikasi Akutansi dengan Microsoft Excel Vba [macro]', 'Aplikasi Akutansi Dengan Microsoft Excel Vba [Macro]', 21, '2026-01-22 19:11:10'),
(174, '100 Kasus Pemrograman Visual C#', '100 Kasus Pemrograman Visual C#', 21, '2026-01-22 19:11:10'),
(175, 'Kupas Tuntas Microsoft Windows 10', 'Kupas Tuntas Microsoft Windows 10', 21, '2026-01-22 19:11:10'),
(176, 'Rumus & Fungsi Terapan pada Microsofft Excel', 'Rumus & Fungsi Terapan Pada Microsofft Excel', 21, '2026-01-22 19:11:10'),
(177, 'Rumus dan Fungsi Terapan pada Microsoft Excel', 'Rumus dan Fungsi Terapan pada Microsoft Excel', 21, '2026-01-22 19:11:10'),
(178, 'Referensi Cepat Menggunakan Microsoft Word 2007', 'Referensi Cepat Menggunakan Microsoft Word 2007', 21, '2026-01-22 19:11:10'),
(179, '36 Jam Belajar Komputer Microsoft Office 2000 Standard Edition', '36 Jam belajar Komputer Microsoft Office 2000 Standard Edition', 21, '2026-01-22 19:11:10'),
(180, 'Penggunaan Praktis Map Info Profesional', 'Penggunaan Praktis Map Info Profesional ', 21, '2026-01-22 19:11:10'),
(181, 'Belajar Sendiri Aplikasi Database dengan Microsoft Visual Foxpro 9.0', 'Belajar Sendiri Aplikasi Database Dengan Microsoft Visual FoxPro 9.0', 21, '2026-01-22 19:11:10'),
(182, 'Construct 2 Tutorial Game', 'Construct 2 Tutorial Game', 22, '2026-01-22 19:11:10'),
(183, 'Autocad untuk Teknik Revisi Dua', 'AutoCAD untuk Teknik revisi dua', 22, '2026-01-22 19:11:10'),
(184, 'Penuntun Penggunaan Microsoft Word 2002 untuk Penulisan Laporan Tugas Akhir', 'Penuntun Penggunaan Microsoft Word 2002 untuk Penulisan Laporan Tugas Akhir', 22, '2026-01-22 19:11:10'),
(185, 'Belajar Sendiri Pemrograman Database Menggunakan Delphi 7.0 dengan Metode Ado', 'Belajar Sendiri Pemrograman Database Menggunakan Delphi 7.0 dengan Metode ADO', 22, '2026-01-22 19:11:10'),
(186, 'Microsoft Office Praktis', 'Microsoft Office Praktis', 22, '2026-01-22 19:11:10'),
(187, '20 Kreasi Template Blog Menarik dengan Css3', '20 Kreasi Template Blog Menarik dengan CSS3', 22, '2026-01-22 19:11:10'),
(188, 'Pedoman Panduan Praktikum Microsoft Office Excel 2003', 'Pedoman Panduan Praktikum Microsoft Office Excel 2003', 22, '2026-01-22 19:11:10'),
(189, 'Buku Latihan Dbase Iii Plus Tingkat Dasar', 'Buku Latihan Dbase III Plus tingkat Dasar', 22, '2026-01-22 19:11:10'),
(190, '3d Studio Max', '3D Studio MAX', 22, '2026-01-22 19:11:10'),
(191, 'Tips dan Trik Adobe Pagemaker 7.0', 'Tips dan Trik Adobe PageMaker 7.0', 22, '2026-01-22 19:11:11'),
(192, '155 Tips & Trik Mikrosoft Excel', '155 Tips & Trik Mikrosoft Excel', 22, '2026-01-22 19:11:11'),
(193, '155 Tips & Trik Mikrosoft Word', '155 Tips & Trik Mikrosoft Word', 22, '2026-01-22 19:11:11'),
(194, 'Toturial Lengkap Menguasai Arcgis 10', 'Toturial Lengkap Menguasai ArcGIS 10', 22, '2026-01-22 19:11:11'),
(195, 'The Magic Of 3ds Max Modeling', 'The Magic OF 3DS MAX Modeling', 22, '2026-01-22 19:11:11'),
(196, 'Mahir dalam 7 Hari Mikrosoft Project 2003', 'Mahir Dalam 7 hari Mikrosoft Project 2003', 22, '2026-01-22 19:11:11'),
(197, 'Tutorial Lengkap Menguasai Arcgis 10', 'Tutorial Lengkap Menguasai ArcGIS 10', 22, '2026-01-22 19:11:11'),
(198, 'Tip dan Trik Microsoft Office 2003', 'Tip dan Trik Microsoft office 2003', 22, '2026-01-22 19:11:11'),
(199, 'Pengelolaan Proyek dengan Microsoft Office Project 2007', 'Pengelolaan Proyek dengan Microsoft Office Project 2007', 22, '2026-01-22 19:11:11'),
(200, 'Kupas Tuntas Pivochart dan Pivottable Microsoft Excel', 'Kupas Tuntas PivoChart dan PivotTable Microsoft Excel', 22, '2026-01-22 19:11:11'),
(201, 'Berkreasi Animasi dengan Macromedia Flash Mx', 'Berkreasi animasi dengan Macromedia Flash MX ', 22, '2026-01-22 19:11:11'),
(202, 'Microsoft Acces untuk Semua Orang', 'Microsoft Acces untuk semua Orang ', 22, '2026-01-22 19:11:11'),
(203, 'Manipulasi Foto Pribadi dengan Adobe Photoshop', 'Manipulasi Foto Pribadi Dengan Adobe Photoshop', 22, '2026-01-22 19:11:11'),
(204, 'Kupas Tuntas Microsoft Word 2016', 'Kupas Tuntas Microsoft Word 2016', 22, '2026-01-22 19:11:11'),
(205, 'Aplikasi Akutansi dengan Microsoft Access', 'Aplikasi Akutansi Dengan Microsoft Access', 22, '2026-01-22 19:11:11'),
(206, 'Coreldraw X8 untuk Pemula', 'Coreldraw x8 Untuk Pemula', 22, '2026-01-22 19:11:11'),
(207, 'Dbase Iv 1.1 Termasuk Dbase 1.5', 'dBase IV 1.1 Termasuk dBase 1.5', 22, '2026-01-22 19:11:11'),
(208, 'Belajar Otodidak Flask', 'Belajar Otodidak Flask ', 22, '2026-01-22 19:11:11'),
(209, 'Panduan Lengkap Belajar Corelidraw X8', 'Panduan Lengkap Belajar Corelidraw X8', 22, '2026-01-22 19:11:11'),
(210, 'Belajar Sendiri Red Hat Enterprise Linux 4', 'Belajar Sendiri Red Hat Enterprise Linux 4', 22, '2026-01-22 19:11:11'),
(211, 'Aplikasi Excel untuk Ukm', 'Aplikasi Excel Untuk Ukm', 22, '2026-01-22 19:11:11'),
(212, 'Aplikasi Akutansi dengan Microsoft Acces', 'Aplikasi Akutansi Dengan  Microsoft Acces', 22, '2026-01-22 19:11:11'),
(213, 'Desain Undangan dengan Coreldraw X7', 'Desain Undangan Dengan Coreldraw X7', 22, '2026-01-22 19:11:11'),
(214, 'Adobe Pagemaker Dilengkapi dengan Bimbingan Menjadi Tenaga Setting Siap Kerja', 'Adobe Pagemaker Dilengkapi Dengan Bimbingan Menjadi Tenaga Setting Siap Kerja', 22, '2026-01-22 19:11:11'),
(215, 'Mahir Menggunakan Spss Secara Otodidak', 'Mahir Menggunakan Spss Secara Otodidak', 22, '2026-01-22 19:11:11'),
(216, 'Excel 2013 untuk Orang Awam', 'Excel 2013 Untuk Orang Awam', 22, '2026-01-22 19:11:11'),
(217, 'Analisa Desain & Pemrograman Berorientasi Obyek', 'Analisa Desain & Pemrograman Berorientasi Obyek ', 22, '2026-01-22 19:11:11'),
(218, 'Buku Latihan Dbase Iii Plus Tingkat Dasar', 'Buku Latihan dBASE III Plus Tingkat Dasar', 22, '2026-01-22 19:11:11'),
(219, 'Panduan Tutorial dan Troubleshooting Word 2003', 'Panduan Tutorial Dan Troubleshooting Word 2003', 22, '2026-01-22 19:11:11'),
(220, 'Panduan Menggunakan Linux Igos Nusantara', 'Panduan Menggunakan Linux Igos Nusantara ', 22, '2026-01-22 19:11:11'),
(221, 'Menggunakan Openoffice.org Semudah Ms Office', 'Menggunakan Openoffice.org semudah MS Office', 22, '2026-01-22 19:11:11'),
(222, 'Microsoft Powerpoint 2000 Bagi Pemula', 'Microsoft Powerpoint 2000 Bagi Pemula', 22, '2026-01-22 19:11:11'),
(223, 'Praktikan Microsoft Windows Xp', 'Praktikan Microsoft Windows Xp', 22, '2026-01-22 19:11:11'),
(224, 'P5b User Guide', 'P5b User Guide', 22, '2026-01-22 19:11:11'),
(225, 'Membuat Berbagai Diagram dengan Visio 2007', 'Membuat Berbagai Diagram Dengan Visio 2007', 22, '2026-01-22 19:11:11'),
(226, 'Memakai Corel Dream 3d 7', 'Memakai Corel Dream 3D 7', 22, '2026-01-22 19:11:11'),
(227, 'Broker Preneurship', 'Broker Preneurship', 22, '2026-01-22 19:11:11'),
(228, 'Kekuatan Garis dan Warna Adobe Photoshop For Designer', 'Kekuatan Garis Dan Warna Adobe Photoshop For Designer', 22, '2026-01-22 19:11:11'),
(229, 'Belajar Sendiri Windows Vista', 'Belajar Sendiri Windows Vista ', 22, '2026-01-22 19:11:11'),
(230, 'Excel Tip Trik Handal Pengolahan Pengolahan Proses Akuntansi', 'Excel Tip Trik Handal Pengolahan Pengolahan Proses Akuntansi', 22, '2026-01-22 19:11:11'),
(231, 'Mudah Belajar Python untuk Aplikasi Desktop dan Web', 'Mudah Belajar Python Untuk Aplikasi Desktop Dan Web', 22, '2026-01-22 19:11:11'),
(232, 'Flash Mx 6', 'Flash Mx 6', 22, '2026-01-22 19:11:11'),
(233, 'Pedoman Panduan Praktikum Microsoft Office 2003', 'Pedoman Panduan Praktikum Microsoft office 2003', 22, '2026-01-22 19:11:12'),
(234, 'Buku Pintar Microsoft Office Excel Seri Junior Programmer', 'Buku Pintar Microsoft Office Excel Seri Junior Programmer', 22, '2026-01-22 19:11:12'),
(235, 'Pedoman Panduan Pratikum Microsoft Word 2003 Dilengkapi dengan Contoh Contoh Latihan', 'Pedoman Panduan Pratikum Microsoft Word 2003 Dilengkapi dengan Contoh contoh Latihan', 22, '2026-01-22 19:11:12'),
(236, 'Opration System Linux Red Hat For Intermediate', 'Opration  System Linux Red Hat For Intermediate', 22, '2026-01-22 19:11:12'),
(237, 'Panduan Praktis Microsoft Word 2007', 'Panduan Praktis Microsoft Word 2007', 22, '2026-01-22 19:11:12'),
(238, 'Pembangunan Internet dengan Windows Nt Server 4.0', 'Pembangunan Internet Dengan Windows Nt Server 4.0', 22, '2026-01-22 19:11:12'),
(239, 'Windows Xp Profesional', 'Windows Xp Profesional', 22, '2026-01-22 19:11:12'),
(240, 'Aplikasi Myob Plus 13 pada Bisnis Manufacturing', 'Aplikasi MYOB Plus 13 Pada Bisnis Manufacturing', 22, '2026-01-22 19:11:12'),
(241, 'Panduan Mengelola Proyek dengan Microsoft Office Project 2007', 'Panduan Mengelola Proyek Dengan Microsoft Office project 2007', 22, '2026-01-22 19:11:12'),
(242, '99 Tips & Trik Tersembuyi Microsoft Office Excel 2007', '99 Tips & Trik tersembuyi Microsoft Office Excel 2007', 22, '2026-01-22 19:11:12'),
(243, 'Pedoman Panduan Pratikum Microsoft Office 2003', 'Pedoman panduan pratikum Microsoft Office 2003', 22, '2026-01-22 19:11:12'),
(244, 'Tip Ampuh Mempercepat Kerja Windows Xp', 'Tip Ampuh Mempercepat Kerja Windows Xp', 22, '2026-01-22 19:11:12'),
(245, 'Buku Pintar Microsoft Office Excel Seri Junior Progammer', 'Buku Pintar Microsoft Office Excel Seri Junior Progammer', 22, '2026-01-22 19:11:12'),
(246, 'Buku Pintar Microsoft Office Excel Seri Junior Progammer', 'Buku Pintar Microsoft Office Excel Seri Junior Progammer', 22, '2026-01-22 19:11:12'),
(247, 'Buku Pintar Microsoft Office Excel Seri Junior Progammer', 'Buku Pintar Microsoft Office Excel Seri Junior Progammer', 22, '2026-01-22 19:11:12'),
(248, 'Kursus Kilat 24 Jurus Microsoft Excel 97', 'Kursus Kilat 24 Jurus Microsoft Excel 97', 22, '2026-01-22 19:11:12'),
(249, 'Pedoman Panduan Praktikum Microsoft Office Excel 2003', 'Pedoman Panduan Praktikum Microsoft Office Excel 2003', 22, '2026-01-22 19:11:12'),
(250, 'Pedoman Panduan Praktikum Microsoft Office Excel 2003', 'Pedoman Panduan Praktikum Microsoft Office Excel 2003', 22, '2026-01-22 19:11:12'),
(251, 'Pedoman Panduan Praktikum Microsoft Office Excel 2003', 'Pedoman Panduan Praktikum Microsoft Office Excel 2003', 22, '2026-01-22 19:11:12'),
(252, 'Pedoman Panduan Praktikum Microsoft Office Excel 2003', 'Pedoman Panduan Praktikum Microsoft Office Excel 2003', 22, '2026-01-22 19:11:12'),
(253, 'Pedoman Panduan Praktikum Microsoft Office Word 2003', 'Pedoman Panduan Praktikum Microsoft Office Word 2003 ', 22, '2026-01-22 19:11:12'),
(254, 'Pedoman Panduan Praktikum Microsoft Office Word 2003', 'Pedoman Panduan Praktikum Microsoft Office Word 2003 ', 22, '2026-01-22 19:11:12'),
(255, 'Pedoman Paduan Praktikum Microsoft Excel 2003', 'Pedoman Paduan Praktikum Microsoft excel 2003', 22, '2026-01-22 19:11:12'),
(256, 'Pedoaman Panduan Praktikum Adobe Pagemaker 7.0', 'Pedoaman Panduan Praktikum  Adobe Pagemaker 7.0', 22, '2026-01-22 19:11:12'),
(257, 'Memberdayakan Pc dengan Program Downlood', 'Memberdayakan Pc Dengan Program Downlood', 22, '2026-01-22 19:11:12'),
(258, 'Mengelola Database Mengunakan Openoffice.org Base', 'Mengelola Database Mengunakan OpenOffice.Org Base', 22, '2026-01-22 19:11:12'),
(259, 'Praktikum Micriosoft Word', 'Praktikum Micriosoft Word ', 22, '2026-01-22 19:11:12'),
(260, 'App Inventor By Example', 'App Inventor by Example ', 23, '2026-01-22 19:11:12'),
(261, 'Pilih Windows , Mac, atau Linux Filosofi Sebuah Komputer', 'Pilih Windows , Mac, Atau Linux Filosofi sebuah Komputer', 23, '2026-01-22 19:11:12'),
(262, 'Fitur Istimewa Windows 7 dan Cara Menggunakannya', 'Fitur Istimewa Windows 7 dan Cara menggunakannya', 23, '2026-01-22 19:11:12'),
(263, 'Kupas Tuntas Tool Gratis Proteksi Windows, Jaringan dan Internet Security', 'kupas Tuntas Tool Gratis  Proteksi Windows, Jaringan dan Internet Security', 23, '2026-01-22 19:11:12'),
(264, 'Mudah Belajar Linux', 'Mudah Belajar Linux', 23, '2026-01-22 19:11:12'),
(265, 'Mengubah Windows 7 Menjadi Linux Mac Os Windows 8', 'Mengubah Windows 7 Menjadi Linux Mac Os Windows 8', 23, '2026-01-22 19:11:12'),
(266, 'Windows Server System Indonesia', 'Windows Server System Indonesia', 23, '2026-01-22 19:11:12'),
(267, 'Microsoft Windows 10 untuk Pemula', 'Microsoft Windows 10 Untuk Pemula', 23, '2026-01-22 19:11:12'),
(268, 'Windows Server System Indonesia', 'Windows Server System Indonesia ', 23, '2026-01-22 19:11:12'),
(269, 'Windows Server System Indonesia', 'Windows Server system Indonesia ', 23, '2026-01-22 19:11:12'),
(270, 'Windows Server System Indonesia', 'Windows Server System Indonesia ', 23, '2026-01-22 19:11:12'),
(271, 'Panduan Praktis Mengoptimalkan Pivottable Excel untuk Membuat Laporan dan Analisis Data', 'Panduan Praktis Mengoptimalkan PivotTable Excel untuk membuat Laporan dan Analisis data', 24, '2026-01-22 19:11:12'),
(272, 'Dreamweaver Cs4 untuk Orang Awam', 'Dreamweaver CS4 untuk orang awam', 25, '2026-01-22 19:11:12'),
(273, 'Mengoptimalkan Microsoft Excel untuk Analisis Data', 'Mengoptimalkan Microsoft excel Untuk Analisis Data', 25, '2026-01-22 19:11:13'),
(274, 'Membuat Catatan Digital Microsoft Office Onenote 2007', 'Membuat Catatan digital Microsoft Office OneNote 2007', 25, '2026-01-22 19:11:13'),
(275, 'Tutorial Praktis Menggunakan Microsoft Excel 2003', 'Tutorial Praktis Menggunakan Microsoft Excel 2003', 25, '2026-01-22 19:11:13'),
(276, 'Cara Praktis Menguasai Adobe Indesign Cs2 Ver.4.0', 'Cara praktis Menguasai Adobe InDesign CS2 Ver.4.0', 25, '2026-01-22 19:11:13'),
(277, 'Menguasai Rumus dan Fungsi Microsoft Excel Populer untuk Pemula', 'Menguasai Rumus Dan Fungsi Microsoft Excel Populer untuk pemula', 25, '2026-01-22 19:11:13'),
(278, 'Tuntas Belajar Microsoft Word 2010', 'Tuntas Belajar Microsoft Word 2010', 25, '2026-01-22 19:11:13'),
(279, 'Cara Praktis Tabel dan Diagram dengan Microsoft Excel', 'Cara Praktis Tabel Dan Diagram Dengan Microsoft Excel', 25, '2026-01-22 19:11:13'),
(280, 'Tip & Trik Tersembunyi Microsoft Excel 2007', 'Tip & Trik Tersembunyi Microsoft Excel 2007', 25, '2026-01-22 19:11:13'),
(281, 'Kolaborasi Microsoft Word & Excel', 'Kolaborasi Microsoft Word & excel', 25, '2026-01-22 19:11:13'),
(282, 'Mahir dalam Aplikasi Excel', 'Mahir Dalam Aplikasi Excel', 25, '2026-01-22 19:11:13'),
(283, 'Trik Ajaib Membuat Desain Komponen Mekanis 2d dan 3d Solidworks', 'Trik Ajaib Membuat Desain Komponen Mekanis 2D dan 3D Solidworks', 25, '2026-01-22 19:11:13'),
(284, 'Belajar Komputer Power Point', 'Belajar Komputer power point', 25, '2026-01-22 19:11:13'),
(285, 'Belajar Aplikasi Microsoft Excel 2003', 'Belajar Aplikasi Microsoft Excel 2003 ', 25, '2026-01-22 19:11:13'),
(286, '12 Langkah Membangun Aplikasi dengan Microsoft Acces', '12 Langkah Membangun Aplikasi Dengan Microsoft Acces', 25, '2026-01-22 19:11:13'),
(287, 'Belajar Cepat dan Tepat Kolaborasi Microsoft Word & Excel', 'Belajar Cepat Dan Tepat Kolaborasi Microsoft Word & Excel', 25, '2026-01-22 19:11:13'),
(288, 'Belajar Komputer Powerpoint', 'Belajar Komputer Powerpoint', 25, '2026-01-22 19:11:13'),
(289, 'Cara Praktis Penyajian Data Tabel dan Diagram dengan Microsoft Excel', 'Cara Praktis Penyajian Data Tabel dan Diagram dengan Microsoft Excel', 25, '2026-01-22 19:11:13'),
(290, 'Belajar Cepat dan Tepat Kolaborasi Microsoft Word & Excel', 'Belajar Cepat Dan Tepat Kolaborasi Microsoft Word & Excel', 25, '2026-01-22 19:11:13'),
(291, 'Ragam Model Penelitian dan Pengolahannya', 'Ragam Model Penelitian Dan Pengolahannya', 26, '2026-01-22 19:11:13'),
(292, 'Path Analysis Menggunakan Spss dan Excel', 'Path Analysis Menggunakan Spss Dan Excel ', 26, '2026-01-22 19:11:13'),
(293, 'Migrasi Microsoft Sql Server dengan Postgresql', 'Migrasi Microsoft SQL Server dengan PostgreSQL', 27, '2026-01-22 19:11:13'),
(294, 'Analisis dan Disain', 'Analisis dan Disain ', 27, '2026-01-22 19:11:13'),
(295, 'Pengantar Data Mining Menggali Pengetahuan dari Bongkahan Data', 'Pengantar data Mining Menggali Pengetahuan dari Bongkahan Data', 27, '2026-01-22 19:11:13'),
(296, 'Sistem Pendukung Keputusan', 'Sistem Pendukung Keputusan', 27, '2026-01-22 19:11:13'),
(297, 'Administrasi Database Oracle8i', 'Administrasi Database Oracle8i', 27, '2026-01-22 19:11:13'),
(298, 'Pemrograman Basis Data di Matlab dengan Mysql dan Microsoft Access', 'Pemrograman Basis Data Di Matlab Dengan MySQL dan Microsoft Access', 27, '2026-01-22 19:11:13'),
(299, 'Data Mining', 'Data Mining', 27, '2026-01-22 19:11:13'),
(300, 'Migrasi Database Programmer dan Administrator Database', 'Migrasi Database Programmer dan Administrator Database ', 27, '2026-01-22 19:11:13'),
(301, 'Rumus dan Fungsi Microsoft Accsess', 'Rumus dan Fungsi Microsoft Accsess', 27, '2026-01-22 19:11:13'),
(302, 'Pemrograman Database Menggunakan Mysql', 'Pemrograman Database Menggunakan MySQL ', 27, '2026-01-22 19:11:13'),
(303, 'Belajar Cepat Pemrograman Query dengan Mysql', 'Belajar Cepat Pemrograman Query Dengan MySql', 27, '2026-01-22 19:11:13'),
(304, 'Data Mining', 'Data Mining', 27, '2026-01-22 19:11:13'),
(305, 'Panduan Belajar Microsoft Access 2002', 'Panduan Belajar Microsoft Access 2002', 27, '2026-01-22 19:11:14'),
(306, 'Pedoman Panduan Praktikum Microsoft Office 2007', 'pedoman Panduan praktikum Microsoft Office 2007', 27, '2026-01-22 19:11:14'),
(307, 'Microsoft Access 2002', 'Microsoft access 2002', 27, '2026-01-22 19:11:14'),
(308, 'Trik Cepat Belajar Sendiri Microsoft Word', 'Trik Cepat Belajar Sendiri Microsoft Word', 27, '2026-01-22 19:11:14'),
(309, 'Cara Cara Menginstal Software dan Driver', 'Cara Cara Menginstal Software Dan Driver', 27, '2026-01-22 19:11:14'),
(310, 'Soal Praktik dan Aplikasi Microsoft Office Access 2003', 'Soal Praktik dan Aplikasi Microsoft Office Access 2003', 27, '2026-01-22 19:11:14'),
(311, 'Soal Praktik dan Aplikasi Microsoft Office Access 2003', 'Soal Praktik dan Aplikasi Microsoft Office Access 2003', 27, '2026-01-22 19:11:14'),
(312, 'Soal Praktik dan Aplikasi Microsoft Office Access 2003', 'Soal Praktik dan Aplikasi Microsoft Office Access 2003', 27, '2026-01-22 19:11:14'),
(313, 'Back I Track 5r3 100% Attack', 'Back I Track 5R3 100% ATTACK', 28, '2026-01-22 19:11:14'),
(314, 'Security Jaringan Komputer Berbasis C Eh', 'Security Jaringan Komputer Berbasis C EH', 28, '2026-01-22 19:11:14'),
(315, 'Trik Mudah Menjebol Sekalian Mengamankan Password', 'Trik mudah menjebol sekalian mengamankan password', 28, '2026-01-22 19:11:14'),
(316, 'Mengamankan Jaringan Komputer dengan Untage', 'Mengamankan Jaringan Komputer dengan Untage', 28, '2026-01-22 19:11:14'),
(317, 'Security Jaringan Komputer Berbasis Ceh', 'Security Jaringan Komputer Berbasis CEH', 28, '2026-01-22 19:11:14'),
(318, 'Ancaman Internet Hacking dan Trik Menanganinya', 'Ancaman Internet Hacking dan Trik Menanganinya', 28, '2026-01-22 19:11:14'),
(319, 'Back Track 5 R3 100% Attack', 'Back Track 5 R3 100% Attack', 28, '2026-01-22 19:11:14'),
(320, 'Koleksi Software Gratis untuk Hacking dan Cracking', 'Koleksi Software Gratis untuk Hacking Dan Cracking', 28, '2026-01-22 19:11:14'),
(321, 'Anda Bertanya Dukun Virus Menjawab', 'Anda Bertanya Dukun Virus Menjawab ', 28, '2026-01-22 19:11:14'),
(322, 'Kripto Grafi Edisi Kedua', 'KRIPTO GRAFI Edisi kedua', 29, '2026-01-22 19:11:14'),
(323, 'Komplikasi Proyek Kriptografi dengan Visual Basic .net', 'Komplikasi Proyek Kriptografi dengan Visual Basic .NET', 29, '2026-01-22 19:11:14'),
(324, 'Kompilasi Proyek Kriptografi dengan Visual Basic.net', 'Kompilasi Proyek Kriptografi Dengan Visual Basic.Net', 29, '2026-01-22 19:11:14'),
(325, 'Object Oriented Modeling And Design', 'Object Oriented Modeling And Design', 30, '2026-01-22 19:11:14'),
(326, 'Elektronika Digital dan Sistem Embedded', 'Elektronika Digital dan Sistem Embedded', 31, '2026-01-22 19:11:14'),
(327, 'Arduino Belajar Cepat dan Pemrograman', 'Arduino Belajar Cepat dan Pemrograman', 31, '2026-01-22 19:11:14'),
(328, 'Elektronika Digital dan Sistem Embedded', 'Elektronika Digital Dan Sistem Embedded', 31, '2026-01-22 19:11:14'),
(329, 'Belajar Sendiri Pr Adobe Premiere Cc 2019', 'Belajar Sendiri Pr Adobe premiere CC 2019', 32, '2026-01-22 19:11:14'),
(330, 'Computer Graphic Design', 'Computer Graphic Design', 32, '2026-01-22 19:11:14'),
(331, 'Konsep Grafika Komputer', 'Konsep Grafika Komputer', 32, '2026-01-22 19:11:14'),
(332, 'Computer Graphic Design', 'Computer Graphic Design', 32, '2026-01-22 19:11:14'),
(333, 'Struktur Data pada Program Java dan Python', '', 10, '2026-01-22 19:11:14'),
(334, 'Sistem Komunikasi Seluler : Perencanaan Jaringan 5g New Radio - Teori dan Simulasi', '', 4, '2026-01-22 19:11:14'),
(335, 'Rekayasa Perangkat Lunak', '', 9, '2026-01-22 19:11:14'),
(336, 'Merawat dan Memperbaiki Komputer', 'Meskipun teknologi komputer terus berkembang dan digunakan secara luas di berbagai bidang, prinsip perawatan dan perbaikannya secara umum tetap sama. Sayangnya, banyak pengguna enggan melakukannya sendiri karena faktor ketidaktahuan atau kemalasan.', 1, '2026-01-22 19:11:14'),
(337, 'Menjadi Teknisi Komputer Laptop', 'Menjadi teknisi komputer ternyata tidak sulit. Buku ini hadir untuk membuktikan betapa sederhananya dunia komputer bagi siapa saja.\n\nMateri yang akan Anda dapatkan:\nDasar & Praktik: Pengenalan hardware/software, teknik perakitan, hingga instalasi.\nBisnis: Tips membuka usaha servis dan daftar harga perangkat terbaru.\nBonus: Video CD tutorial perakitan untuk panduan visual yang lebih jelas.', 1, '2026-01-22 19:11:14'),
(338, 'Panduan Menjadi Teknisi Komputer', 'Panduan menjadi teknisi komputer', 1, '2026-01-22 19:11:14'),
(339, 'Tool Terbaik untuk Perawatan Pc', 'Tool terbaik untuk perawatan pc', 1, '2026-01-22 19:11:14'),
(340, 'Memilih dan Merawat Periferal Notebook', 'Memilih dan merawat periferal notebook', 1, '2026-01-22 19:11:14'),
(341, 'Teknik Rahasia Merakit Komputer Cepat Tanpa Guru', 'Teknik rahasia merakit komputer cepat tanpa guru', 1, '2026-01-22 19:11:14'),
(342, 'Troubleshooting Komputer', 'Troubleshooting komputer', 1, '2026-01-22 19:11:15'),
(343, 'Merawat & Memperbaiki Sendiri Sistem Komputer & Laptop', 'Merawat & Memperbaiki Sendiri Sistem Komputer & Laptop', 1, '2026-01-22 19:11:15'),
(344, 'Merawat & Memperbaiki Komputer', 'Merawat & Memperbaiki Komputer', 1, '2026-01-22 19:11:15'),
(345, 'Merakit, Merawat, Upgrade, dan Memperbaiki Pc', '\nMerakit, merawat, upgrade, dan memperbaiki pc', 1, '2026-01-22 19:11:15'),
(346, 'Perbaikan dan Perawatan Pc dan Laptop', 'Perbaikan dan Perawatan PC dan Laptop', 1, '2026-01-22 19:11:15'),
(347, 'Panduan Lengkap Instalasi dan Konfigurasi Jaringan Lan-wan-wireless-fiber Optic Berbasis Iot Industry 4.0', '', 5, '2026-01-22 19:11:15'),
(348, 'Basis Data Non Relasional', '', 27, '2026-01-22 19:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_pengujian`
--

CREATE TABLE `hasil_pengujian` (
  `id` int(11) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `kode_ddc_prediksi` varchar(20) DEFAULT NULL,
  `confidence` decimal(5,2) DEFAULT NULL,
  `status_kesesuaian` enum('Sesuai','Tidak Sesuai') DEFAULT NULL,
  `akurasi_pengujian` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
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

--
-- Dumping data for table `kategori_ddc`
--

INSERT INTO `kategori_ddc` (`id`, `kode_ddc`, `nama_kategori`) VALUES
(1, '004.0288', 'Perawatan, Perakitan & Servis Komputer'),
(2, '004.03', 'Kamus & Ensiklopedia Komputer'),
(3, '004.2', 'Arsitektur & Analisis Sistem'),
(4, '004.42', 'Dasar Pemrograman (General)'),
(5, '004.6', 'Jaringan Komputer & Komunikasi Data'),
(6, '004.65', 'Administrasi Jaringan & Routing'),
(7, '004.678', 'Internet & Aplikasi Online'),
(8, '004.71', 'Periferal Komputer & Grafik'),
(9, '005.1', 'Algoritma, Rekayasa Perangkat Lunak'),
(10, '005.11', 'Struktur Data'),
(11, '005.117', 'Pemrograman Berorientasi Objek (OOP)'),
(12, '005.118', 'Pemrograman Visual & Computer Vision'),
(13, '005.12', 'Pemrograman Model Matematika (Matlab)'),
(14, '005.13', 'Bahasa Pemrograman Spesifik (Ruby, dll)'),
(15, '005.133', 'Bahasa C, C++, C#'),
(16, '005.262', 'Pemrograman Web/Desktop Framework'),
(17, '005.276', 'Aplikasi Pemrograman Lanjut'),
(18, '005.3', 'Program Aplikasi Umum & Grafis'),
(19, '005.34', 'Aplikasi Keamanan & Utilitas OS'),
(20, '005.36', 'Aplikasi Perkantoran: Konsep'),
(21, '005.368', 'Microsoft Office (Lanjut) & Utilitas Windows'),
(22, '005.369', 'Aplikasi Desain & Lain-lain (Office)'),
(23, '005.43', 'OS Spesifik (Windows, Linux)'),
(24, '005.478', 'Pelaporan & Analisis Data (Excel Lanjut)'),
(25, '005.5', 'Aplikasi Serba Guna & Kolaborasi'),
(26, '005.55', 'Aplikasi Statistik dan Analisis Data'),
(27, '005.74', 'Sistem Manajemen Basis Data (DBMS) & SQL'),
(28, '005.8', 'Keamanan Data, Jaringan & Hacking'),
(29, '005.82', 'Kriptografi'),
(30, '005.913', 'Pemodelan Berorientasi Objek & Desain'),
(31, '006.22', 'Sistem Tertanam & Mikrokontroler'),
(32, '006.6', 'Grafika Komputer & Desain Multimedia'),
(33, '297', 'Agama Islam');

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=349;

--
-- AUTO_INCREMENT for table `hasil_pengujian`
--
ALTER TABLE `hasil_pengujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_ddc`
--
ALTER TABLE `kategori_ddc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

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
