-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2019 at 06:51 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `np_tire`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `productID` int(11) NOT NULL,
  `productName` varchar(50) DEFAULT NULL,
  `brandID` int(11) DEFAULT NULL,
  `modelName` varchar(20) DEFAULT NULL,
  `productSize` varchar(20) DEFAULT NULL,
  `productDetail` varchar(100) DEFAULT NULL,
  `productImg` varchar(50) DEFAULT NULL,
  `productCode` varchar(50) DEFAULT NULL,
  `unitType` int(1) DEFAULT NULL,
  `productUnit` int(10) DEFAULT NULL,
  `productTypeID` int(10) DEFAULT NULL,
  `name_nospace` varchar(50) NOT NULL,
  `supID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`productID`, `productName`, `brandID`, `modelName`, `productSize`, `productDetail`, `productImg`, `productCode`, `unitType`, `productUnit`, `productTypeID`, `name_nospace`, `supID`) VALUES
(9, 'ยาง TOYO H20 215/65R16', 5, 'H20', '215/65R16', '        ', '20190120155449.jpg', 'TY2156516H20', 1, 0, 1, 'ยางTOYOH20215/65R16', 0),
(11, 'ยาง YOKOHAMA AE50 195/55R15', 1, 'AE50', '195/55R15', '  ', '20190120155831.jpg', 'YK1955515AE50', 1, 0, 1, 'ยางYOKOHAMAAE50195/55R15', 0),
(12, 'ยาง Bridgestone H/T 684 205/70R15', 2, 'DUELER H/T 684', '205/70R15', ' ทดสอบ', '20190120160837.jpg', 'BS2057015DUELERH/T684', 1, 0, 1, 'ยางBridgestoneH/T684205/70R15', 0),
(13, 'ผ้าเบรค TRW', 7, NULL, NULL, '     เหมาะกับรถ เครื่องไม่เกิน 1500     ', '20190126125210.jpg', 'BP-001', 2, 0, 3, 'ผ้าเบรคTRW', 0),
(14, 'น้ำมันเครื่อง edge pickup 5w30 (4L)', 8, NULL, NULL, '', '20190322123611.jpg', 'OL-002', 3, 0, 5, 'น้ำมันเครื่องedgepickup5w30(4L)', 0),
(15, 'น้ำมันเครื่อง edge 5w30 c3 (4L)', 8, NULL, NULL, '', '20190322123557.jpg', 'OL-003', 3, 0, 5, 'น้ำมันเครื่องedge5w30c3(4L)', 0),
(16, 'ผ้าเบรค bendix DB1 ล้อหน้า', 10, NULL, NULL, '', '20190322123542.jpg', 'BP-004', 1, 0, 3, 'ผ้าเบรคbendixDB1ล้อหน้า', 0),
(17, 'ผ้าเบรค bendix DB2G ล้อหลัง', 10, NULL, NULL, '', '20190322123530.jpg', 'BP-005', 1, 0, 3, 'ผ้าเบรคbendixDB2Gล้อหลัง', 0),
(18, 'COSMIS-XT-005R ECO', 12, 'XT005R', '15', '', '20190322123112.jpg', 'CM15XT005R', 2, 0, 2, 'COSMIS-XT-005RECO', 0),
(19, 'Valenza mura', 14, 'Mura', '15', '', '20190322123816.jpg', 'VZ15Mura', 2, 0, 2, 'Valenzamura', 0),
(20, 'Continental MC5', 16, 'MC588V', '195/50R16', '', '20190322124310.jpg', 'CN1955016MC588V', 1, 0, 1, 'ContinentalMC5', 0),
(21, 'Deestone KACHA – R101', 17, 'R101', '185R14C', '', '20190322124901.jpg', 'DT18514R101', 1, 0, 1, 'DeestoneKACHA–R101', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`productID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
