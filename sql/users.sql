-- phpMyAdmin SQL Dump
-- version 5.2.0-2.fc37
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 09, 2023 at 03:49 PM
-- Server version: 10.5.18-MariaDB
-- PHP Version: 8.1.15

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
  `user_id` int(11) NOT NULL,
  `state` varchar(10) NOT NULL,
  `NIC` varchar(12) NOT NULL,
  `Role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`user_id`, `state`, `NIC`, `Role`) VALUES
(1, 'Working', '200026700149', 'LibraryStaff'),
(2, 'Working', '200027000650', 'Admin'),
(3, 'Working', '200045678129', 'Complaint');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_code` int(11) DEFAULT NULL,
  `reset_code_time` datetime DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password_hash`, `reset_code`, `reset_code_time`, `address`, `contact_no`, `type`) VALUES
(1, 'D.M.H.P. Dissanayake', 'hasala@gmail.com', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL, 'Iranawila,Madampe', '0767256838', 'Staff'),
(2, 'S.D.P.A. Satharasinghe', 'pubudu@gmail.com', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL, 'Karukkuwa,Madampe', '0711321395', 'Staff'),
(3, 'W.M.S.M.Dissanayake', 'sadaru@gmail.com', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL, 'Karukkawa,Madampe', '0712286567', 'Staff'),
(4, 'R.M.T.S Sampath', 'tharindu@gmail.com', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL, 'Iranawila,Madampe', '0723345678', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;