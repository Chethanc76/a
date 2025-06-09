-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 01, 2025 at 10:09 PM
-- Server version: 10.6.21-MariaDB-cll-lve
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `organic`
--

-- --------------------------------------------------------

--
-- Table structure for table `modern_new_cart`
--

CREATE TABLE `modern_new_cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `modern_new_cart`
--

INSERT INTO `modern_new_cart` (`id`, `user_id`, `product_id`, `qty`, `added_at`) VALUES
(6, 6, 2, 1, '2025-05-24 07:20:35'),
(7, 5, 4, 1, '2025-05-27 05:14:27'),
(9, 6, 4, 1, '2025-05-30 08:01:08'),
(10, 6, 1, 1, '2025-05-30 08:04:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modern_new_cart`
--
ALTER TABLE `modern_new_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modern_new_cart`
--
ALTER TABLE `modern_new_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `modern_new_cart`
--
ALTER TABLE `modern_new_cart`
  ADD CONSTRAINT `modern_new_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `modern_new_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `modern_new_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `modern_new_products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
