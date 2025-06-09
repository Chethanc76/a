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
-- Table structure for table `modern_new_users`
--

CREATE TABLE `modern_new_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `modern_new_users`
--

INSERT INTO `modern_new_users` (`id`, `name`, `email`, `phone_number`, `password`, `address`, `role`, `created_at`) VALUES
(4, 'Admin', 'admin@gmail.com', '9988776655', '$2y$10$KBM6ps34obgEuasFJGqepuZ60rRlb4CoLl6R3AlhcqqW.SR.IEoMy', 'Bl', 'admin', '2025-05-24 06:12:09'),
(5, 'Mahesh', 'mahesh@gmail.com', '9900246855', '$2y$10$FUz32ixug8IfEz44OUMnL.wbUVel1xl2lilz6/R5m3TBkFDS.FE.a', 'Mysore', 'user', '2025-05-24 06:19:57'),
(6, 'Chethan.C', 'cchethanc76@gmail.com', '9353892820', '$2y$10$fdm.tuANzWJsPS9fo/riwerhwUo9HZUXteMGahEBBsor5g6.z0TmW', 'Belavadi Road', 'user', '2025-05-24 06:31:44'),
(7, 'shreyas', 'shreyasgowda1177@gmail.com', '6364578703', '$2y$10$QIgq9ZJXQierNBmPILFyPuYoQ4rmVaU8u8pZbdiImYFA45/Mvk7L.', '607/A 2nd cross hebbal 2nd stage mysuru karnataka', 'user', '2025-05-30 05:31:51'),
(8, 'shreyas', 'shreyasgowda17@gmail.com', '8197874042', '$2y$10$s26R5I9M.bN3cUVp/h1Na.RrZAdJjAMMwGFY/oeAPPATu2BzUpF5q', '607/A 2nd cross hebbal 2nd stage mysuru karnataka', 'user', '2025-05-30 05:32:58'),
(9, 'Abhishek B', 'abhisamrat83@gmail.com', '9148694117', '$2y$10$WIqwvjKvDYzOC0tkw9b7UeiiwmJC.OlIhq7Fg8geDt8umj1fL2u76', 'Bhairaveshwara Temple Hinkal Mysore', 'user', '2025-06-01 10:21:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modern_new_users`
--
ALTER TABLE `modern_new_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modern_new_users`
--
ALTER TABLE `modern_new_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
