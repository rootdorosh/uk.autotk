-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 04, 2020 at 10:49 PM
-- Server version: 5.7.27
-- PHP Version: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `autof_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tire_load_index`
--

CREATE TABLE `tire_load_index` (
  `id` int(11) UNSIGNED NOT NULL,
  `index` int(11) UNSIGNED NOT NULL,
  `pounds` int(11) UNSIGNED NOT NULL,
  `kilograms` int(11) UNSIGNED NOT NULL,
  `rank` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tire_load_index`
--

INSERT INTO `tire_load_index` (`id`, `index`, `pounds`, `kilograms`, `rank`) VALUES
(1, 70, 739, 335, 0),
(2, 71, 761, 345, 0),
(3, 72, 783, 355, 0),
(4, 73, 805, 365, 0),
(5, 74, 827, 375, 0),
(6, 75, 853, 387, 0),
(7, 76, 880, 400, 0),
(8, 77, 908, 412, 0),
(9, 78, 937, 425, 0),
(10, 79, 963, 437, 0),
(11, 80, 990, 450, 0),
(12, 81, 1019, 462, 0),
(13, 82, 1047, 475, 0),
(14, 83, 1074, 487, 0),
(15, 84, 1100, 500, 0),
(16, 85, 1135, 515, 0),
(17, 86, 1170, 530, 0),
(18, 87, 1202, 545, 0),
(19, 88, 1230, 560, 0),
(20, 89, 1280, 580, 0),
(21, 90, 1300, 600, 0),
(22, 91, 1356, 615, 0),
(23, 92, 1390, 630, 0),
(24, 93, 1430, 650, 0),
(25, 94, 1480, 670, 0),
(26, 95, 1520, 690, 0),
(27, 96, 1570, 710, 0),
(28, 97, 1610, 730, 0),
(29, 98, 1650, 750, 0),
(30, 99, 1709, 775, 0),
(31, 100, 1800, 800, 0),
(32, 101, 1819, 825, 0),
(33, 102, 1870, 850, 0),
(34, 103, 1929, 875, 0),
(35, 104, 2000, 900, 0),
(36, 105, 2039, 925, 0),
(37, 106, 2090, 950, 0),
(38, 107, 2150, 975, 0),
(39, 108, 2200, 1000, 0),
(40, 109, 2270, 1030, 0),
(41, 110, 2340, 1060, 0),
(42, 111, 2400, 1090, 0),
(43, 112, 2470, 1120, 0),
(44, 113, 2540, 1150, 0),
(45, 114, 2600, 1180, 0),
(46, 115, 2679, 1215, 0),
(47, 116, 2760, 1250, 0),
(48, 117, 2833, 1285, 0),
(49, 118, 2910, 1320, 0),
(50, 119, 3000, 1360, 0),
(51, 120, 3100, 1400, 0),
(52, 121, 3200, 1450, 0),
(53, 122, 3300, 1500, 0),
(54, 123, 3420, 1550, 0),
(55, 124, 3500, 1600, 0),
(56, 125, 3640, 1650, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tire_speed_index`
--

CREATE TABLE `tire_speed_index` (
  `id` int(11) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `mph` varchar(255) NOT NULL,
  `kmh` varchar(255) NOT NULL,
  `rank` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tire_load_index`
--
ALTER TABLE `tire_load_index`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tire_speed_index`
--
ALTER TABLE `tire_speed_index`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tire_load_index`
--
ALTER TABLE `tire_load_index`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tire_speed_index`
--
ALTER TABLE `tire_speed_index`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
