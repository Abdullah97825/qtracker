-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2020 at 09:48 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qtracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `ssn` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`ssn`, `email`, `password`, `available`) VALUES
(2000, '2000@2000.com', '08f90c1a417155361a5c4b8d297e0d78', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `ssn` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `lname` varchar(25) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `position` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`ssn`, `name`, `lname`, `phone`, `address`, `position`) VALUES
(1, '1', '1', '1', '1', '1'),
(2, '2', '2', '2', '2', '2'),
(1000, 'mr', 'Wumpus', '123456', '123456', '1'),
(2000, 'Basil', 'Babir', '123456', '123456', '1'),
(3000, 'Ahmed', 'Ammar', '123456', '123456', '2'),
(4000, 'Qaysar', 'Kamal', '123456', '123456', '2');

-- --------------------------------------------------------

--
-- Table structure for table `er_a`
--

CREATE TABLE `er_a` (
  `patientID` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `er_b`
--

CREATE TABLE `er_b` (
  `patientID` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `er_c`
--

CREATE TABLE `er_c` (
  `patientID` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `er_d`
--

CREATE TABLE `er_d` (
  `patientID` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `er_doctors`
--

CREATE TABLE `er_doctors` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `er_doctors`
--

INSERT INTO `er_doctors` (`id`, `email`, `password`) VALUES
(1, '', ''),
(2, 'er@doc1', 'c4ca4238a0b923820dcc509a6f75849b');

-- --------------------------------------------------------

--
-- Table structure for table `er_q`
--

CREATE TABLE `er_q` (
  `patientID` int(11) NOT NULL,
  `category` varchar(1) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `er_queue`
--

CREATE TABLE `er_queue` (
  `a` int(11) NOT NULL,
  `b` int(11) NOT NULL,
  `c` int(11) NOT NULL,
  `d` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flag` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `er_receptionists`
--

CREATE TABLE `er_receptionists` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `er_receptionists`
--

INSERT INTO `er_receptionists` (`id`, `email`, `password`) VALUES
(1, 'er@rec1', 'c4ca4238a0b923820dcc509a6f75849b');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `user_closed` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `phone`, `address`, `user_closed`) VALUES
(1, 'Abdullah Sulayfani', '123456', '123456', ''),
(2, 'Zain Farhan', '123456', '123456', ''),
(3, '1', '1', '1', '1'),
(4, 'Syed Muneeb', '123456', '123456', ''),
(5, 'Shame Tatenda', '1235346', '1223456', 'yes'),
(6, 'Basil Kanwar', '2134', '12345', 'yes'),
(7, 'Ahmed El', '1234', '1234', 'yes'),
(8, 'Mawada Hamza', '1234', '1234', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `q2000`
--

CREATE TABLE `q2000` (
  `patientID` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arrivalTime` int(11) DEFAULT NULL,
  `serviceTime` int(11) DEFAULT NULL,
  `departureTime` int(11) DEFAULT NULL,
  `waitingTime` int(11) DEFAULT NULL,
  `tsb` int(11) DEFAULT NULL,
  `timeInSystem` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `q2000`
--

INSERT INTO `q2000` (`patientID`, `ts`, `arrivalTime`, `serviceTime`, `departureTime`, `waitingTime`, `tsb`, `timeInSystem`) VALUES
(4, '2020-06-12 20:11:05', 0, 0, 0, 0, 0, 0),
(5, '2020-06-12 20:11:14', 0, 0, 0, 0, 0, 0),
(6, '2020-06-12 20:11:17', 0, 0, 0, 0, 0, 0),
(7, '2020-06-12 20:11:22', 0, 0, 0, 0, 0, 0),
(8, '2020-06-12 20:11:26', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `patientID` int(11) NOT NULL,
  `doctor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`patientID`, `doctor`) VALUES
(4, 2000),
(5, 2000),
(6, 2000),
(7, 2000),
(8, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `receptionists`
--

CREATE TABLE `receptionists` (
  `ssn` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receptionists`
--

INSERT INTO `receptionists` (`ssn`, `email`, `password`) VALUES
(2, '2@2.com', 'c81e728d9d4c2f636f067f89cc14862c'),
(3000, '3000@3000.com', 'e93028bdc1aacdfb3687181f2031765d'),
(4000, '4000@4000.com', 'c4ca4238a0b923820dcc509a6f75849b');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(3, '1', '1'),
(4, '4@4.com', 'c4ca4238a0b923820dcc509a6f75849b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`ssn`),
  ADD KEY `ssn` (`ssn`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`ssn`);

--
-- Indexes for table `er_a`
--
ALTER TABLE `er_a`
  ADD PRIMARY KEY (`patientID`);

--
-- Indexes for table `er_b`
--
ALTER TABLE `er_b`
  ADD PRIMARY KEY (`patientID`);

--
-- Indexes for table `er_c`
--
ALTER TABLE `er_c`
  ADD PRIMARY KEY (`patientID`);

--
-- Indexes for table `er_d`
--
ALTER TABLE `er_d`
  ADD PRIMARY KEY (`patientID`);

--
-- Indexes for table `er_doctors`
--
ALTER TABLE `er_doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `er_q`
--
ALTER TABLE `er_q`
  ADD PRIMARY KEY (`patientID`);

--
-- Indexes for table `er_queue`
--
ALTER TABLE `er_queue`
  ADD PRIMARY KEY (`ts`);

--
-- Indexes for table `er_receptionists`
--
ALTER TABLE `er_receptionists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `q2000`
--
ALTER TABLE `q2000`
  ADD PRIMARY KEY (`patientID`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`patientID`),
  ADD KEY `patientID` (`patientID`),
  ADD KEY `doctor` (`doctor`);

--
-- Indexes for table `receptionists`
--
ALTER TABLE `receptionists`
  ADD PRIMARY KEY (`ssn`),
  ADD KEY `ssn` (`ssn`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `er_doctors`
--
ALTER TABLE `er_doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `er_receptionists`
--
ALTER TABLE `er_receptionists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`ssn`) REFERENCES `employees` (`ssn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `er_a`
--
ALTER TABLE `er_a`
  ADD CONSTRAINT `er_a_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `er_q` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `er_b`
--
ALTER TABLE `er_b`
  ADD CONSTRAINT `er_b_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `er_q` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `er_c`
--
ALTER TABLE `er_c`
  ADD CONSTRAINT `er_c_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `er_q` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `er_d`
--
ALTER TABLE `er_d`
  ADD CONSTRAINT `er_d_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `er_q` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `er_q`
--
ALTER TABLE `er_q`
  ADD CONSTRAINT `er_q_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `q2000`
--
ALTER TABLE `q2000`
  ADD CONSTRAINT `q2000_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `queue`
--
ALTER TABLE `queue`
  ADD CONSTRAINT `queue_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `queue_ibfk_2` FOREIGN KEY (`doctor`) REFERENCES `doctors` (`ssn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `receptionists`
--
ALTER TABLE `receptionists`
  ADD CONSTRAINT `receptionists_ibfk_1` FOREIGN KEY (`ssn`) REFERENCES `employees` (`ssn`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
