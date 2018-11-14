-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2015 at 10:41 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbonlinebookingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomers`
--

CREATE TABLE IF NOT EXISTS `tblcustomers` (
  `CustomerID` varchar(20) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `Age` int(11) NOT NULL,
  `EmailAdd` varchar(50) NOT NULL,
  `ContactNo` varchar(15) NOT NULL,
  `RoomType` varchar(30) NOT NULL,
  `RmRate` double NOT NULL,
  `CheckInDate` date NOT NULL,
  `CheckOutDate` date NOT NULL,
  `Children` int(11) NOT NULL,
  `Adult` int(11) NOT NULL,
  `Charge` double NOT NULL,
  `AdditionalPayment` double NOT NULL,
  `TotalPayment` double NOT NULL,
  `Downpayment` double NOT NULL,
  `Status` varchar(20) NOT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcustomers`
--

INSERT INTO `tblcustomers` (`CustomerID`, `Lastname`, `Firstname`, `Gender`, `Age`, `EmailAdd`, `ContactNo`, `RoomType`, `RmRate`, `CheckInDate`, `CheckOutDate`, `Children`, `Adult`, `Charge`, `AdditionalPayment`, `TotalPayment`, `Downpayment`, `Status`) VALUES
('CUST15-1', 'Alcer', 'Elena', 'Female', 20, 'alcerelena@gmail.com', '09121231234', 'Standard Room', 1500, '2015-10-07', '2015-10-10', 0, 0, 450, 0, 4500, 2250, 'Pending 50%'),
('CUST15-2', 'Makiling', 'Maria', 'Female', 25, 'mariamakiling@gmail.com', '-', 'Standard Room', 1500, '2015-10-07', '2015-10-10', 0, 0, 450, 0, 4500, 2250, 'Pending 50%'),
('CUST15-3', 'Sala', 'Maribel', 'Female', 19, 'sala_maribel@yahoo.com', '09121364799', 'Executive Suite', 2400, '2015-10-07', '2015-10-08', 2, 1, 450, 0, 2400, 1200, 'Pending 50%'),
('CUST15-4', 'Sala', 'Maribel', 'Female', 18, 'sala_maribel@yahoo.com', '097654688', 'Deluxe Room', 1900, '2015-10-08', '2015-10-09', 2, 1, 450, 0, 1900, 950, 'Pending 50%'),
('CUST15-5', 'Recla', 'Elaine', 'Female', 18, 'recla_elaine@yahoo.com', '098764686478', 'Deluxe Room', 1900, '2015-10-08', '2015-10-09', 2, 1, 450, 0, 1900, 0, 'Pending 50%'),
('CUST15-6', 'Sala', 'Maribel', 'Female', 18, 'sala_maribel@yahoo.com', '09121364799', 'Deluxe Room', 1900, '2015-10-14', '2015-10-15', 1, 1, 450, 0, 1900, 950, 'Pending 50%'),
('CUST15-7', 'Recla', 'Elaine Joy', 'Female', 18, 'recla_elaine@yahoo.com', '098764686478', 'Executive Suite', 2400, '2015-10-14', '2015-10-15', 2, 1, 450, 0, 2400, 1200, 'Pending 50%'),
('CUST15-8', 'Recla', 'Elaine Joy', 'Female', 18, 'recla_elaine@yahoo.com', '098764686478', 'Executive Suite', 2400, '2015-10-14', '2015-10-15', 2, 1, 450, 0, 2400, 1200, 'Pending 50%');

-- --------------------------------------------------------

--
-- Table structure for table `tblmenus`
--

