-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 01, 2025 at 10:10 PM
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
-- Table structure for table `modern_new_order_items`
--

CREATE TABLE `modern_new_order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `modern_new_order_items`
--

INSERT INTO `modern_new_order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(5, 5, 1, 300.00, 1),
(6, 6, 1, 300.00, 1),
(7, 7, 1, 300.00, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modern_new_order_items`
--
ALTER TABLE `modern_new_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modern_new_order_items`
--
ALTER TABLE `modern_new_order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `modern_new_order_items`
--
ALTER TABLE `modern_new_order_items`
  ADD CONSTRAINT `modern_new_order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `modern_new_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `modern_new_order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `modern_new_products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
