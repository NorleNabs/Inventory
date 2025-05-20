-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 04:49 AM
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
-- Database: `inventorysystem_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_items`
--

CREATE TABLE `all_items` (
  `itemID` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_brand` varchar(255) NOT NULL,
  `item_img` longblob NOT NULL,
  `quantity` int(255) NOT NULL,
  `price` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `borrow_request`
--

CREATE TABLE `borrow_request` (
  `borrow_requestId` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contactNo` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date NOT NULL,
  `extension` tinyint(1) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `urgent` tinyint(1) NOT NULL,
  `action` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_request`
--

INSERT INTO `borrow_request` (`borrow_requestId`, `fullname`, `email`, `contactNo`, `item_name`, `quantity`, `category`, `borrow_date`, `return_date`, `extension`, `purpose`, `urgent`, `action`, `remarks`, `date`) VALUES
(1, 'Avocado', 'avocado@gmail.com', 9123435, 'Mouse', 1, 'Electronics', '2025-05-17', '2025-05-18', 0, 'personal', 0, 'Pending', '', '2025-05-16'),
(2, 'Avocado', 'avocado@gmail.com', 9123435, 'Mouse', 1, 'Electronics', '2025-05-17', '2025-05-18', 1, 'personal', 1, 'Pending', 'N/A', '2025-05-16'),
(3, 'Avocado', 'avocado@gmail.com', 9123435, 'Mouse', 1, 'Electronics', '2025-05-17', '2025-05-18', 1, 'personal', 1, 'Pending', 'N/A', '2025-05-16'),
(4, 'Norlito ', 'norlynabos3@gmail.com', 9241232, 'Keyboard', 1, 'Electronics', '2025-05-17', '2025-05-18', 1, 'project', 0, 'Pending', 'N/A', '2025-05-16'),
(5, 'Mica', 'mica@gmail.com', 929410432, 'Keyboard', 1, 'Electronics', '2025-05-17', '2025-05-18', 1, 'event', 0, 'Pending', 'N/A', '2025-05-16'),
(6, 'Avocado', 'avocado@gmail.com', 9123435, 'Office Table', 1, 'Office Supplies', '2025-05-20', '2025-05-20', 0, 'personal', 0, 'Pending', 'N/A', '2025-05-19'),
(7, 'Avocado', 'avocado@gmail.com', 9241232, 'Earphones', 1, 'Electronics', '2025-05-23', '2025-05-24', 0, 'project', 0, 'Pending', 'NA', '2025-05-20'),
(8, 'Avocado', 'avocado@gmail.com', 9123435, 'Earphones', 1, 'Electronics', '2025-05-23', '2025-05-24', 0, 'event', 0, 'Pending', 'N/A', '2025-05-20'),
(9, 'Norlito ', 'nabosnorlito@gmail.com', 9123435, 'Office Chair', 1, 'Office Supplies', '2025-05-23', '2025-05-30', 0, 'personal', 1, 'Pending', 'N/A', '2025-05-20');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_account`
--

CREATE TABLE `users_account` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `users_role` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_account`
--

INSERT INTO `users_account` (`userID`, `username`, `password`, `users_role`, `department`, `position`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_items`
--
ALTER TABLE `all_items`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `borrow_request`
--
ALTER TABLE `borrow_request`
  ADD PRIMARY KEY (`borrow_requestId`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `users_account`
--
ALTER TABLE `users_account`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_items`
--
ALTER TABLE `all_items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrow_request`
--
ALTER TABLE `borrow_request`
  MODIFY `borrow_requestId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_account`
--
ALTER TABLE `users_account`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