CREATE TABLE IF NOT EXISTS `tblmenus` (
  `MenuID` varchar(10) NOT NULL,
  `CoffeeName` varchar(50) NOT NULL,
  `Size` varchar(15) NOT NULL,
  `Price` double NOT NULL,
  `Status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblmenus`
--

INSERT INTO `tblmenus` (`MenuID`, `CoffeeName`, `Size`, `Price`, `Status`) VALUES
('MID-001', 'Americano', 'regular', 60, 'available'),
('MID-001', 'Americano', 'small', 42, 'available'),
('MID-001', 'Americano', 'medium', 84, 'available'),
('MID-001', 'Americano', 'large', 108, 'available'),
('MID-002', 'Cappuccino', 'regular', 50, 'available'),
('MID-002', 'Cappuccino', 'small', 35, 'available'),
('MID-002', 'Cappuccino', 'large', 90, 'available'),
('MID-003', 'Choco Latte', 'regular', 70, 'available'),
('MID-003', 'Choco Latte', 'small', 49, 'available'),
('MID-003', 'Choco Latte', 'medium', 98, 'available'),
('MID-004', 'Creamy Latte', 'regular', 100, 'available'),
('MID-004', 'Creamy Latte', 'small', 70, 'available'),
('MID-004', 'Creamy Latte', 'medium', 140, 'available'),
('MID-004', 'Creamy Latte', 'large', 180, 'available'),
('MID-004', 'Creamy Latte', 'xlarge', 220, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `tblpurchase`
--

CREATE TABLE IF NOT EXISTS `tblpurchase` (
  `OrderNo` varchar(15) NOT NULL,
  `MenuID` varchar(15) NOT NULL,
  `MenuName` varchar(50) NOT NULL,
  `Size` varchar(10) NOT NULL,
  `Qty` int(11) NOT NULL,
  `ItemPrice` double NOT NULL,
  `VAT` float NOT NULL,
  `SellingPrice` double NOT NULL,
  `Total` double NOT NULL,
  `DatePurchased` date NOT NULL,
  `TimePurchased` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpurchase`
--

INSERT INTO `tblpurchase` (`OrderNo`, `MenuID`, `MenuName`, `Size`, `Qty`, `ItemPrice`, `VAT`, `SellingPrice`, `Total`, `DatePurchased`, `TimePurchased`) VALUES
('Ord#1', 'MID-001', 'Americano', 'small', 2, 31.5, 3.78, 35.28, 70.56, '2015-10-05', '17:23:17'),
('Ord#1', 'MID-002', 'Cappuccino', 'regular', 1, 50, 6, 56, 56, '2015-10-05', '17:23:17'),
('Ord#2', 'MID-003', 'Choco Latte', 'regular', 5, 70, 42, 78.4, 392, '2015-10-05', '18:00:29'),
('Ord#2', 'MID-001', 'Americano', 'regular', 5, 45, 27, 50.4, 252, '2015-10-05', '18:00:29'),
('Ord#3', 'MID-002', 'Cappuccino', 'regular', 2, 50, 6, 56, 112, '2015-10-05', '18:15:32'),
('Ord#4', 'MID-002', 'Cappuccino', 'regular', 2, 50, 6, 56, 112, '2015-10-06', '19:28:29'),
('Ord#4', 'MID-003', 'Choco Latte', 'medium', 3, 98, 11.76, 109.76, 329.28, '2015-10-06', '19:28:29'),
('Ord#5', 'MID-003', 'Choco Latte', 'small', 23, 49, 135.24, 54.88, 1262.24, '2015-10-07', '15:30:33'),
('Ord#5', 'MID-002', 'Cappuccino', 'small', 2, 35, 4.2, 39.2, 78.4, '2015-10-07', '15:30:33'),
('Ord#5', 'MID-003', 'Choco Latte', 'regular', 3, 70, 8.4, 78.4, 235.2, '2015-10-07', '15:30:33'),
('Ord#6', 'MID-003', 'Choco Latte', 'medium', 32, 98, 11.76, 109.76, 3512.32, '2015-10-07', '15:31:12'),
('Ord#7', 'MID-003', 'Choco Latte', 'small', 23, 49, 5.88, 54.88, 1262.24, '2015-10-07', '15:31:38'),
('Ord#8', 'MID-003', 'Choco Latte', 'small', 2, 49, 5.88, 54.88, 109.76, '2015-10-08', '01:05:46'),
('Ord#9', 'MID-002', 'Cappuccino', 'regular', 2, 50, 6, 56, 112, '2015-10-08', '01:07:31'),
('Ord#10', 'MID-002', 'Cappuccino', 'small', 23, 35, 4.2, 39.2, 901.6, '2015-10-08', '01:11:01'),
('Ord#10', 'MID-003', 'Choco Latte', 'small', 46, 49, 5.88, 54.88, 2524.48, '2015-10-08', '01:11:01'),
('Ord#11', 'MID-003', 'Choco Latte', 'small', 25, 49, 5.88, 54.88, 1372, '2015-10-08', '15:44:29'),
('Ord#11', 'MID-002', 'Cappuccino', 'small', 12, 35, 4.2, 39.2, 470.4, '2015-10-08', '15:44:29'),
('Ord#12', 'MID-002', 'Cappuccino', 'regular', 4, 50, 6, 56, 224, '0000-00-00', '00:00:00'),
('Ord#12', 'MID-003', 'Choco Latte', 'medium', 23, 98, 11.76, 109.76, 2524.48, '0000-00-00', '00:00:00'),
('Ord#12', 'MID-004', 'Creamy Latte', 'large', 5, 180, 21.6, 201.6, 1008, '0000-00-00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblrooms`
--

CREATE TABLE IF NOT EXISTS `tblrooms` (
  `Room_ID` int(10) NOT NULL,
  `RoomNo` varchar(10) NOT NULL,
  `FloorNo` int(11) NOT NULL,
  `RoomType` varchar(20) NOT NULL,
  `RoomRate` double NOT NULL,
  PRIMARY KEY (`RoomNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblrooms`
--

INSERT INTO `tblrooms` (`Room_ID`, `RoomNo`, `FloorNo`, `RoomType`, `RoomRate`) VALUES
(1, 'Rm#1', 1, 'Standard Room', 1500),
(10, 'Rm#10', 2, 'Standard Room', 1500),
(11, 'Rm#11', 3, 'Deluxe Room', 1900),
(12, 'Rm#12', 3, 'Deluxe Room', 1900),
(13, 'Rm#13', 3, 'Deluxe Room', 1900),
(14, 'Rm#14', 3, 'Deluxe Room', 1900),
(15, 'Rm#15', 3, 'Deluxe Room', 1900),
(16, 'Rm#16', 4, 'Deluxe Room', 1900),
(17, 'Rm#17', 4, 'Deluxe Room', 1900),
(18, 'Rm#18', 4, 'Deluxe Room', 1900),
(19, 'Rm#19', 4, 'Deluxe Room', 1900),
(2, 'Rm#2', 1, 'Standard Room', 1500),
(20, 'Rm#20', 4, 'Deluxe Room', 1900),
(21, 'Rm#21', 5, 'Junior Suite', 1500),
(22, 'Rm#22', 5, 'Junior Suite', 1500),
(23, 'Rm#23', 5, 'Junior Suite', 1500),
(24, 'Rm#24', 5, 'Junior Suite', 1500),
(25, 'Rm#25', 5, 'Junior Suite', 1500),
(26, 'Rm#26', 6, 'Junior Suite', 1500),
(27, 'Rm#27', 6, 'Junior Suite', 1500),
(28, 'Rm#28', 6, 'Junior Suite', 1500),
(29, 'Rm#29', 6, 'Junior Suite', 1500),
(3, 'Rm#3', 1, 'Standard Room', 1500),
(30, 'Rm#30', 6, 'Junior Suite', 1500),
(31, 'Rm#31', 7, 'Executive Suite', 2400),
(32, 'Rm#32', 7, 'Executive Suite', 2400),
(33, 'Rm#33', 7, 'Executive Suite', 2400),
(34, 'Rm#34', 7, 'Executive Suite', 2400),
(35, 'Rm#35', 7, 'Executive Suite', 2400),
(36, 'Rm#36', 8, 'Executive Suite', 2400),
(37, 'Rm#37', 8, 'Executive Suite', 2400),
(38, 'Rm#38', 8, 'Executive Suite', 2400),
(39, 'Rm#39', 8, 'Executive Suite', 2400),
(4, 'Rm#4', 1, 'Standard Room', 1500),
(40, 'Rm#40', 8, 'Executive Suite', 2400),
(5, 'Rm#5', 1, 'Standard Room', 1500),
(6, 'Rm#6', 2, 'Standard Room', 1500),
(7, 'Rm#7', 2, 'Standard Room', 1500),
(8, 'Rm#8', 2, 'Standard Room', 1500),
(9, 'Rm#9', 2, 'Standard Room', 1500);

-- --------------------------------------------------------

--
-- Table structure for table `tblroomstatus`
--

CREATE TABLE IF NOT EXISTS `tblroomstatus` (
  `RoomNo` varchar(10) NOT NULL,
  `FloorNo` int(11) NOT NULL,
  `RoomType` varchar(20) NOT NULL,
  `CustomerID` varchar(20) NOT NULL,
  `CheckIn` datetime NOT NULL,
  `CheckOut` datetime NOT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblroomstatus`
--

INSERT INTO `tblroomstatus` (`RoomNo`, `FloorNo`, `RoomType`, `CustomerID`, `CheckIn`, `CheckOut`, `Status`) VALUES
('Rm#1', 1, 'Standard Room', 'CUST15-1', '2015-10-07 00:00:00', '2015-10-10 00:00:00', 'Reserved'),
('Rm#2', 1, 'Standard Room', 'CUST15-2', '2015-10-07 00:00:00', '2015-10-10 00:00:00', 'Reserved'),
('Rm#31', 7, 'Executive Suite', 'CUST15-3', '2015-10-07 00:00:00', '2015-10-08 00:00:00', 'Reserved'),
('Rm#11', 3, 'Deluxe Room', 'CUST15-4', '2015-10-08 00:00:00', '2015-10-09 00:00:00', 'Reserved'),
('Rm#12', 3, 'Deluxe Room', 'CUST15-5', '2015-10-08 00:00:00', '2015-10-09 00:00:00', 'Reserved'),
('Rm#11', 3, 'Deluxe Room', 'CUST15-6', '2015-10-14 00:00:00', '2015-10-15 00:00:00', 'Reserved'),
('Rm#31', 7, 'Executive Suite', 'CUST15-7', '2015-10-14 00:00:00', '2015-10-15 00:00:00', 'Reserved'),
('Rm#32', 7, 'Executive Suite', 'CUST15-8', '2015-10-14 00:00:00', '2015-10-15 00:00:00', 'Reserved');

-- --------------------------------------------------------

--
-- Table structure for table `tblroomtype`
--

CREATE TABLE IF NOT EXISTS `tblroomtype` (
  `RoomType_ID` varchar(10) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Specification` varchar(500) NOT NULL,
  `MaxPerson` int(10) NOT NULL,
  `Rate` double NOT NULL,
  `Charge` double NOT NULL,
  `Img_Name` varchar(20) NOT NULL,
  `ImageLink` varchar(50) NOT NULL,
  `Status` varchar(10) NOT NULL,
  PRIMARY KEY (`RoomType_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblroomtype`
--

INSERT INTO `tblroomtype` (`RoomType_ID`, `Name`, `Specification`, `MaxPerson`, `Rate`, `Charge`, `Img_Name`, `ImageLink`, `Status`) VALUES
('RmType#1', 'Standard Room', '1 double bed, Hot and cold shower, Air-conditioned room, LCD Flat Screen TV w/ cable, RF card door entry lock system and Safety Deposit Box', 2, 1500, 450, 'stan01.jpg', 'Upload/stan01.jpg', 'available'),
('RmType#2', 'Deluxe Room', '2 double beds, Free daily breakfast, Hot and cold shower, Air-conditioned room, Mini refrigerator, LCD Flat Screen TV w/ cable, RF card door entry lock system and Safety Deposit Box', 2, 1900, 450, 'del01.jpg', 'Upload/del01.jpg', 'available'),
('RmType#3', 'Executive Suite', 'Free daily breakfast, 1 Queen-size bed, Hot and cold shower, Mini refrigerator, Microwave oven, Air-conditioned room, 2 separated LCD TV from bedroom and sitting area, RF card door entry lock system and Safety Deposit Box', 2, 2400, 450, 'ex03.jpg', 'Upload/ex03.jpg', 'available'),
('RmType#4', 'Junior Suite', 'Free daily breakfast, 1 Queen-size bed, Hot and cold shower, Mini refrigerator, Microwave oven, Air-conditioned room, 2 separated LCD TV from bedroom and sitting area, RF card door entry lock system and Safety Deposit Box', 2, 1500, 450, 'jr04.jpg', 'Upload/jr04.jpg', 'available'),
('RmType#5', 'King and Queen', 'Free Hugs and kisses\r\n-with love', 2, 2000.25, 450, 'ame01.jpg', 'Upload/ame01.jpg', 'removed');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE IF NOT EXISTS `tblusers` (
  `UserID` varchar(13) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `EmailAdd` varchar(50) NOT NULL,
  `PhoneNumber` varchar(11) NOT NULL,
  `Type` varchar(7) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `Status` varchar(2) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`UserID`, `Password`, `Lastname`, `Firstname`, `Gender`, `EmailAdd`, `PhoneNumber`, `Type`, `Category`, `Status`) VALUES
('15-001', '7298e4585586556a7bc3c6fd7077b9da', 'Alcer', 'Elena', 'Female', 'alcerelena@gmail.com', '09058299334', 'Manager', '-', 'a'),
('15-002', '7298e4585586556a7bc3c6fd7077b9da', 'Belle', 'Marie', 'Female', '', '', 'Staff', 'Front Desk', 'a'),
('15-003', '7298e4585586556a7bc3c6fd7077b9da', 'Ann', 'May', 'Female', '', '', 'Staff', 'Coffee Crew', 'a'),
('15-004', '7298e4585586556a7bc3c6fd7077b9da', 'Makiling', 'Maria', 'Female', '', '', 'Manager', '-', 'a'),
('15-005', '7298e4585586556a7bc3c6fd7077b9da', 'Rose', 'Bonita', 'Female', '', '', 'Staff', 'Front Desk', 'a'),
('15-006', '7298e4585586556a7bc3c6fd7077b9da', 'Lausa', 'Dexter', 'Male', '', '', 'Manager', '-', 'a'),
('administrator', '77eaf7a93b92816578f022cf13158807', 'Trator', 'Adminis', 'Male', 'administrator@email.com', '09121231231', 'Admin', '-', 'a');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
