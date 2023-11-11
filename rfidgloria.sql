-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2023 at 09:55 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
  `murid` varchar(75) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `db_kendaraan`
--

INSERT INTO `db_kendaraan` (`id`, `jenis_mobil`, `plat_mobil`, `rfid_tag`, `driver`, `murid`, `foto`) VALUES
(4, 'Avanza', 'N 1675 UI', 'C14210151', 'Muhammad', 'Ericksen Julius', 'C142101512_6544a6fc730db6.59804373.png'),
(5, 'Avanza', 'N 1632 IE', '#C1421098', 'Dukiman', 'Poatan', 'C1421098_6544a3da7182e2.98987083.png'),
(6, 'Veloz', 'N 1678 IO', 'C5682738', 'Tukiman', 'Derick', 'C5682738_6544a89019f7c3.70769303.png');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `UID` varchar(20) NOT NULL,
  `entry_date` datetime NOT NULL DEFAULT current_timestamp(),
  `exit_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `UID`, `entry_date`, `exit_time`) VALUES
(53, '50:b7:e4:a4:', '2023-10-22 00:00:00', NULL),
(54, 'd2:8e:50:96:', '2023-10-22 00:00:00', NULL),
(55, '50:b7:e4:a4:', '2023-10-22 00:00:00', NULL),
(56, 'd2:8e:50:96:', '2023-10-22 21:27:19', NULL),
(57, '50:b7:e4:a4:', '2023-10-22 21:27:26', NULL),
(58, 'd2:8e:50:96:', '2023-10-22 21:54:01', NULL),
(59, '50:b7:e4:a4:', '2023-10-22 21:54:05', NULL),
(60, 'd2:8e:50:96:', '2023-10-22 21:54:15', NULL),
(61, 'ghjkgfaukgf', '2023-11-03 23:17:25', NULL),
(62, 'd2:8e:50:96:', '2023-11-03 23:21:29', NULL),
(63, '50:b7:e4:a4:', '2023-11-03 23:22:21', NULL);

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
(1, 'd2:8e:50:96:'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
