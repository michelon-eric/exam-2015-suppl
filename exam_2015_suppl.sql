-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2024 at 06:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exam_2015_suppl`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `BOK_Id` int(11) NOT NULL,
  `BOK_IdResource` int(11) NOT NULL,
  `BOK_IdUser` int(11) NOT NULL,
  `BOK_StartDate` date NOT NULL,
  `BOK_EndDate` date DEFAULT NULL,
  `BOK_ReturnDate` date DEFAULT NULL,
  `BOK_Status` enum('Active','Waiting','Returned','Cancelled') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CAT_Id` int(11) NOT NULL,
  `CAT_Name` varchar(255) NOT NULL,
  `CAT_Type` enum('Hardware','Software') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `centrecategories`
--

CREATE TABLE `centrecategories` (
  `CCA_IdCentre` int(11) NOT NULL,
  `CCA_IdCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `centres`
--

CREATE TABLE `centres` (
  `CTR_Id` int(11) NOT NULL,
  `CTR_Address` varchar(255) NOT NULL,
  `CTR_City` varchar(255) NOT NULL,
  `CTR_Phone` varchar(255) DEFAULT NULL,
  `CTR_Email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `RES_Id` int(11) NOT NULL,
  `RES_Name` varchar(255) NOT NULL,
  `RES_Description` text DEFAULT NULL,
  `RES_Status` enum('Available','Unavailable') DEFAULT NULL,
  `RES_IdCentre` int(11) NOT NULL,
  `RES_IdCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USR_Id` int(11) NOT NULL,
  `USR_FirstName` varchar(255) NOT NULL,
  `USR_LastName` varchar(255) NOT NULL,
  `USR_Email` varchar(255) NOT NULL,
  `USR_Password` varchar(255) NOT NULL,
  `USR_Role` enum('Regular','Moderator','Administrator') NOT NULL DEFAULT 'Regular',
  `USR_IdCentre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USR_Id`, `USR_FirstName`, `USR_LastName`, `USR_Email`, `USR_Password`, `USR_Role`, `USR_IdCentre`) VALUES
(19, 'Madoka', 'Kaname', 'madoka@kaname.com', '4af7ad02391e0bb50784686a25d4e189', 'Moderator', NULL),
(22, 'Mami', 'Tomoe', 'mami@tomoe.com', '89f0a2cee184327b43d8e3184305eda1', 'Regular', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`BOK_Id`),
  ADD KEY `BOK_IdResource` (`BOK_IdResource`),
  ADD KEY `BOK_IdUser` (`BOK_IdUser`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CAT_Id`);

--
-- Indexes for table `centrecategories`
--
ALTER TABLE `centrecategories`
  ADD PRIMARY KEY (`CCA_IdCentre`,`CCA_IdCategory`),
  ADD KEY `CCA_IdCategory` (`CCA_IdCategory`);

--
-- Indexes for table `centres`
--
ALTER TABLE `centres`
  ADD PRIMARY KEY (`CTR_Id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`RES_Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USR_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `BOK_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CAT_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `centres`
--
ALTER TABLE `centres`
  MODIFY `CTR_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `RES_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USR_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`BOK_IdResource`) REFERENCES `resources` (`RES_Id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`BOK_IdUser`) REFERENCES `users` (`USR_Id`);

--
-- Constraints for table `centrecategories`
--
ALTER TABLE `centrecategories`
  ADD CONSTRAINT `centrecategories_ibfk_1` FOREIGN KEY (`CCA_IdCentre`) REFERENCES `centres` (`CTR_Id`),
  ADD CONSTRAINT `centrecategories_ibfk_2` FOREIGN KEY (`CCA_IdCategory`) REFERENCES `categories` (`CAT_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
