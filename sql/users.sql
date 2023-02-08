-- phpMyAdmin SQL Dump
-- version 5.2.0-2.fc37
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 08, 2023 at 06:51 AM
-- Server version: 10.5.18-MariaDB
-- PHP Version: 8.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chilawsabha`
--

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `email` varchar(255) NOT NULL,
  `state` varchar(10) NOT NULL,
  `NIC` varchar(12) NOT NULL,
  `Role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`email`, `state`, `NIC`, `Role`) VALUES
('pubudu@gmail.com', 'Working', '200027000650', 'Admin'),
('hasala@gmail.com', 'Working', '200027000651', 'LibraryStaff'),
('tharindu@gmail.com', 'Working', '200027000620', 'ComplaintHandler'),
('sandaru@gmail.com', 'Working', '200027000630', 'LibraryStaff');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_code` int(11) DEFAULT NULL,
  `reset_code_time` datetime DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`name`, `email`, `password_hash`, `reset_code`, `reset_code_time`, `address`, `contact_no`, `type`) VALUES
('S.D.P.A. Satharasinghe', 'pubudu@gmail.com', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL, 'Karukkuwa,Madampe', '0711321395', 'Staff'),
('Hasala', 'hasala@gmail.com', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL, 'Karukkuwa,Madampe', '0721321395', 'Staff'),
('Tharindu', 'tharindu@gmail.com', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL, 'Karukkuwa,Madampe', '0741321395', 'Staff'),
('Sandaru', 'sandaru@gmail.com', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL, 'Karukkuwa,Madampe', '0761321395', 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`email`),

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;