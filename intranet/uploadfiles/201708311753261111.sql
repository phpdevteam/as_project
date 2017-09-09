-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 29, 2017 at 01:03 AM
-- Server version: 5.6.36-82.1-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `devnwzso_as`
--

-- --------------------------------------------------------

--
-- Table structure for table `as_trainingprogram`
--

CREATE TABLE `as_trainingprogram` (
  `_ID` int(11) NOT NULL,
  `_ProgramName` varchar(200) NOT NULL,
  `_ProgramDescr` text,
  `_ProgramRefID` varchar(50) NOT NULL,
  `_ProgramCatID` int(5) NOT NULL COMMENT 'as_trainingprogramcat ID',
  `_CreatedBy` enum('Admin','Trainer','Client','Script') NOT NULL COMMENT 'Admin only can create programs',
  `_IsFitnessExperience` enum('Y','N') DEFAULT NULL COMMENT 'This will show whether this program is fitness experience created by Trainer. ',
  `_FitnessExperienceStatus` enum('Pending','Approved','Rejected') DEFAULT NULL COMMENT 'Admin need to approve each Fitness experience submitted by Trainer',
  `_CommunityID` int(15) DEFAULT NULL COMMENT 'as_communities ID',
  `_VenueID` int(5) NOT NULL,
  `_TrainerID` int(5) NOT NULL,
  `_TrainingTypeID` int(5) NOT NULL,
  `_TrainingSubTypeID` int(5) NOT NULL,
  `_TrainingSubSubTypeID` int(5) NOT NULL,
  `_MaxPerson` int(3) NOT NULL,
  `_ImageName` varchar(100) NOT NULL COMMENT 'Image name which is showing in mobile',
  `_TotalAmount` decimal(11,2) NOT NULL,
  `_IPAddress` int(11) NOT NULL,
  `_Status` enum('1','2') NOT NULL,
  `_CreatedDateTime` datetime NOT NULL,
  `_UpdatedDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `as_trainingprogram`
--

INSERT INTO `as_trainingprogram` (`_ID`, `_ProgramName`, `_ProgramDescr`, `_ProgramRefID`, `_ProgramCatID`, `_CreatedBy`, `_IsFitnessExperience`, `_FitnessExperienceStatus`, `_CommunityID`, `_VenueID`, `_TrainerID`, `_TrainingTypeID`, `_TrainingSubTypeID`, `_TrainingSubSubTypeID`, `_MaxPerson`, `_ImageName`, `_TotalAmount`, `_IPAddress`, `_Status`, `_CreatedDateTime`, `_UpdatedDateTime`) VALUES
(1, 'program 1', 'demooooo', '123', 2, 'Admin', 'Y', 'Approved', 1, 1, 1, 1, 1, 1, 0, 'a.jpg', '500.00', 0, '1', '0000-00-00 00:00:00', '2017-08-17 22:03:04'),
(2, 'program 2', 'demo1', '23', 1, 'Admin', 'Y', 'Approved', 2, 2, 1, 2, 2, 2, 0, 'b.jpg', '200.00', 0, '1', '0000-00-00 00:00:00', '2017-08-18 13:48:59'),
(3, 'program3', 'demo2', '24', 1, 'Admin', 'Y', 'Approved', 3, 3, 1, 2, 1, 0, 0, 'c.jpg', '300.00', 0, '1', '0000-00-00 00:00:00', '2017-08-18 13:49:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `as_trainingprogram`
--
ALTER TABLE `as_trainingprogram`
  ADD PRIMARY KEY (`_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `as_trainingprogram`
--
ALTER TABLE `as_trainingprogram`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
