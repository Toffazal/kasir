-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2023 at 07:48 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `no_pesanan` varchar(50) NOT NULL,
  `nama_pemesan` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `nama` varchar(500) NOT NULL,
  `harga` varchar(100) NOT NULL,
  `jumlah` varchar(50) NOT NULL,
  `waktu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `no_pesanan`, `nama_pemesan`, `username`, `nama`, `harga`, `jumlah`, `waktu`) VALUES
(1, '11012337', '', 'user', 'Nasi Goreng', '12000', '1', '11-01-23, 13:21'),
(2, '11012337', '', 'user', 'Gulai Asam', '15000', '1', '11-01-23, 13:21'),
(3, '31012350', '', 'toffazal', 'Mie Tiaw', '12000', '1', '31-01-23, 14:38'),
(4, '31012350', '', 'toffazal', 'Nasi Goreng', '12000', '1', '31-01-23, 14:38'),
(5, '31012350', '', 'toffazal', 'Rendang Daging', '15000', '1', '31-01-23, 14:38'),
(6, '31012355', '', 'toffazal', 'Gulai Asam', '15000', '1', '31-01-23, 14:53'),
(7, '31012355', '', 'toffazal', 'Mie Tiaw', '12000', '3', '31-01-23, 14:53'),
(8, '31012355', '', 'toffazal', 'Rendang Daging', '15000', '1', '31-01-23, 14:53'),
(9, '31012391', '', 'admin', 'Gulai Asam', '15000', '6', '31-01-23, 14:56'),
(10, '31012332', '', 'admin', 'Nasi Goreng', '12000', '3', '31-01-23, 16:30'),
(11, '31012332', '', 'admin', 'jus wortel', '10000', '3', '31-01-23, 16:30'),
(12, '31012332', '', 'admin', 'Mie Tiaw', '12000', '2', '31-01-23, 16:30'),
(13, '31012394', '', 'toffazal', 'Nasi Goreng', '12000', '1', '31-01-23, 14:41'),
(14, '01022372', 'wita', 'admin', 'Teh Manis', '5000', '4', '01-02-23, 13:36'),
(15, '01022372', 'wita', 'admin', 'Mie Tiaw', '12000', '2', '01-02-23, 13:36');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `slug` varchar(500) NOT NULL,
  `nama` varchar(500) NOT NULL,
  `harga` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `slug`, `nama`, `harga`) VALUES
(1, 'nasi-goreng', 'Nasi Goreng', '12000'),
(2, 'gulai-asam', 'Gulai Asam', '15000'),
(3, 'rendang-daging', 'Rendang Daging', '15000'),
(4, 'mie-tiaw', 'Mie Tiaw', '12000'),
(6, 'jus-jeruk', 'Jus Jeruk', '7000'),
(7, 'jus-wortel', 'jus wortel', '10000'),
(8, 'teh-manis', 'Teh Manis', '5000'),
(9, 'sambal', 'sambal', '5000'),
(10, 'milo-dingin', 'Milo Dingin', '8000');

-- --------------------------------------------------------

--
-- Table structure for table `menu_harian`
--

CREATE TABLE `menu_harian` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `harga` varchar(200) NOT NULL,
  `jumlah` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu_harian`
--

INSERT INTO `menu_harian` (`id`, `nama`, `harga`, `jumlah`) VALUES
(8, 'Gulai Asam', '15000', '20'),
(9, 'Nasi Goreng', '12000', '35'),
(10, 'Rendang Daging', '15000', '37'),
(11, 'Mie Tiaw', '12000', '42'),
(12, 'Jus Jeruk', '8000', '10'),
(13, 'jus wortel', '10000', '37'),
(14, 'Teh Manis', '5000', '36'),
(15, 'sambal', '5000', '30'),
(16, 'Milo Dingin', '8000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int(11) NOT NULL,
  `no_pesanan` varchar(50) NOT NULL,
  `nama_pemesan` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` varchar(50) NOT NULL,
  `waktu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `no_pesanan`, `nama_pemesan`, `username`, `nama`, `harga`, `jumlah`, `waktu`) VALUES
(3, '11012326', 'Ikhsan', 'user', 'Gulai Asam', 15000, '3', '11-01-23, 13:31'),
(5, '11012326', 'Ikhsan', 'user', 'Rendang Daging', 15000, '1', '11-01-23, 13:39');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `id` int(11) NOT NULL,
  `no_pesanan` varchar(40) NOT NULL,
  `nama_pemesan` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `waktu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `role`) VALUES
(1, '', 'admin', '$2y$10$mt8n399jJ3JqGHCnXT97LOEc8JqPghASFtxPMZ27Mx0S5Hy9..4lW', 'admin'),
(3, '', 'toffazal', '$2y$10$mt8n399jJ3JqGHCnXT97LOEc8JqPghASFtxPMZ27Mx0S5Hy9..4lW', 'karyawan'),
(4, '', 'angga', '$2y$10$yotwn2m2d4gKxRStehCM4e5wS7Vmr/HoS8KAQqTEd4tNaxUiQAPgS', 'karyawan'),
(5, '', 'nani', '$2y$10$HQDDETHDWo8tMHSUTSKO7Oe5qOLwyGO9eMv7Hb3duQlMfEvxr6vxm', 'karyawan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_harian`
--
ALTER TABLE `menu_harian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_pesanan` (`no_pesanan`);

--
-- Indexes for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `menu_harian`
--
ALTER TABLE `menu_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
