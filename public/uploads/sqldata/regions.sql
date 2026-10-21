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
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(9) NOT NULL,
  `name` varchar(255) NOT NULL,
  `region_id` varchar(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `code`, `name`, `region_id`, `created_at`, `updated_at`) VALUES
(1, '010000000', 'REGION I (ILOCOS REGION)', '01', NULL, NULL),
(2, '020000000', 'REGION II (CAGAYAN VALLEY)', '02', NULL, NULL),
(3, '030000000', 'REGION III (CENTRAL LUZON)', '03', NULL, NULL),
(4, '040000000', 'REGION IV-A (CALABARZON)', '04', NULL, NULL),
(5, '170000000', 'MIMAROPA REGION', '17', NULL, NULL),
(6, '050000000', 'REGION V (BICOL REGION)', '05', NULL, NULL),
(7, '060000000', 'REGION VI (WESTERN VISAYAS)', '06', NULL, NULL),
(8, '070000000', 'REGION VII (CENTRAL VISAYAS)', '07', NULL, NULL),
(9, '080000000', 'REGION VIII (EASTERN VISAYAS)', '08', NULL, NULL),
(10, '090000000', 'REGION IX (ZAMBOANGA PENINSULA)', '09', NULL, NULL),
(11, '100000000', 'REGION X (NORTHERN MINDANAO)', '10', NULL, NULL),
(12, '110000000', 'REGION XI (DAVAO REGION)', '11', NULL, NULL),
(13, '120000000', 'REGION XII (SOCCSKSARGEN)', '12', NULL, NULL),
(14, '130000000', 'NATIONAL CAPITAL REGION (NCR)', '13', NULL, NULL),
(15, '140000000', 'CORDILLERA ADMINISTRATIVE REGION (CAR)', '14', NULL, NULL),
(16, '150000000', 'AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)', '15', NULL, NULL),
(17, '160000000', 'REGION XIII (Caraga)', '16', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regions_code_unique` (`code`),
  ADD KEY `regions_region_id_index` (`region_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
