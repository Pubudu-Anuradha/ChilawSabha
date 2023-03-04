-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc37
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 04, 2023 at 12:41 PM
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
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `accession_no` int(11) NOT NULL,
  `category_code` int(11) NOT NULL,
  `isbn` varchar(30) NOT NULL,
  `title` varchar(100) NOT NULL,
  `state` int(11) NOT NULL,
  `author` varchar(100) NOT NULL,
  `pages` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `publisher` varchar(100) NOT NULL,
  `date_of_publication` date NOT NULL,
  `place_of_publication` varchar(200) NOT NULL,
  `recieved_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `recieved_method` varchar(100) NOT NULL,
  `recieved_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_requests`
--

CREATE TABLE `book_requests` (
  `request_id` int(11) NOT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `isbn` varchar(30) NOT NULL,
  `author` varchar(100) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `requested_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `accepted/rejected_by` int(11) DEFAULT NULL,
  `accepted/rejected_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_status`
--

CREATE TABLE `book_status` (
  `status_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_status`
--

INSERT INTO `book_status` (`status_id`, `status`) VALUES
(1, 'Available'),
(2, 'Lent'),
(3, 'De-Listed'),
(4, 'Lost'),
(5, 'Damaged');

-- --------------------------------------------------------

--
-- Table structure for table `category_codes`
--

CREATE TABLE `category_codes` (
  `category_id` int(11) NOT NULL,
  `category_code` varchar(10) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `complaint_id` int(11) NOT NULL,
  `complaint_category` int(11) NOT NULL,
  `complainer's_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `complaint_state` int(11) NOT NULL,
  `contact_no` varchar(12) NOT NULL,
  `address` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `handle_by` int(11) DEFAULT NULL,
  `complain_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `accept_time` timestamp NULL DEFAULT NULL,
  `resolve_time` timestamp NULL DEFAULT NULL,
  `resolve_description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaint_categories`
--

CREATE TABLE `complaint_categories` (
  `category_id` int(11) NOT NULL,
  `complaint_category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint_categories`
--

INSERT INTO `complaint_categories` (`category_id`, `complaint_category`) VALUES
(1, 'Category - 1'),
(2, 'Category - 2'),
(3, 'Category - 3');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_handler`
--

CREATE TABLE `complaint_handler` (
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaint_images`
--

CREATE TABLE `complaint_images` (
  `complaint_id` int(11) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaint_notes`
--

CREATE TABLE `complaint_notes` (
  `note_id` int(11) NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `handler_id` int(11) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `note_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaint_status`
--

CREATE TABLE `complaint_status` (
  `status_id` int(11) NOT NULL,
  `complaint_status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint_status`
--

INSERT INTO `complaint_status` (`status_id`, `complaint_status`) VALUES
(1, 'New'),
(2, 'Working'),
(3, 'Finished');

-- --------------------------------------------------------

--
-- Table structure for table `completed_books`
--

CREATE TABLE `completed_books` (
  `membership_id` int(11) NOT NULL,
  `accession_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us_persons`
--

CREATE TABLE `contact_us_persons` (
  `contact_id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damaged_action`
--

CREATE TABLE `damaged_action` (
  `action_id` int(11) NOT NULL,
  `de_list_action` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `damaged_action`
--

INSERT INTO `damaged_action` (`action_id`, `de_list_action`) VALUES
(1, 'Re-List'),
(2, 'Re-Listed');

-- --------------------------------------------------------

--
-- Table structure for table `damaged_books`
--

CREATE TABLE `damaged_books` (
  `damaged_id` int(11) NOT NULL,
  `accession_no` int(11) NOT NULL,
  `damaged_action` int(11) NOT NULL,
  `damaged_description` varchar(100) NOT NULL,
  `damaged_record_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `damage_recorded_by` int(11) NOT NULL,
  `re_list_description` varchar(100) DEFAULT NULL,
  `re_list_record_time` timestamp NULL DEFAULT NULL,
  `re_listed_recorded_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disabled_action`
--

CREATE TABLE `disabled_action` (
  `disabled_action_id` int(11) NOT NULL,
  `disabled_action` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disabled_action`
--

INSERT INTO `disabled_action` (`disabled_action_id`, `disabled_action`) VALUES
(1, 'Re-Enable'),
(2, 'Re-Enabled');

-- --------------------------------------------------------

--
-- Table structure for table `disabled_members`
--

CREATE TABLE `disabled_members` (
  `disabled_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `disable_description` varchar(100) NOT NULL,
  `disabled_by` int(11) NOT NULL,
  `disabled_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `disabled_action` int(11) NOT NULL,
  `re_enabled_desscription` varchar(100) DEFAULT NULL,
  `re_enabled_by` int(11) DEFAULT NULL,
  `re_enabled_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `disabled_action` int(11) NOT NULL,
  `re_enabled_by` int(11) DEFAULT NULL,
  `re_enabled_reason` varchar(255) DEFAULT NULL,
  `re_enabled_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `edit_members`
--

CREATE TABLE `edit_members` (
  `edit_member_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `contact_no` varchar(12) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `edited_by` int(11) NOT NULL,
  `edited_time` timestamp NOT NULL DEFAULT current_timestamp()
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
-- Table structure for table `emergency_categories`
--

CREATE TABLE `emergency_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contact`
--

CREATE TABLE `emergency_contact` (
  `place_id` int(11) NOT NULL,
  `contact_no` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_places`
--

CREATE TABLE `emergency_places` (
  `place_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `place_name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `post_id` int(11) NOT NULL,
  `event_status` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event status`
--

CREATE TABLE `event status` (
  `status_id` int(11) NOT NULL,
  `event_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event status`
--

INSERT INTO `event status` (`status_id`, `event_status`) VALUES
(1, 'Completed'),
(2, 'Ongoing'),
(3, 'Upcoming');

-- --------------------------------------------------------

--
-- Table structure for table `favourite_books`
--

CREATE TABLE `favourite_books` (
  `membership_id` int(11) NOT NULL,
  `accession_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `image_id` int(11) NOT NULL,
  `image_name` varchar(100) NOT NULL,
  `image_url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lend_recieve_books`
--

CREATE TABLE `lend_recieve_books` (
  `transaction_id` int(11) NOT NULL,
  `accession_no` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `lent_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `lent_by` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `extended_time` int(11) NOT NULL,
  `recieved_date` timestamp NULL DEFAULT NULL,
  `recieved_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_member`
--

CREATE TABLE `library_member` (
  `member_id` int(11) NOT NULL,
  `membership_id` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `no_of_books_lost` int(11) NOT NULL DEFAULT 0,
  `fine_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `no_of_books_damaged` int(11) NOT NULL DEFAULT 0,
  `added_by` int(11) NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library_member`
--

INSERT INTO `library_member` (`member_id`, `membership_id`, `user_id`, `no_of_books_lost`, `fine_amount`, `no_of_books_damaged`, `added_by`, `added_time`) VALUES
(1, '975', 2, 0, 0.00, 0, 3, '2023-03-04 10:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `library_staff`
--

CREATE TABLE `library_staff` (
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lost_books`
--

CREATE TABLE `lost_books` (
  `lost_id` int(11) NOT NULL,
  `accession_no` int(11) NOT NULL,
  `lost_description` varchar(100) NOT NULL,
  `lost_record_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `lost_record_by` int(11) NOT NULL,
  `found_description` varchar(100) DEFAULT NULL,
  `found_record_time` timestamp NULL DEFAULT NULL,
  `found_record_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_pages`
--

CREATE TABLE `other_pages` (
  `page_id` int(11) NOT NULL,
  `page _name` varchar(100) NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_content`
--

CREATE TABLE `page_content` (
  `content_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `content_name` varchar(100) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_image`
--

CREATE TABLE `page_image` (
  `page_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan_to_read_books`
--

CREATE TABLE `plan_to_read_books` (
  `membership_id` int(11) NOT NULL,
  `accession_no` int(11) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_type` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `short_description` varchar(1000) NOT NULL,
  `content` text NOT NULL,
  `views` int(11) NOT NULL,
  `visible_start_date` date DEFAULT NULL,
  `posted_by` int(11) NOT NULL,
  `posted_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_attachments`
--

CREATE TABLE `post_attachments` (
  `post_id` int(11) NOT NULL,
  `attachment_name` varchar(100) NOT NULL,
  `attachment_url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_contact`
--

CREATE TABLE `post_contact` (
  `post_id` int(11) NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `contact_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

CREATE TABLE `post_images` (
  `post_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_type`
--

CREATE TABLE `post_type` (
  `post_type_id` int(11) NOT NULL,
  `post_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_type`
--

INSERT INTO `post_type` (`post_type_id`, `post_type`) VALUES
(1, 'Announcements'),
(2, 'Services'),
(3, 'Projects'),
(4, 'Events');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `post_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `expected_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_status`
--

CREATE TABLE `project_status` (
  `status_id` int(11) NOT NULL,
  `project_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_status`
--

INSERT INTO `project_status` (`status_id`, `project_status`) VALUES
(1, 'Completed'),
(2, 'Ongoing'),
(3, 'Planned');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `post_id` int(11) NOT NULL,
  `service_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `category_id` int(11) NOT NULL,
  `service_category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`category_id`, `service_category`) VALUES
(1, 'Service - A'),
(2, 'Service - B'),
(3, 'Service - C');

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
(4, '200027000630', 3, 1, '2023-03-04 10:19:31');

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
(1, 'Website Admin'),
(2, 'Library Staff'),
(3, 'Complaint Handler'),
(4, 'Storage Manager');

-- --------------------------------------------------------

--
-- Table structure for table `storage_manager`
--

CREATE TABLE `storage_manager` (
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `contact_no` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_code` varchar(20) DEFAULT NULL,
  `reset_code_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `user_type`, `state_id`, `name`, `contact_no`, `address`, `password_hash`, `password_reset_code`, `reset_code_time`) VALUES
(1, 'pubudu@gmail.com', 1, 1, 'S.D.P.A. Satharasinghe', 761323251, 'Medagama Road, Karukkuwa, Madampe', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL),
(2, 'tharindu@gmail.com', 2, 1, 'Tharindu Sampath', 761323250, 'Pambala', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL),
(3, 'hasala@gmail.com', 1, 1, 'Hasala Dissanayake', 761323249, 'Marawila', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL),
(4, 'sandaru@gmail.com', 1, 1, 'Sandaru Dissanayake', 761323248, 'Uraliyagara', '$2y$10$YR1DnqQYUdyL.C4kNpBaP.PhO4sj2m3mibFrglzc95YVx2mFrQPz2', NULL, NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `website_admin`
--

CREATE TABLE `website_admin` (
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD UNIQUE KEY `accession_no` (`accession_no`),
  ADD KEY `book_category_code_fk` (`category_code`),
  ADD KEY `book_state_fk` (`state`),
  ADD KEY `book_recieved_by_fk` (`recieved_by`);

--
-- Indexes for table `book_requests`
--
ALTER TABLE `book_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `book_request_member_id_fk` (`membership_id`),
  ADD KEY `request_handled_by_fk` (`accepted/rejected_by`);

--
-- Indexes for table `book_status`
--
ALTER TABLE `book_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `category_codes`
--
ALTER TABLE `category_codes`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_code` (`category_code`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`complaint_id`),
  ADD KEY `complaint_category_fk` (`complaint_category`),
  ADD KEY `complaint_state_fk` (`complaint_state`),
  ADD KEY `handle_by_fk` (`handle_by`);

--
-- Indexes for table `complaint_categories`
--
ALTER TABLE `complaint_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `complaint_handler`
--
ALTER TABLE `complaint_handler`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `complaint_images`
--
ALTER TABLE `complaint_images`
  ADD PRIMARY KEY (`complaint_id`,`url`);

--
-- Indexes for table `complaint_notes`
--
ALTER TABLE `complaint_notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `note_complaint_id` (`complaint_id`),
  ADD KEY `note_handler_id` (`handler_id`);

--
-- Indexes for table `complaint_status`
--
ALTER TABLE `complaint_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `completed_books`
--
ALTER TABLE `completed_books`
  ADD PRIMARY KEY (`membership_id`,`accession_no`),
  ADD KEY `completed_boook_id_fk` (`accession_no`);

--
-- Indexes for table `contact_us_persons`
--
ALTER TABLE `contact_us_persons`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `contact_us_added_by` (`added_by`);

--
-- Indexes for table `damaged_action`
--
ALTER TABLE `damaged_action`
  ADD PRIMARY KEY (`action_id`);

--
-- Indexes for table `damaged_books`
--
ALTER TABLE `damaged_books`
  ADD PRIMARY KEY (`damaged_id`),
  ADD KEY `book_de_listed_by_fk` (`damage_recorded_by`),
  ADD KEY `book_re_listed_by_fk` (`re_listed_recorded_by`),
  ADD KEY `damaged_book_accession_no_fk` (`accession_no`),
  ADD KEY `damaged_book_action_fk` (`damaged_action`);

--
-- Indexes for table `disabled_action`
--
ALTER TABLE `disabled_action`
  ADD PRIMARY KEY (`disabled_action_id`);

--
-- Indexes for table `disabled_members`
--
ALTER TABLE `disabled_members`
  ADD PRIMARY KEY (`disabled_id`),
  ADD KEY `disabled_user_id_fk` (`user_id`),
  ADD KEY `member_disabled_by_fk` (`disabled_by`),
  ADD KEY `member_re_enabled_by_fk` (`re_enabled_by`),
  ADD KEY `member_disabled_action_fk` (`disabled_action`);

--
-- Indexes for table `disabled_staff`
--
ALTER TABLE `disabled_staff`
  ADD PRIMARY KEY (`disable_id`),
  ADD KEY `disabled_staff_user_id_fk` (`user_id`),
  ADD KEY `staff_disabled_action_fk` (`disabled_action`),
  ADD KEY `staff_disabled_by_fk` (`disabled_by`),
  ADD KEY `staff_disabled_re_enabled_by_fk` (`re_enabled_by`);

--
-- Indexes for table `edit_members`
--
ALTER TABLE `edit_members`
  ADD PRIMARY KEY (`edit_member_id`),
  ADD KEY `member_edited_by_fk` (`edited_by`);

--
-- Indexes for table `edit_staff`
--
ALTER TABLE `edit_staff`
  ADD PRIMARY KEY (`edit_staff_id`),
  ADD KEY `edit_staff-by_fk` (`edited_by`),
  ADD KEY `edit_staff_type_fk` (`staff_type`),
  ADD KEY `edit_staff_user_id_fk` (`user_id`);

--
-- Indexes for table `emergency_categories`
--
ALTER TABLE `emergency_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `emergency_category_added_by_fk` (`added_by`);

--
-- Indexes for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  ADD PRIMARY KEY (`place_id`,`contact_no`);

--
-- Indexes for table `emergency_places`
--
ALTER TABLE `emergency_places`
  ADD PRIMARY KEY (`place_id`),
  ADD KEY `emergency_place_category_id_fk` (`category_id`),
  ADD KEY `emergency_place_added_by_fk` (`added_by`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `event_status_fk` (`event_status`);

--
-- Indexes for table `event status`
--
ALTER TABLE `event status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `favourite_books`
--
ALTER TABLE `favourite_books`
  ADD PRIMARY KEY (`membership_id`,`accession_no`),
  ADD KEY `favourite_book_id` (`accession_no`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `lend_recieve_books`
--
ALTER TABLE `lend_recieve_books`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `lend_recieve_accession_no_fk` (`accession_no`),
  ADD KEY `lend_recieve_member_id_fk` (`membership_id`),
  ADD KEY `lend_recieve_lent_by_fk` (`lent_by`),
  ADD KEY `lend_recieve_recieved_by_fk` (`recieved_by`);

--
-- Indexes for table `library_member`
--
ALTER TABLE `library_member`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `membership_id` (`membership_id`),
  ADD KEY `library_member_added_by_fk` (`added_by`),
  ADD KEY `library_member_user_id_fk` (`user_id`);

--
-- Indexes for table `library_staff`
--
ALTER TABLE `library_staff`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `lost_books`
--
ALTER TABLE `lost_books`
  ADD PRIMARY KEY (`lost_id`),
  ADD KEY `lost_book_accession_no_fk` (`accession_no`),
  ADD KEY `lost_book_record_by_fk` (`lost_record_by`),
  ADD KEY `found_book_record_by_fk` (`found_record_by`);

--
-- Indexes for table `other_pages`
--
ALTER TABLE `other_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `page_content`
--
ALTER TABLE `page_content`
  ADD PRIMARY KEY (`content_id`),
  ADD KEY `content_page_id_fk` (`page_id`);

--
-- Indexes for table `page_image`
--
ALTER TABLE `page_image`
  ADD PRIMARY KEY (`page_id`,`image_id`),
  ADD KEY `page_image_id_fk` (`image_id`);

--
-- Indexes for table `plan_to_read_books`
--
ALTER TABLE `plan_to_read_books`
  ADD PRIMARY KEY (`membership_id`,`accession_no`),
  ADD KEY `planned_book_id_fk` (`accession_no`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `posted_by_fk` (`posted_by`),
  ADD KEY `post_type_fk` (`post_type`);

--
-- Indexes for table `post_attachments`
--
ALTER TABLE `post_attachments`
  ADD PRIMARY KEY (`post_id`,`attachment_url`);

--
-- Indexes for table `post_contact`
--
ALTER TABLE `post_contact`
  ADD PRIMARY KEY (`post_id`,`contact_no`);

--
-- Indexes for table `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`post_id`,`image_id`),
  ADD KEY `post_image_id_fk` (`image_id`);

--
-- Indexes for table `post_type`
--
ALTER TABLE `post_type`
  ADD PRIMARY KEY (`post_type_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `project_status_fk` (`status`);

--
-- Indexes for table `project_status`
--
ALTER TABLE `project_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `service_category_fk` (`service_category`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`category_id`);

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
-- Indexes for table `storage_manager`
--
ALTER TABLE `storage_manager`
  ADD PRIMARY KEY (`user_id`);

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
-- Indexes for table `website_admin`
--
ALTER TABLE `website_admin`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_requests`
--
ALTER TABLE `book_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_status`
--
ALTER TABLE `book_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category_codes`
--
ALTER TABLE `category_codes`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaint_categories`
--
ALTER TABLE `complaint_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `complaint_notes`
--
ALTER TABLE `complaint_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaint_status`
--
ALTER TABLE `complaint_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_us_persons`
--
ALTER TABLE `contact_us_persons`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damaged_action`
--
ALTER TABLE `damaged_action`
  MODIFY `action_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `damaged_books`
--
ALTER TABLE `damaged_books`
  MODIFY `damaged_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disabled_action`
--
ALTER TABLE `disabled_action`
  MODIFY `disabled_action_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `disabled_members`
--
ALTER TABLE `disabled_members`
  MODIFY `disabled_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disabled_staff`
--
ALTER TABLE `disabled_staff`
  MODIFY `disable_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edit_members`
--
ALTER TABLE `edit_members`
  MODIFY `edit_member_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edit_staff`
--
ALTER TABLE `edit_staff`
  MODIFY `edit_staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emergency_categories`
--
ALTER TABLE `emergency_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `emergency_places`
--
ALTER TABLE `emergency_places`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event status`
--
ALTER TABLE `event status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lend_recieve_books`
--
ALTER TABLE `lend_recieve_books`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_member`
--
ALTER TABLE `library_member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lost_books`
--
ALTER TABLE `lost_books`
  MODIFY `lost_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_pages`
--
ALTER TABLE `other_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_content`
--
ALTER TABLE `page_content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_type`
--
ALTER TABLE `post_type`
  MODIFY `post_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_status`
--
ALTER TABLE `project_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff_type`
--
ALTER TABLE `staff_type`
  MODIFY `staff_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcement_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `book_category_code_fk` FOREIGN KEY (`category_code`) REFERENCES `category_codes` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `book_recieved_by_fk` FOREIGN KEY (`recieved_by`) REFERENCES `library_staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `book_state_fk` FOREIGN KEY (`state`) REFERENCES `book_status` (`status_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `book_requests`
--
ALTER TABLE `book_requests`
  ADD CONSTRAINT `book_request_member_id_fk` FOREIGN KEY (`membership_id`) REFERENCES `library_member` (`member_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `request_handled_by_fk` FOREIGN KEY (`accepted/rejected_by`) REFERENCES `library_staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `complaint`
--
ALTER TABLE `complaint`
  ADD CONSTRAINT `complaint_category_fk` FOREIGN KEY (`complaint_category`) REFERENCES `complaint_categories` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `complaint_state_fk` FOREIGN KEY (`complaint_state`) REFERENCES `complaint_status` (`status_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `handle_by_fk` FOREIGN KEY (`handle_by`) REFERENCES `complaint_handler` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `complaint_handler`
--
ALTER TABLE `complaint_handler`
  ADD CONSTRAINT `complaint_handler_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `complaint_images`
--
ALTER TABLE `complaint_images`
  ADD CONSTRAINT `image_complaint_id_fk` FOREIGN KEY (`complaint_id`) REFERENCES `complaint` (`complaint_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `complaint_notes`
--
ALTER TABLE `complaint_notes`
  ADD CONSTRAINT `note_complaint_id` FOREIGN KEY (`complaint_id`) REFERENCES `complaint` (`complaint_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `note_handler_id` FOREIGN KEY (`handler_id`) REFERENCES `complaint_handler` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `completed_books`
--
ALTER TABLE `completed_books`
  ADD CONSTRAINT `completed_boook_id_fk` FOREIGN KEY (`accession_no`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `completed_member_id_fk` FOREIGN KEY (`membership_id`) REFERENCES `library_member` (`member_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `contact_us_persons`
--
ALTER TABLE `contact_us_persons`
  ADD CONSTRAINT `contact_us_added_by` FOREIGN KEY (`added_by`) REFERENCES `website_admin` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `damaged_books`
--
ALTER TABLE `damaged_books`
  ADD CONSTRAINT `book_de_listed_by_fk` FOREIGN KEY (`damage_recorded_by`) REFERENCES `library_staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `book_re_listed_by_fk` FOREIGN KEY (`re_listed_recorded_by`) REFERENCES `library_staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `damaged_book_accession_no_fk` FOREIGN KEY (`accession_no`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `damaged_book_action_fk` FOREIGN KEY (`damaged_action`) REFERENCES `damaged_action` (`action_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `disabled_members`
--
ALTER TABLE `disabled_members`
  ADD CONSTRAINT `disabled_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `library_member` (`member_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `member_disabled_action_fk` FOREIGN KEY (`disabled_action`) REFERENCES `disabled_action` (`disabled_action_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `member_disabled_by_fk` FOREIGN KEY (`disabled_by`) REFERENCES `library_staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `member_re_enabled_by_fk` FOREIGN KEY (`re_enabled_by`) REFERENCES `library_staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `disabled_staff`
--
ALTER TABLE `disabled_staff`
  ADD CONSTRAINT `disabled_staff_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `staff_disabled_action_fk` FOREIGN KEY (`disabled_action`) REFERENCES `disabled_action` (`disabled_action_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `staff_disabled_by_fk` FOREIGN KEY (`disabled_by`) REFERENCES `website_admin` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `staff_disabled_re_enabled_by_fk` FOREIGN KEY (`re_enabled_by`) REFERENCES `website_admin` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `edit_members`
--
ALTER TABLE `edit_members`
  ADD CONSTRAINT `member_edited_by_fk` FOREIGN KEY (`edited_by`) REFERENCES `library_staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `edit_staff`
--
ALTER TABLE `edit_staff`
  ADD CONSTRAINT `edit_staff-by_fk` FOREIGN KEY (`edited_by`) REFERENCES `website_admin` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `edit_staff_type_fk` FOREIGN KEY (`staff_type`) REFERENCES `staff_type` (`staff_type_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `edit_staff_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `emergency_categories`
--
ALTER TABLE `emergency_categories`
  ADD CONSTRAINT `emergency_category_added_by_fk` FOREIGN KEY (`added_by`) REFERENCES `website_admin` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  ADD CONSTRAINT `emergency_contact_place_id_fk` FOREIGN KEY (`place_id`) REFERENCES `emergency_places` (`place_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `emergency_places`
--
ALTER TABLE `emergency_places`
  ADD CONSTRAINT `emergency_place_added_by_fk` FOREIGN KEY (`added_by`) REFERENCES `website_admin` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `emergency_place_category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `emergency_categories` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `event_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `event_status_fk` FOREIGN KEY (`event_status`) REFERENCES `event status` (`status_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `favourite_books`
--
ALTER TABLE `favourite_books`
  ADD CONSTRAINT `favourite_book_id` FOREIGN KEY (`accession_no`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `favourite_member_id_fk` FOREIGN KEY (`membership_id`) REFERENCES `library_member` (`member_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lend_recieve_books`
--
ALTER TABLE `lend_recieve_books`
  ADD CONSTRAINT `lend_recieve_accession_no_fk` FOREIGN KEY (`accession_no`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `lend_recieve_lent_by_fk` FOREIGN KEY (`lent_by`) REFERENCES `library_staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `lend_recieve_member_id_fk` FOREIGN KEY (`membership_id`) REFERENCES `library_member` (`member_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `lend_recieve_recieved_by_fk` FOREIGN KEY (`recieved_by`) REFERENCES `library_staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `library_member`
--
ALTER TABLE `library_member`
  ADD CONSTRAINT `library_member_added_by_fk` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `library_member_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `library_staff`
--
ALTER TABLE `library_staff`
  ADD CONSTRAINT `library_staff_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lost_books`
--
ALTER TABLE `lost_books`
  ADD CONSTRAINT `found_book_record_by_fk` FOREIGN KEY (`found_record_by`) REFERENCES `library_staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `lost_book_accession_no_fk` FOREIGN KEY (`accession_no`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `lost_book_record_by_fk` FOREIGN KEY (`lost_record_by`) REFERENCES `library_staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `page_content`
--
ALTER TABLE `page_content`
  ADD CONSTRAINT `content_page_id_fk` FOREIGN KEY (`page_id`) REFERENCES `other_pages` (`page_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `page_image`
--
ALTER TABLE `page_image`
  ADD CONSTRAINT `page_image_id_fk` FOREIGN KEY (`image_id`) REFERENCES `image` (`image_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `page_image_page_id_fk` FOREIGN KEY (`page_id`) REFERENCES `other_pages` (`page_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `plan_to_read_books`
--
ALTER TABLE `plan_to_read_books`
  ADD CONSTRAINT `planned_book_id_fk` FOREIGN KEY (`accession_no`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `planned_member_id_fk` FOREIGN KEY (`membership_id`) REFERENCES `library_member` (`member_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_type_fk` FOREIGN KEY (`post_type`) REFERENCES `post_type` (`post_type_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `posted_by_fk` FOREIGN KEY (`posted_by`) REFERENCES `website_admin` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post_attachments`
--
ALTER TABLE `post_attachments`
  ADD CONSTRAINT `post_attachment_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post_contact`
--
ALTER TABLE `post_contact`
  ADD CONSTRAINT `post_contact_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `image_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_image_id_fk` FOREIGN KEY (`image_id`) REFERENCES `image` (`image_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `project_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `project_status_fk` FOREIGN KEY (`status`) REFERENCES `project_status` (`status_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `service_category_fk` FOREIGN KEY (`service_category`) REFERENCES `service_categories` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `service_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_added_by_fk` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `staff_type_fk` FOREIGN KEY (`staff_type`) REFERENCES `staff_type` (`staff_type_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `staff_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `storage_manager`
--
ALTER TABLE `storage_manager`
  ADD CONSTRAINT `storage_manager_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_states_fk` FOREIGN KEY (`state_id`) REFERENCES `user_state` (`state_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_type_fk` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`user_type_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `website_admin`
--
ALTER TABLE `website_admin`
  ADD CONSTRAINT `website_admin_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `staff` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
