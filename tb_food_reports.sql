-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2025 at 01:48 PM
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
-- Database: `skjacth_general`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_food_reports`
--

CREATE TABLE `tb_food_reports` (
  `food_id` int(11) NOT NULL,
  `food_date` date NOT NULL,
  `food_meal` varchar(100) NOT NULL,
  `food_menu` text NOT NULL,
  `food_admin` varchar(50) NOT NULL,
  `food_images` text DEFAULT NULL COMMENT 'Store image paths as a JSON array',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_food_reports`
--

INSERT INTO `tb_food_reports` (`food_id`, `food_date`, `food_meal`, `food_menu`, `food_admin`, `food_images`, `created_at`) VALUES
(1, '2025-09-10', 'มื้อเย็น', '4534453', '', '[\"1757495725_861da981f21cf7878310.jpg\"]', '2025-09-10 09:15:25'),
(2, '2025-09-10', 'มื้อเย็น', 'werqwew', '', '[\"1757501121_e1080731ee079a9b7362.png\",\"1757501121_d828b3f0450842c3316e.png\"]', '2025-09-10 10:45:21'),
(3, '2025-09-10', 'มื้อเย็น', '123', '', '[\"1757502107_22543e3fffe1aa5f4727.png\",\"1757502107_7d885c4d285b719fd370.png\"]', '2025-09-10 11:01:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_food_reports`
--
ALTER TABLE `tb_food_reports`
  ADD PRIMARY KEY (`food_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_food_reports`
--
ALTER TABLE `tb_food_reports`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
