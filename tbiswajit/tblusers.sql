-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2025 at 03:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ciproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `firstName` varchar(200) DEFAULT NULL,
  `lastName` varchar(200) DEFAULT NULL,
  `emailId` varchar(200) DEFAULT NULL,
  `mobileNumber` char(12) DEFAULT NULL,
  `profileImage` varchar(200) DEFAULT NULL,
  `role_id` varchar(100) DEFAULT NULL,
  `scope_id` varchar(100) DEFAULT NULL,
  `state_id` varchar(100) DEFAULT NULL,
  `district_id` varchar(100) DEFAULT NULL,
  `userPassword` varchar(255) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT current_timestamp(),
  `isActive` int(1) DEFAULT NULL,
  `lastUpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `firstName`, `lastName`, `emailId`, `mobileNumber`, `profileImage`, `role_id`, `scope_id`, `state_id`, `district_id`, `userPassword`, `regDate`, `isActive`, `lastUpdationDate`) VALUES
(10, 'Vishal', 'Kumar', 'vishalswain2@gmail.com', '7008954356', '7008954356.png', '4', 'STATE', '24', '', 'Vishal@123', '2025-04-22 15:01:32', 1, '2025-04-23 12:17:05'),
(11, 'Nites', 'Kumar', 'niteskumar4@gmail.com', '9987633456', '9987633456.png', '4', 'STATE & DISTRICT', '28', '506', 'Nites@123', '2025-04-23 05:17:24', 1, NULL),
(16, 'Rakes', 'Kumar', 'rakeskumar4@gmail.com', '8876587678', '8876587678.png', '5', 'STATE & DISTRICT', '29', '530', 'Rakes@123', '2025-04-23 09:56:42', 1, NULL),
(17, 'Mahes', 'Kumar', 'maheskumar@gmail.com', '8976456789', '8976456789.png', '3', 'ALL INDIA', '', '', 'Mahes@123', '2025-04-23 10:03:50', 1, '2025-04-24 09:30:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
