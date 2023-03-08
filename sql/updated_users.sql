-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc37
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 08, 2023 at 04:52 PM
-- Server version: 10.5.18-MariaDB
-- PHP Version: 8.1.16

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
-- Table structure for table `disabled_staff`
--

CREATE TABLE `disabled_staff` (
  `disable_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `disable_reason` varchar(255) NOT NULL,
  `disabled_by` int(11) NOT NULL,
  `disabled_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `re_enabled_by` int(11) DEFAULT NULL,
  `re_enabled_reason` varchar(255) DEFAULT NULL,
  `re_enabled_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `edit_staff`
--

CREATE TABLE `edit_staff` (
  `edit_staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `staff_type` int(11) DEFAULT NULL,
  `nic` varchar(15) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_no` int(11) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `edited_by` int(11) NOT NULL,
  `edited_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `user_id` int(11) NOT NULL,
  `nic` varchar(15) NOT NULL,
  `staff_type` int(11) NOT NULL,
  `added_by` int(11) DEFAULT NULL,
  `added_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`user_id`, `nic`, `staff_type`, `added_by`, `added_time`) VALUES
(1, '200027000650', 1, NULL, '2023-03-04 07:32:42'),
(3, '200027000640', 2, 1, '2023-03-04 10:18:22'),
(4, '200027000630', 3, 1, '2023-03-04 10:19:31'),

-- --------------------------------------------------------

--
-- Table structure for table `staff_type`
--

CREATE TABLE `staff_type` (
  `staff_type_id` int(11) NOT NULL,
  `staff_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_type`
--

INSERT INTO `staff_type` (`staff_type_id`, `staff_type`) VALUES
(0, 'All'),
(1, 'Website Admin'),
(2, 'Library Staff'),
(3, 'Complaint Handler');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_no` varchar(12) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_code` varchar(20) DEFAULT NULL,
  `reset_code_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `user_type`, `state_id`, `name`, `contact_no`, `address`, `password_hash`, `password_reset_code`, `reset_code_time`) VALUES
(1, 'pubudu@gmail.com', 1, 1, 'S.D.P.A. Satharasinghe', '0761323251', 'Medagama Road, Karukkuwa, Madampe', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL),
(2, 'tharindu@gmail.com', 2, 1, 'Tharindu Sampath', '0761323250', 'Pambala', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL),
(3, 'hasala@gmail.com', 1, 1, 'Hasala Dissanayake', '0761323249', 'Marawala', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL),
(4, 'sandaru@gmail.com', 1, 2, 'Sandaru Dissanayakee', '0761323248', 'Uraliyagara2', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL),

-- --------------------------------------------------------

--
-- Table structure for table `user_state`
--

CREATE TABLE `user_state` (
  `state_id` int(11) NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_state`
--

INSERT INTO `user_state` (`state_id`, `state`) VALUES
(1, 'Active'),
(2, 'Disabled');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `user_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type`) VALUES
(1, 'Staff'),
(2, 'Library Member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disabled_staff`
--
ALTER TABLE `disabled_staff`
  ADD PRIMARY KEY (`disable_id`),
  ADD KEY `disabled_staff_user_id_fk` (`user_id`),
  ADD KEY `staff_disabled_by_fk` (`disabled_by`),
  ADD KEY `staff_disabled_re_enabled_by_fk` (`re_enabled_by`);

--
-- Indexes for table `edit_staff`
--
ALTER TABLE `edit_staff`
  ADD PRIMARY KEY (`edit_staff_id`),
  ADD KEY `edit_staff-by_fk` (`edited_by`),
  ADD KEY `edit_staff_type_fk` (`staff_type`),
  ADD KEY `edit_staff_user_id_fk` (`user_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `nic` (`nic`),
  ADD KEY `staff_added_by_fk` (`added_by`),
  ADD KEY `staff_type_fk` (`staff_type`);

--
-- Indexes for table `staff_type`
--
ALTER TABLE `staff_type`
  ADD PRIMARY KEY (`staff_type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_type_fk` (`user_type`),
  ADD KEY `user_states_fk` (`state_id`);

--
-- Indexes for table `user_state`
--
ALTER TABLE `user_state`
  ADD PRIMARY KEY (`state_id`),
  ADD UNIQUE KEY `state` (`state`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disabled_staff`
--
ALTER TABLE `disabled_staff`
  MODIFY `disable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `edit_staff`
--
ALTER TABLE `edit_staff`
  MODIFY `edit_staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `staff_type`
--
ALTER TABLE `staff_type`
  MODIFY `staff_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_state`
--
ALTER TABLE `user_state`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disabled_staff`
--
ALTER TABLE `disabled_staff`
  ADD CONSTRAINT `disabled_staff_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `staff_disabled_by_fk` FOREIGN KEY (`disabled_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `staff_disabled_re_enabled_by_fk` FOREIGN KEY (`re_enabled_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `edit_staff`
--
ALTER TABLE `edit_staff`
  ADD CONSTRAINT `edit_staff-by_fk` FOREIGN KEY (`edited_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `edit_staff_type_fk` FOREIGN KEY (`staff_type`) REFERENCES `staff_type` (`staff_type_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `edit_staff_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_added_by_fk` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `staff_type_fk` FOREIGN KEY (`staff_type`) REFERENCES `staff_type` (`staff_type_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `staff_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_states_fk` FOREIGN KEY (`state_id`) REFERENCES `user_state` (`state_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_type_fk` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`user_type_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;