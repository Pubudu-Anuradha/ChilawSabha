-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc37
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2023 at 04:39 PM
-- Server version: 10.5.18-MariaDB
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `chilawsabha`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `post_id` int(11) NOT NULL,
  `ann_type_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `announcements_ibfk_1` (`ann_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements_edit`
--

CREATE TABLE IF NOT EXISTS `announcements_edit` (
  `announcements_edit_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `ann_type_id` int(11) DEFAULT NULL,
  `edited_by` int(11) NOT NULL,
  `edited_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`announcements_edit_id`),
  KEY `post_id` (`post_id`),
  KEY `ann_type_id` (`ann_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements_type`
--

CREATE TABLE IF NOT EXISTS `announcements_type` (
  `ann_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `ann_type` varchar(500) NOT NULL,
  PRIMARY KEY (`ann_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_type` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `short_description` varchar(1000) NOT NULL,
  `content` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `visible_start_date` date DEFAULT current_timestamp(),
  `posted_by` int(11) NOT NULL,
  `posted_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `pinned` tinyint(1) NOT NULL DEFAULT 0,
  `hidden` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`post_id`),
  KEY `posted_by_fk` (`posted_by`),
  KEY `post_type_fk` (`post_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_attachments`
--

CREATE TABLE IF NOT EXISTS `post_attachments` (
  `post_id` int(11) NOT NULL,
  `attach_file_name` varchar(255) NOT NULL,
  PRIMARY KEY (`post_id`,`attach_file_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_edit`
--

CREATE TABLE IF NOT EXISTS `post_edit` (
  `edit_post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `post_type` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `short_description` varchar(1000) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `visible_start_date` date DEFAULT NULL,
  `pinned` tinyint(1) DEFAULT NULL,
  `hidden` tinyint(1) DEFAULT NULL,
  `edited_by` int(11) NOT NULL,
  `edited_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`edit_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

CREATE TABLE IF NOT EXISTS `post_images` (
  `post_id` int(11) NOT NULL,
  `image_file_name` varchar(255) NOT NULL,
  PRIMARY KEY (`post_id`,`image_file_name`),
  KEY `post_image_id_fk` (`image_file_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_type`
--

CREATE TABLE IF NOT EXISTS `post_type` (
  `post_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_type` varchar(50) NOT NULL,
  PRIMARY KEY (`post_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcement_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`ann_type_id`) REFERENCES `announcements_type` (`ann_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `announcements_edit`
--
ALTER TABLE `announcements_edit`
  ADD CONSTRAINT `announcements_edit_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `announcements_edit_ibfk_2` FOREIGN KEY (`ann_type_id`) REFERENCES `announcements_type` (`ann_type_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_type_fk` FOREIGN KEY (`post_type`) REFERENCES `post_type` (`post_type_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `posted_by_fk` FOREIGN KEY (`posted_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post_attachments`
--
ALTER TABLE `post_attachments`
  ADD CONSTRAINT `post_attachment_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post_edit`
--
ALTER TABLE `post_edit`
  ADD CONSTRAINT `post_edit_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `image_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_images_ibfk_1` FOREIGN KEY (`image_file_name`) REFERENCES `file_original_names` (`name`) ON DELETE CASCADE;
COMMIT;
-- -- phpMyAdmin SQL Dump
-- -- version 5.2.1-1.fc37
-- -- https://www.phpmyadmin.net/
-- --
-- -- Host: localhost
-- -- Generation Time: Mar 10, 2023 at 05:57 PM
-- -- Server version: 10.5.18-MariaDB
-- -- PHP Version: 8.1.16

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00";


-- /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
-- /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
-- /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
-- /*!40101 SET NAMES utf8mb4 */;

-- --
-- -- Database: `chilawsabha`
-- --

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `post`
-- --

-- CREATE TABLE `post` (
--   `post_id` int(11) NOT NULL,
--   `post_type` int(11) NOT NULL,
--   `title` varchar(100) NOT NULL,
--   `short_description` varchar(1000) NOT NULL,
--   `content` text NOT NULL,
--   `views` int(11) NOT NULL DEFAULT 0,
--   `visible_start_date` date DEFAULT current_timestamp(),
--   `posted_by` int(11) NOT NULL,
--   `posted_time` timestamp NOT NULL DEFAULT current_timestamp()
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Table structure for table `post_attachments`
-- --

-- CREATE TABLE `post_attachments` (
--   `post_id` int(11) NOT NULL,
--   `attach_file_name` varchar(255) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `post_images`
-- --

-- CREATE TABLE `post_images` (
--   `post_id` int(11) NOT NULL,
--   `image_file_name` varchar(255) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Indexes for dumped tables
-- --

-- --
-- -- Indexes for table `post`
-- --
-- ALTER TABLE `post`
--   ADD PRIMARY KEY (`post_id`),
--   ADD KEY `posted_by_fk` (`posted_by`),
--   ADD KEY `post_type_fk` (`post_type`);

-- --
-- -- Indexes for table `post_attachments`
-- --
-- ALTER TABLE `post_attachments`
--   ADD PRIMARY KEY (`post_id`,`attach_file_name`);

-- --
-- -- Indexes for table `post_images`
-- --
-- ALTER TABLE `post_images`
--   ADD PRIMARY KEY (`post_id`,`image_file_name`),
--   ADD KEY `post_image_id_fk` (`image_file_name`);

-- --
-- -- AUTO_INCREMENT for dumped tables
-- --

-- --
-- -- AUTO_INCREMENT for table `post`
-- --
-- ALTER TABLE `post`
--   MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- --
-- -- Constraints for dumped tables
-- --

-- --
-- -- Constraints for table `post`
-- --
-- ALTER TABLE `post`
--   ADD CONSTRAINT `post_type_fk` FOREIGN KEY (`post_type`) REFERENCES `post_type` (`post_type_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
--   ADD CONSTRAINT `posted_by_fk` FOREIGN KEY (`posted_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

-- --
-- -- Constraints for table `post_attachments`
-- --
-- ALTER TABLE `post_attachments`
--   ADD CONSTRAINT `post_attachment_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

-- --
-- -- Constraints for table `post_images`
-- --
-- ALTER TABLE `post_images`
--   ADD CONSTRAINT `image_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
--   ADD CONSTRAINT `post_images_ibfk_1` FOREIGN KEY (`image_file_name`) REFERENCES `file_original_names` (`name`) ON DELETE CASCADE;
-- COMMIT;

-- /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
-- /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
-- /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
