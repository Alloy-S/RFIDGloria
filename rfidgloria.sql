-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20221113.0eded7bb43
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 03:29 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rfidgloria`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_kendaraan`
--

CREATE TABLE `db_kendaraan` (
  `id` int(11) NOT NULL,
  `jenis_mobil` varchar(50) NOT NULL,
  `plat_mobil` varchar(20) NOT NULL,
  `rfid_tag` varchar(50) NOT NULL,
  `driver` varchar(75) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `db_kendaraan`
--

INSERT INTO `db_kendaraan` (`id`, `jenis_mobil`, `plat_mobil`, `rfid_tag`, `driver`, `foto`) VALUES
(26, 'Avanza', 'N 1634 UE', 'coba2', 'Sukiman', 'N 1634 UE_65d1d4684cc096.97339597.jpg'),
(27, 'L300', 'H 995 TP', 'coba3', 'tukiman', 'H 995 TP_663a265729fef2.13429268.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id_history` int(11) NOT NULL,
  `student_id` varchar(12) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `grade` int(1) NOT NULL,
  `class` varchar(1) NOT NULL,
  `rfid_tag` varchar(12) NOT NULL,
  `plat_mobil` varchar(12) NOT NULL,
  `jenis_mobil` varchar(50) NOT NULL,
  `driver` varchar(100) NOT NULL,
  `tapin_date` datetime NOT NULL,
  `tapout_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id_history`, `student_id`, `nama_siswa`, `grade`, `class`, `rfid_tag`, `plat_mobil`, `jenis_mobil`, `driver`, `tapin_date`, `tapout_date`) VALUES
(4, 'c14210265', 'Alloysius Steven', 9, 'A', 'coba', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-02 23:34:28', '2024-02-02 23:34:37'),
(5, 'c14210265', 'Alloysius Steven', 9, 'A', '50:b7:e4:a4:', 'N 1675 UI', 'Avanza', 'Muhammad', '2024-02-02 23:35:22', '2024-02-03 11:09:38'),
(6, 'c14210265', 'Alloysius Steven', 9, 'A', 'coba', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-03 11:09:11', '2024-02-03 11:09:47'),
(7, 'c14210265', 'Alloysius Steven', 9, 'A', 'coba', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-03 11:10:50', '2024-02-03 11:11:01'),
(8, 'c14210265', 'Alloysius Steven', 9, 'A', 'coba', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-03 11:11:23', '2024-02-03 11:11:44'),
(9, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-04 23:13:32', '2024-02-04 23:15:04'),
(10, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-04 23:15:20', '2024-02-04 23:15:26'),
(11, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-04 23:15:34', '2024-02-04 23:16:51'),
(12, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-04 23:16:42', '2024-02-04 23:17:01'),
(13, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-05 13:02:28', '2024-02-05 13:20:17'),
(14, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-05 13:20:57', '2024-02-05 13:21:14'),
(15, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-05 13:25:57', '2024-02-05 13:26:41'),
(16, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-05 13:26:58', '2024-02-05 13:27:19'),
(17, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-05 13:28:34', '2024-02-05 13:29:03'),
(18, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-05 13:29:51', '2024-02-05 13:30:12'),
(19, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-05 13:30:52', '2024-02-05 13:31:05'),
(20, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-07 16:48:53', '2024-02-07 16:50:12'),
(21, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-07 22:54:39', '2024-02-09 21:28:13'),
(22, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-09 21:32:06', '2024-02-09 21:32:40'),
(23, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-09 21:32:52', '2024-02-09 21:33:07'),
(24, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-09 21:32:58', '2024-02-09 21:33:17'),
(25, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-09 21:38:41', '2024-02-09 21:39:54'),
(26, 'c14210134', 'Clarissa', 8, 'C', '50:b7:e4:a4:', 'N 1675 UI', 'Avanza', 'Muhammad', '2024-02-09 22:04:06', '2024-02-09 22:05:22'),
(27, 'c14210260', 'Gabriela', 6, 'a', 'e3:35:31:10:', 'L 1234 HH', 'L300', 'Agus', '2024-02-11 21:47:02', '2024-02-11 21:48:01'),
(28, 'c14210134', 'Clarissa', 8, 'C', '50:b7:e4:a4:', 'N 1675 UI', 'Avanza', 'Muhammad', '2024-02-11 21:52:09', '2024-02-11 21:52:53'),
(29, 'c14210265', 'Alloysius Steven', 9, 'A', '53:83:12:fe:', 'N 1678 IO', 'Veloz', 'Tukiman', '2024-02-11 21:57:43', '2024-02-11 21:58:04'),
(30, 'c14210265', 'Alloysius Steven', 6, 'A', 'coba2', 'N 1634 UE', 'Avanza', 'Sukiman', '2024-03-02 15:10:32', '2024-03-02 15:14:36'),
(31, 'c14210029', 'Yulius Paul', 8, 'A', 'coba2', 'N 1634 UE', 'Avanza', 'Sukiman', '2024-03-02 15:10:32', '2024-03-02 15:20:48'),
(32, 'c14210093', 'Christopher Rafael', 9, 'A', 'coba3', 'H 995 TP', 'L300', 'tukiman', '2024-05-07 20:25:08', '2024-05-07 20:25:19'),
(33, 'c14210025', 'Darrell', 8, 'A', 'coba3', 'H 995 TP', 'L300', 'tukiman', '2024-05-07 20:25:08', '2024-05-07 20:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `jam_operasional`
--

CREATE TABLE `jam_operasional` (
  `id` int(11) NOT NULL,
  `jam awal` time NOT NULL,
  `jam akhir` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jam_operasional`
--

INSERT INTO `jam_operasional` (`id`, `jam awal`, `jam akhir`) VALUES
(1, '10:30:00', '11:30:00'),
(2, '17:32:00', '18:35:00'),
(3, '12:30:00', '13:30:00'),
(4, '12:30:00', '22:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `live_view`
--

CREATE TABLE `live_view` (
  `id` int(11) NOT NULL,
  `UID` varchar(100) NOT NULL,
  `entry_date` datetime NOT NULL DEFAULT current_timestamp(),
  `murid_id` varchar(60) NOT NULL,
  `class` varchar(10) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `student_name` varchar(50) NOT NULL,
  `student_rfid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `murid`
--

CREATE TABLE `murid` (
  `id` int(11) NOT NULL,
  `student_id` varchar(60) NOT NULL,
  `name` varchar(50) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `class` varchar(10) NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `rfid_card` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `murid`
--

INSERT INTO `murid` (`id`, `student_id`, `name`, `grade`, `class`, `phone`, `rfid_card`) VALUES
(5, 'c14210025', 'Darrell', '8', 'A', NULL, ''),
(6, 'c14210029', 'Yulius Paul', '8', 'A', NULL, 'coba29'),
(7, 'c14210093', 'Christopher Rafael', '9', 'A', NULL, 'coba93');

-- --------------------------------------------------------

--
-- Table structure for table `murid_to_kendaraan`
--

CREATE TABLE `murid_to_kendaraan` (
  `id` int(11) NOT NULL,
  `id_murid` varchar(60) NOT NULL,
  `id_kendaraan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `murid_to_kendaraan`
--

INSERT INTO `murid_to_kendaraan` (`id`, `id_murid`, `id_kendaraan`) VALUES
(76, 'c14210029', 26),
(78, 'c14210093', 26),
(80, 'c14210093', 27),
(81, 'c14210025', 27);

-- --------------------------------------------------------

--
-- Table structure for table `sound`
--

CREATE TABLE `sound` (
  `id` int(11) NOT NULL,
  `student_id` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT 'default',
  `sound` varchar(60) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sound`
--

INSERT INTO `sound` (`id`, `student_id`, `title`, `sound`, `date`) VALUES
(13, 'c14210029', 'default', 'people2.wav', '2024-02-18'),
(14, 'c14210093', 'default', 'people1.wav', '2024-02-18'),
(15, 'c14210025', 'default', '65d1d572727eb7.71864299.wav', '2024-02-18'),
(23, 'c14210029', 'Monday', 'people3.wav', '2024-03-17'),
(30, 'c14210029', 'Tuesday', '663a254c18755.wav', '2024-05-07');

-- --------------------------------------------------------

--
-- Table structure for table `tb_entry`
--

CREATE TABLE `tb_entry` (
  `id` int(11) NOT NULL,
  `UID` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_entry`
--

INSERT INTO `tb_entry` (`id`, `UID`) VALUES
(1, ''),
(2, '50:b7:e4:a4:');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$54fm7Qgld.TpvQN8zk6REu41pLdN6gIxYm0oa1iAizDpXjw1Lmn5O');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_kendaraan`
--
ALTER TABLE `db_kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id_history`);

--
-- Indexes for table `jam_operasional`
--
ALTER TABLE `jam_operasional`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_view`
--
ALTER TABLE `live_view`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `murid`
--
ALTER TABLE `murid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_student_id` (`student_id`);

--
-- Indexes for table `murid_to_kendaraan`
--
ALTER TABLE `murid_to_kendaraan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_to_kendaraan` (`id_kendaraan`),
  ADD KEY `Fk_to_murid` (`id_murid`);

--
-- Indexes for table `sound`
--
ALTER TABLE `sound`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_entry`
--
ALTER TABLE `tb_entry`
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
-- AUTO_INCREMENT for table `db_kendaraan`
--
ALTER TABLE `db_kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `jam_operasional`
--
ALTER TABLE `jam_operasional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `live_view`
--
ALTER TABLE `live_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `murid`
--
ALTER TABLE `murid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `murid_to_kendaraan`
--
ALTER TABLE `murid_to_kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `sound`
--
ALTER TABLE `sound`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tb_entry`
--
ALTER TABLE `tb_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `murid_to_kendaraan`
--
ALTER TABLE `murid_to_kendaraan`
  ADD CONSTRAINT `FK_to_kendaraan` FOREIGN KEY (`id_kendaraan`) REFERENCES `db_kendaraan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk_to_murid` FOREIGN KEY (`id_murid`) REFERENCES `murid` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
