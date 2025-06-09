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
-- Table structure for table `modern_new_orders`
--

CREATE TABLE `modern_new_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `modern_new_orders`
--

INSERT INTO `modern_new_orders` (`id`, `user_id`, `total_price`, `name`, `address`, `phone`, `payment_method`, `status`, `created_at`) VALUES
(5, 6, 300.00, 'Chethan.C', 'Belavadi Road', '9353892820', 'Credit/Debit Card', 'Processing', '2025-05-23 23:33:52'),
(6, 8, 300.00, 'shreyas', '607/A 2nd cross hebbal 2nd stage mysuru karnataka', '8197874042', 'Credit/Debit Card', 'Pending', '2025-05-29 22:34:42'),
(7, 9, 300.00, 'Abhishek B', 'Bhairaveshwara Temple Hinkal Mysore', '9148694117', 'Credit/Debit Card', 'Pending', '2025-06-01 03:29:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modern_new_orders`
--
ALTER TABLE `modern_new_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modern_new_orders`
--
ALTER TABLE `modern_new_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `modern_new_orders`
--
ALTER TABLE `modern_new_orders`
  ADD CONSTRAINT `modern_new_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `modern_new_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
