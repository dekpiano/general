-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2023 at 11:42 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skjacth_eoffice`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_dictation`
--

CREATE TABLE `tb_dictation` (
  `dicta_id` int(6) NOT NULL,
  `dicta_year` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `dicta_number` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `dicta_createdate` datetime NOT NULL,
  `dicta_title` text COLLATE utf8_unicode_ci NOT NULL,
  `dicta_file` text COLLATE utf8_unicode_ci NOT NULL,
  `dicta_recorder` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `dicta_view` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_dictation`
--

INSERT INTO `tb_dictation` (`dicta_id`, `dicta_year`, `dicta_number`, `dicta_createdate`, `dicta_title`, `dicta_file`, `dicta_recorder`, `dicta_view`) VALUES
(1, '2566', '2512', '2023-05-30 10:38:00', 'sdf', '1685417905_73418a93da6763fdf6d3.pdf', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_dictation`
--
ALTER TABLE `tb_dictation`
  ADD PRIMARY KEY (`dicta_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_dictation`
--
ALTER TABLE `tb_dictation`
  MODIFY `dicta_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
