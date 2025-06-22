-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2025 at 12:54 PM
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
-- Database: `inventorysystem_db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_items`
--

CREATE TABLE `all_items` (
  `itemID` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_type` varchar(100) NOT NULL,
  `item_brand` varchar(100) NOT NULL,
  `item_img` longblob NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_items`
--

INSERT INTO `all_items` (`itemID`, `item_name`, `item_type`, `item_brand`, `item_img`, `quantity`, `price`, `category_id`, `status`, `date`, `description`) VALUES
(1, 'Mouse', 'Wireless Mouse', 'Firewolf', 0xffd8ffe000104a46494600010100000100010000ffdb0084000906070d0f10100d0d0d0d0d0e0d0f0d0d0d0d0d0d0f0d0d0e0d1511161617111f13181c2922191a251b15152231212529372e2e2e172b3f38332c4328392e2b010a0a0a0e0d0e1b100f182d251b222d2b2e2b2d2b372d372b2b2b2d2b2d2d2d2b2d372b2b2b2b2d2d2b2d2b2d2b2d372b2b2b2b2b2b2b372b2b2b2b2b2b2b2b2bffc000110800e100e103012200021101031101ffc4001c0001000203010101000000000000000000000405030708060102ffc40045100002020101040604061007010000000000010203041105061221071322314151617191b2147281a1a2c117233442525354626373828392a3b1b324323393d2d3e115ffc40014010100000000000000000000000000000000ffc40014110100000000000000000000000000000000ffda000c03010002110311003f00de20000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000785deee91e8c472a3120b2ef8eb194b8b871ea979392e726bc97b519fa44dbb3a60b128938d97478ad9c5e92853dda27e0e5cf9f825e9d4d459342f20336d5e9136edb26d66ba23f8bc6a6aae0be59272fa450e46f76d97dfb533ff006726c87bad1f72aa2aee801613df5daf28574ada39d174bb64ed59991d65bd638bd24f8b9a8f0f2f8cc918bbebb6e3ddb5331fc7b3acf7933ce463da97ec9328ac0f7fb0ba4fdb1535d7d95e6c35e71bea8573d3c94eb4b4f5b4cdb3ba9be189b45695eb4df15acf1ec6b8f4f1945f74e3e95cfcd2d4e7ac6acb8c0b2754a36d72957656d4a138bd25192f103a3c149ba1b71676346e7a2b60fabbe2bb95892e6bd0d34fe5d3c0bb0000000000000000000000000000000000000001f99cb44dbee49b7f201a8379721dd957d8f9eb64a11f890ecaf992f69e772a05a4db7cdf7be6fd641c940506640a3da727084a4bbd2d17adbd3eb3d1e5c4f3db717daa5eb87be8083ffcb71a5e44672e382e27abd5497932d28818ecca8fc12c8f2d5c24be62663400998d027d713063c49480f69d15673865d98edf66fa5cb4fd25725a7d194fd86d63476e1ddc3b4f13f3a56c1fed5335fd743788000000000000000000000000000000000000022ed59f0d17cbf069b65ec832515dbc52d31327f5172f6c5afac0d433442c8275841c802a72ca5da142b23283e49f8aef4fbd32eb2cabb80a0c7d9936dc2562e04d6a96bac977e9e83d26344cf93b36aaf1b1b220a4acbf4eb5b93717ac1b5cbc34d34e5f2ea7e71901369899a5dc7e6a47db4093baf7f06d1c27e7954c3f8e4a3f59d02737ec9b34cdc27e59b84fd99103a400000000000000000000000000000000000000153bd72d30b21fe8f4f6b4beb2d8a5df27fe06ff00556bf9b103555841c864cb08190c0abcb6565ccb0ca6565ac0932da92b6bab15d6a31c6d349a9b93b3b2d2e5a767937e2f5f419f18a8c67db9fae1ee96d8cc0b2acfc5ccfb0663bdf202262d9a64e33f2c9c67ecb6274d1cb919e9752fcaea5fd347518000000000000000000000000000000000000028f7d7ee1bff0073fde8178516fbfdc17fee7fbd003555acadc9913ee655e5480acca91596c89b9522b6c901f31a5db9fae3ee96d8d229a85a4a4ff09af996859e3480b6848c5912e47cae463c897202b9cbedb57eb6af7d1d5472927add52f3baa5f4d1d5a00000000000000000000000000000000000000a2df7fb82ff00dcff007a05e949be8b5c1c8f8b07ecb22c0d437c8a9cb996391229b326056e54cadb244aca995d64c0cf5cc9f8f32a21326d1601735ccfcdf3e460aac16cf9011f1b9e463af3c9c75edb628eae394f64c78b370a3f859d831f6e4411d5800000000000000000000000000000000000000a9dec5ae0e57a299bf673fa8b62bb78e1c587971f3c6c8d3d7d5c80d1593329732c2c32ad2932ec020e4ccafb2667c89902c9819a1325d3615919922ab00b8aad324ec2beab0ccec02cf756b73da5b3e2bf2fc297c91be127f3459d4c73174710e3db3b3e3fa79cbf869b25f51d3a00000000000000000000000000000000000000c79352b213adf74e3283f535a19001cc59ce507284f94a0dc24bca49e8d7b4a5cab4f79d2eec3962664b22317f07ce72b6124bb31bfbec837e6df6bd3c4fc99adf22c023df321d92325d321d9203f6a66785842d4c90981675d866eb4ae8586556fa40d8bd09e1bbb6c57668f4c4c7c9bdbf0529455297f35fb0e8c359f419bb33c5c39e75f171bb68b84eb8c96928e2453eafd5c4e5297a9a36600056edf8a75c7594e294f56ebb2caa5a284bc60d3f90f2556d4c29634b3e37e5fc1abe3529fc233b55c33e07d9e2d5f3f401efc14fbb13ae7575b54ec9c2d55d909596db6370714d3edb6d7265c00000000000000000000000000000000c528cbcc087b7b636367d13c4ca871d562f07a4e135dd38bf092f339c77eb70b686cb94a7284b230f5d619954758a8f94e2b9d6fd2fb2fc1f82e92b29b5f7320e462e468fb7a203906c647923a3b6dee061e43729e151c4db6e7543e0f2727e2dc34d5facf2f95d11552ff22b6bf446de2f793034c681236f7d8797e36ffe2aff00e24ec4e89f1a3fea553b7e3df38fbba01a6698ca52508a72949a8c6314e52949bd124977b372f467d11db3943376cd7d5d51e19d5b3e6bed96cbbd3b57dec7f33bdf8e8968fda6eeeed5388f5c6a28c6969a3b2154558d79759dfa7ad9eb28c5c85df3d40b647d2257559e2c9108bf16079cdf6de5c2c154c72eeea9dd29cab5d5d96392824a4fb29f771c7da796fb226c7fcb1fa1fc1b23fa709fbe99f777696d05871c0c4f844697933b64aea6b717255a8ad2725aeba4bbbc8d58fa3cdbebbf6659fefe2ffd806f4dccdeac0cd9594e2dfd6d915d74a3c1641a87663af692f167ab350f437bbfb4b67e4654f370a54d77d34c61376d137c509c9e9a424df352f98dba9ebcc0fa00000000000000000000000000000003e49e861716f9bffc4666868046954637413741c28083d40ea09dc2870a02075066a358f2fbdf2f224f0a1c280fa0200068001f343e80000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000007ffd9, 3, 25, 1, 'In Stock', '2025-06-21', 'Wireless, RGB');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_request`
--

CREATE TABLE `borrow_request` (
  `borrow_requestId` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contactNo` varchar(100) NOT NULL,
  `departmentID` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `borrow_date` int(11) NOT NULL,
  `return_date` int(11) NOT NULL,
  `extension` tinyint(1) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `urgent` tinyint(1) NOT NULL,
  `action` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `description`) VALUES
(1, 'Electronics', 'Testing');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentID` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `positionId` int(11) NOT NULL,
  `position_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_account`
--

CREATE TABLE `users_account` (
  `userID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `users_role` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contactNo` varchar(100) NOT NULL,
  `departmentID` int(11) NOT NULL,
  `positionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_account`
--

INSERT INTO `users_account` (`userID`, `username`, `password`, `users_role`, `email`, `contactNo`, `departmentID`, `positionId`) VALUES
(1, 'superadmin', '$2y$10$Cmj4vFBbQwd1x7E/Off.lOBAi2.UDhROsstvyYUAZEYmmap.OecSm', 'Admin', '', '', 0, 0);

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
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentID`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`positionId`);

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
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `borrow_request`
--
ALTER TABLE `borrow_request`
  MODIFY `borrow_requestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `positionId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_account`
--
ALTER TABLE `users_account`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
