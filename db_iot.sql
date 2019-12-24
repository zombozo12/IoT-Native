-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2019 at 02:24 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_iot`
--
CREATE DATABASE IF NOT EXISTS `db_iot` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_iot`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_datalog`
--

CREATE TABLE `tbl_datalog` (
  `dat_id` int(10) NOT NULL,
  `usr_id` int(10) NOT NULL,
  `dat_kode` varchar(5) NOT NULL,
  `dat_soc` varchar(10) NOT NULL,
  `dat_iac` varchar(10) NOT NULL,
  `dat_vac` varchar(10) NOT NULL,
  `dat_powerac` varchar(10) NOT NULL,
  `dat_energiac` varchar(10) NOT NULL,
  `dat_ipv` varchar(10) NOT NULL,
  `dat_vpv` varchar(10) NOT NULL,
  `dat_tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_peminjaman`
--

CREATE TABLE `tbl_peminjaman` (
  `pmj_id` int(10) NOT NULL,
  `usr_id` int(10) NOT NULL,
  `pmj_nama` varchar(150) NOT NULL,
  `pmj_alamat` text NOT NULL,
  `pmj_kk` text NOT NULL,
  `pmj_foto` text NOT NULL,
  `pmj_ktp` text NOT NULL,
  `pmj_jenisalat` varchar(100) NOT NULL,
  `pmj_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pmj_updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `usr_id` int(10) NOT NULL,
  `usr_username` varchar(20) NOT NULL,
  `usr_password` varchar(32) NOT NULL,
  `usr_email` varchar(254) DEFAULT NULL,
  `usr_alamat` text NOT NULL,
  `usr_ktp` text NOT NULL,
  `usr_foto` text NOT NULL,
  `usr_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usr_updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `usr_role` enum('Super Admin','Operator') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`usr_id`, `usr_username`, `usr_password`, `usr_email`, `usr_alamat`, `usr_ktp`, `usr_foto`, `usr_created_at`, `usr_updated_at`, `usr_role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'asd@asd', 'asd', '', '', '2019-12-24 13:09:42', '0000-00-00 00:00:00', 'Super Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_datalog`
--
ALTER TABLE `tbl_datalog`
  ADD PRIMARY KEY (`dat_id`),
  ADD KEY `usr_id` (`usr_id`);

--
-- Indexes for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  ADD PRIMARY KEY (`pmj_id`),
  ADD KEY `usr_id` (`usr_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `usr_username` (`usr_username`),
  ADD UNIQUE KEY `usr_email` (`usr_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_datalog`
--
ALTER TABLE `tbl_datalog`
  MODIFY `dat_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  MODIFY `pmj_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `usr_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_datalog`
--
ALTER TABLE `tbl_datalog`
  ADD CONSTRAINT `tbl_datalog_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `tbl_user` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  ADD CONSTRAINT `tbl_peminjaman_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `tbl_user` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
