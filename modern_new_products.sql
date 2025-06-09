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
-- Table structure for table `modern_new_products`
--

CREATE TABLE `modern_new_products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `modern_new_products`
--

INSERT INTO `modern_new_products` (`id`, `title`, `price`, `description`, `image_path`, `created_at`) VALUES
(1, 'Apple', 300.00, 'The Apple is a fresh, juicy, and sweet fruit known for its crisp texture and vibrant red color.', 'uploads/download.jpeg', '2025-05-20 07:41:18'),
(2, 'Orange', 200.00, 'The Orange is a refreshing citrus fruit with a tangy and sweet flavor. Known for its vibrant orange color, it is rich in vitamin C,', 'uploads/images (2).jpeg', '2025-05-20 07:41:55'),
(3, 'Paddy', 1800.00, 'Paddy, also known as unhusked rice, is a staple grain grown in lush fields. Rich in nutrients, it serves as the base for many rice varieties once processed. It is an essential crop for farmers and is widely used for its high carbohydrate content, providing energy and a variety of dishes worldwide. Our paddy is of high quality, sourced directly from trusted farmers, ensuring premium grain for your farming or milling needs.', 'uploads/harvest-summer-rice-paddy-field-background-photo.jpg', '2025-05-20 07:42:28'),
(4, 'Lemon', 50.00, 'Lemon is a tangy and refreshing citrus fruit known for its vibrant yellow color and zesty flavor. Rich in vitamin C, it is widely used for enhancing the taste of dishes, beverages, and desserts. Lemons are also great for their natural detoxifying properties, boosting your immune system, and adding a burst of freshness to your meals. Whether used in juices, salads, or garnishes, lemons are a must-have in every kitchen.', 'uploads/61wl85nUOUL.jpg', '2025-05-20 07:43:22'),
(5, 'Sugarcane', 600.00, 'Sugarcane is a tall, tropical grass known for its sweet, juicy stalks. It is the primary source for producing sugar and is also enjoyed as a fresh snack', 'uploads/images (3).jpeg', '2025-05-20 07:43:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modern_new_products`
--
ALTER TABLE `modern_new_products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modern_new_products`
--
ALTER TABLE `modern_new_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
