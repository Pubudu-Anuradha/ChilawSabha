-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2023 at 10:10 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

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
-- Table structure for table `plantoread`
--

CREATE TABLE `plantoread` (
  `book_order` int(11) NOT NULL,
  `accNo` varchar(100) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Author` varchar(200) NOT NULL,
  `Publisher` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plantoread`
--

INSERT INTO `plantoread` (`book_order`, `accNo`, `Title`, `Author`, `Publisher`) VALUES
(6, '23', 'harry pott', 'vbweff', 'weeef'),
(3, '456', 'mbefg g', 'rertr', 'wghn'),
(4, '64', 'thw bjj', 'sgrg', 'wef'),
(2, '566', 'sddddd', 'dagedwg', 'sddb'),
(7, '3459', 'bhrrr', 'baqqqqq', 'gtqqqqq'),
(5, '25', 'ffffff', 'poqqqqq', 'lokkkkk'),
(1, '898', 'hqaaaa', 'rdtttt', 'bnmmmm');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
