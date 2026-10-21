-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 21, 2026 at 03:07 AM
-- Server version: 11.8.9-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u283105512_gad`
--

-- --------------------------------------------------------

--
-- Table structure for table `mabinay_brgys`
--

CREATE TABLE `mabinay_brgys` (
  `id` bigint(20) NOT NULL,
  `brgy_name` varchar(255) NOT NULL,
  `brgy_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mabinay_brgys`
--

INSERT INTO `mabinay_brgys` (`id`, `brgy_name`, `brgy_code`) VALUES
(1, 'Abis', '1'),
(2, 'Arebasore', '2'),
(3, 'Bagtic', '3'),
(4, 'Banban', '4'),
(5, 'Barras', '5'),
(6, 'Bato', '6'),
(7, 'Bugnay', '7'),
(8, 'Bulibulihan', '8'),
(9, 'Bulwang', '9'),
(10, 'Campanun-An', '10'),
(11, 'Canggohob', '11'),
(12, 'Cansal-ing', '12'),
(13, 'Dagbasan', '13'),
(14, 'Dahile', '14'),
(15, 'Hagtu', '15'),
(16, 'Himocdongon', '16'),
(17, 'Inapoy', '17'),
(18, 'Lamdas', '18'),
(19, 'Lumbangan', '19'),
(20, 'Luyang', '20'),
(21, 'Manlingay', '21'),
(22, 'Mayaposi', '22'),
(23, 'Napasu-An', '23'),
(24, 'New Namangka', '24'),
(25, 'Old Namangka', '25'),
(26, 'Pandanon', '26'),
(27, 'Paniabonan', '27'),
(28, 'Pantao', '28'),
(29, 'Poblacion', '29'),
(30, 'Samac', '30'),
(31, 'Tadlong', '31'),
(32, 'Tara', '32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mabinay_brgys`
--
ALTER TABLE `mabinay_brgys`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mabinay_brgys`
--
ALTER TABLE `mabinay_brgys`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
