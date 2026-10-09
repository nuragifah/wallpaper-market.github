-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2026 at 12:58 PM
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
-- Database: `wallpaper_market`
--

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `ruangan` varchar(100) NOT NULL,
  `pesan` text DEFAULT NULL,
  `produk` text NOT NULL,
  `total_jumlah` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `nama`, `whatsapp`, `ruangan`, `pesan`, `produk`, `total_jumlah`, `total_harga`, `tanggal`) VALUES
(8, 'Nur Agifah', '08229283439', 'Ruang Keluarga', '', '1. Wallpaper Motif\n   Kode: WP-005\n   Nama: Hamparan Pasir\n   Jumlah: 1 m²\n   Harga: Rp 150.000 / m²\n\n', 1, 150000, '2026-10-07 10:38:43'),
(10, 'bambang', '08229283439', 'Kamar Tidur', '', '1. Panel Tekstur Kain\n   Kode: WV-08\n   Nama: Abu-abu Muda Tekstur Kain\n   Jumlah: 1 m²\n   Harga: Rp 120.000 / m²\n\n', 1, 120000, '2026-10-07 10:41:19'),
(11, 'Gifa', '08229283439', 'Kamar Tidur', '', '1. Wallpaper Motif\n   Kode: WP-013\n   Nama: Cokelat Krim\n   Jumlah: 1 m²\n   Harga: Rp 150.000 / m²\n\n', 1, 150000, '2026-10-07 10:46:46'),
(12, 'Gifa', '08229283439', 'Ruang Tamu', '', '1. Wallpaper Motif\n   Kode: WP-003\n   Nama: Elegansi Beige\n   Jumlah: 1 m²\n   Harga: Rp 150.000 / m²\n\n', 1, 150000, '2026-10-07 11:21:38'),
(13, 'Gifa', '08229283439', 'Ruang Tamu', '', '1. Marmer Gold\n   Kode: FM-06\n   Nama: Marmer Abu Gold\n   Jumlah: 1 m²\n   Harga: Rp 490.000 / m²\n\n', 1, 490000, '2026-10-07 11:30:35'),
(14, 'sisi', '08229283439', 'Kamar Tidur', '', '1. Panel Marmer\n   Kode: TB-09\n   Nama: Hitam Marmer Glossy\n   Jumlah: 1 m²\n   Harga: Rp 80.000 / m²\n\n', 1, 80000, '2026-10-07 13:17:38'),
(15, 'Nur Agifah', '08229283439', 'Kamar Tidur', '', '1. Wallpaper Motif\n   Kode: WP-013\n   Nama: Cokelat Krim\n   Jumlah: 1 m²\n   Harga: Rp 150.000 / m²\n\n2. Tekstur Kayu & Kain\n   Kode: FB-05\n   Nama: Krem Marmer Classic\n   Jumlah: 1 m²\n   Harga: Rp 90.000 / m²\n\n', 2, 240000, '2026-10-08 22:27:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
