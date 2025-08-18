-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 27, 2024 at 04:38 PM
-- Server version: 5.7.39
-- PHP Version: 8.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk-topsis`
--

-- --------------------------------------------------------

--
-- Table structure for table `tab_kriteria`
--

CREATE TABLE `tab_kriteria` (
  `id_kriteria` varchar(10) NOT NULL,
  `nama_kriteria` varchar(50) NOT NULL,
  `bobot` float NOT NULL,
  `nilai` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `alias` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_kriteria`
--

INSERT INTO `tab_kriteria` (`id_kriteria`, `nama_kriteria`, `bobot`, `nilai`, `status`, `alias`) VALUES
('1', 'Kualitas', 5, 100, 'Sangat Baik', 'C1'),
('2', 'Harga', 4, 80, 'Baik', 'C2'),
('3', 'Waktu', 3, 60, 'Cukup Baik', 'C3'),
('4', 'Kuantitas', 2, 40, 'Cukup', 'C4'),
('5', 'Garansi', 1, 20, 'Standar', 'C5');

-- --------------------------------------------------------

--
-- Table structure for table `tab_perusahaan`
--

CREATE TABLE `tab_perusahaan` (
  `id_perusahaan` varchar(10) NOT NULL,
  `nama_perusahaan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_perusahaan`
--

INSERT INTO `tab_perusahaan` (`id_perusahaan`, `nama_perusahaan`) VALUES
('1', 'PT. Terpalindo Mitra Niaga'),
('2', 'PT. Biruni Geo Pratama'),
('3', 'CV Surya Putra Industri'),
('4', 'PT. GIS GLOBAL');

-- --------------------------------------------------------

--
-- Table structure for table `tab_topsis`
--

CREATE TABLE `tab_topsis` (
  `id_perusahaan` varchar(10) NOT NULL,
  `id_kriteria` varchar(10) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_topsis`
--

INSERT INTO `tab_topsis` (`id_perusahaan`, `id_kriteria`, `nilai`) VALUES
('1', '1', 100),
('1', '2', 100),
('1', '3', 80),
('1', '4', 100),
('1', '5', 60),
('2', '1', 100),
('2', '2', 80),
('2', '3', 80),
('2', '4', 80),
('2', '5', 80),
('3', '1', 60),
('3', '2', 60),
('3', '3', 80),
('3', '4', 100),
('3', '5', 60),
('4', '1', 100),
('4', '2', 80),
('4', '3', 100),
('4', '4', 60),
('4', '5', 100);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'arfian');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tab_kriteria`
--
ALTER TABLE `tab_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `tab_perusahaan`
--
ALTER TABLE `tab_perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`);

--
-- Indexes for table `tab_topsis`
--
ALTER TABLE `tab_topsis`
  ADD PRIMARY KEY (`id_perusahaan`,`id_kriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tab_topsis`
--
ALTER TABLE `tab_topsis`
  ADD CONSTRAINT `tab_topsis_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `tab_kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
