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
-- Table structure for table `modern_new_payment_details`
--

CREATE TABLE `modern_new_payment_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `card_number` text NOT NULL,
  `expiry_date` varchar(10) NOT NULL,
  `cvv` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `modern_new_payment_details`
--

INSERT INTO `modern_new_payment_details` (`id`, `order_id`, `card_number`, `expiry_date`, `cvv`, `payment_method`, `created_at`) VALUES
(7, 5, 'tyog+K0zKr3WkK+M4rwkCuflM1fgiWNKNC39jVV6zDInUqwrLE/XtyqljdlAgBX1', 'QKUr/J5rHt', '1nuzERbM70Be7Vs1aott1kmfh9w9CjX/hieOKLQV95Y=', 'Credit/Debit Card', '2025-05-24 06:33:52'),
(8, 6, 'C/sox9oQUezOLGsT/HO9FAWt+mCCxb9dRj6kRIMgPKp+J277zKH1MH/+zi2N4GM9', 'HBkIT/Z9D7', 'UepUizW2R62f+xha8TCr4IbnYurZBkkysTh2fQqXUGE=', 'Credit/Debit Card', '2025-05-30 05:34:42'),
(9, 7, 'm+lmxONGNxheKBCyaK26AZ2O3ETiVXLomLsVb9YTofA+7cvpi42EwYqAYcoPT9CI', 'WioUNsCjLU', '+Rt7uzj3ROPpThqSxrWik121GOvpg/xuabyQjcsfXRY=', 'Credit/Debit Card', '2025-06-01 10:29:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modern_new_payment_details`
--
ALTER TABLE `modern_new_payment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modern_new_payment_details`
--
ALTER TABLE `modern_new_payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `modern_new_payment_details`
--
ALTER TABLE `modern_new_payment_details`
  ADD CONSTRAINT `modern_new_payment_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `modern_new_orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
