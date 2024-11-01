-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2024 at 10:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diwasuwadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `passwordHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `passwordHash`) VALUES
('admin1', '$2y$10$qFW3bSGEYUXvLO8eX7UKYeG7EOmDsn2sjh3XEAUgQsTF6GO7Xmdjq');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announceID` int(11) NOT NULL,
  `announcement` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announceID`, `announcement`) VALUES
(1, 'first announcement');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointmentID` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nic` varchar(20) DEFAULT NULL,
  `docID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointmentID`, `date`, `time`, `status`, `username`, `nic`, `docID`) VALUES
(5, '2024-09-10', '10:00:00', 'booked', 'admin1', '8845223646', 1),
(6, '2024-09-10', '10:00:00', 'booked', 'admin1', '8845223646', 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `docID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `loginID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`docID`, `name`, `loginID`) VALUES
(1, 'strange', 16);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `loginID` int(11) NOT NULL,
  `passwordHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`loginID`, `passwordHash`) VALUES
(1, '$2y$10$vPt3K5Lrn9qBcp2mR7onWOa.mw87V7BIltFTWbuETTpbERUJSlH/q'),
(2, '$2y$10$Sw.ZZ5wjC.asslngx/HVFOkQFi3gBSLJyOlRZBub111ci2R9xVwNe'),
(3, '$2y$10$juVyL1/pCaXU0ou581VG4Oucxo.OzdmejdPOumDCadhcwv6LC1ina'),
(4, '$2y$10$IKm9y7jBBJpn/Vza3LePM.kN4xtiOtxMmoP7QFejuLj3zxReI42K.'),
(5, '$2y$10$38pZ4V7IJ.PKQBljNC1/Menya6tZAkyWx1Wrmtf0PvpDMmpnsbgFW'),
(6, '$2y$10$ICIheBYprqga1HuVRNARSO0fFX8ijHRLx9GcOiwmRYhL6bZ5sKlrK'),
(7, '$2y$10$EIljJLQAU0QlJcEAN4u4ReeLu7P1u6eMwdxN24Bgq8lpCPRt12Oia'),
(8, '$2y$10$KFwiH7bGHwTLB2YsDH3KBeVyL/.M7GO0MiCt8Lrwxjvg3dDzluaEK'),
(9, '$2y$10$f2JtSodZeienMKNCzhzsoexsXMBj6TdT67MV1QDm5tcbBIFXjJV2m'),
(10, '$2y$10$lAB9htJtUjmOOCc3Jwj80.ghYa6AMLXCbeMlECQ/rJ/eYDRuF0OMO'),
(11, '$2y$10$PKL/sQcw2ABLqQTNHU1Chu.XV/OJEQjy3f.xMI8qNWHb.omIj.0Gi'),
(12, '$2y$10$HvPt/RTZd8H9iLA00FWKKe/Bv2QZvGibxOxxssfe5zuBVR3V4RpTK'),
(13, '$2y$10$Mb8ls6O/6iLHC0JLWo/f3.Az.Aib6v/QB2GcZWyfts1ZNqAaSetR2'),
(14, '$2y$10$Zk37JnNqdlaX5VTSdzoZduoCNOawqPawBsgX/sHMVMEfPlqRLtjvG'),
(15, '$2y$10$2ItAz.rJNdJxQS4ZhKWDieOdj3HlXL.cK4O7CHBQZ5w1v/JGA.jlm'),
(16, '$2y$10$fneI2.BVeICVH1KBgCkVGuvs/gogVPdYAGS/7etBqMh7v0u78hsQu'),
(17, '$2y$10$I963no0s5/qBxUNdnn5zp.6OKp6e8zZCLwaAB.EMsi6J6coQYlycq'),
(18, '$2y$10$tSBBwX1/dMGurEn.SdxkIuf2sEK19aUBqJ.vpGo5yExOtybmGLlOq'),
(19, '$2y$10$D1yttCs2/rxFHqH3LhaExu.c6rcOWvLxs50njhQr9TLCQpzwdg45u');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msgID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `nic` varchar(20) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profilePhoto` varchar(255) DEFAULT NULL,
  `loginID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`nic`, `firstName`, `lastName`, `email`, `phone`, `address`, `profilePhoto`, `loginID`) VALUES
('0011223344', 'albert', 'einstein', 'albert@gmail.com', '0712410369', 'matale', 'mr.-robot-computer-wallpaper.jpg', 17),
('222222222', 'imeshi', 'punsara', 'imeshi@gmail.com', '01122330120', 'kandy', 'R (15).png', 15),
('78985465321', 'was', 'asd', 'asd@ff.com', '7845121523', 'agvsjcn;aihsdf', 'flat,750x,075,f-pad,750x1000,f8f8f8.jpg', 14),
('8845223646', 'Thomas', 'Shelby', 'shelby@gmail.com', '01201432012', 'kandy', 'R (8).png', 16);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payID` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `appointmentID` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payID`, `dateTime`, `amount`, `appointmentID`, `username`) VALUES
(1, '2024-09-09 21:32:32', 2000.00, 5, 'admin1');

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE `timeslots` (
  `slotID` int(11) NOT NULL,
  `timeSlot` time NOT NULL,
  `availability` varchar(20) DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`slotID`, `timeSlot`, `availability`) VALUES
(1, '09:00:00', 'available'),
(2, '10:00:00', 'available'),
(3, '11:00:00', 'unavailable'),
(4, '01:00:00', 'available'),
(5, '02:00:00', 'unavailable'),
(6, '03:00:00', 'available'),
(7, '13:44:00', 'available'),
(8, '17:45:00', 'available'),
(9, '17:45:00', 'available');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announceID`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointmentID`),
  ADD KEY `username` (`username`),
  ADD KEY `nic` (`nic`),
  ADD KEY `docID` (`docID`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`docID`),
  ADD KEY `loginID` (`loginID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`loginID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msgID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`nic`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `loginID` (`loginID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payID`),
  ADD KEY `appointmentID` (`appointmentID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD PRIMARY KEY (`slotID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `docID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `loginID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msgID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `timeslots`
--
ALTER TABLE `timeslots`
  MODIFY `slotID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`username`) REFERENCES `admin` (`username`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`nic`) REFERENCES `patient` (`nic`),
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`docID`) REFERENCES `doctor` (`docID`);

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`loginID`) REFERENCES `login` (`loginID`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`username`) REFERENCES `admin` (`username`);

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`loginID`) REFERENCES `login` (`loginID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`appointmentID`) REFERENCES `appointment` (`appointmentID`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`username`) REFERENCES `admin` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
