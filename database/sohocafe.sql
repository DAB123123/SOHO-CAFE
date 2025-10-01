-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2025 at 11:47 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sohocafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '$2y$10$cuyldL3Man1KVl/F.bDY4uXEVtf.E1Ctw5mDjP.BcSVIEudYR7LES'),
(3, 'admin1@gmail.com', '$2y$10$3Zu3esgXuOCGOzgpthiUh.p.F1yqJ2a.RLqG1tu6NxAHLayyL6I0u');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'drinks',
  `temperature` varchar(10) DEFAULT NULL,
  `no_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `description`, `price`, `category`, `temperature`, `no_order`) VALUES
(1, 'Espresso', 'Strong and bold espresso shot made from freshly ground beans.', 60, 'drinks', 'hot', 3),
(2, 'Cappuccino', 'Espresso topped with steamed milk and foam.', 80, 'drinks', 'hot', 8),
(3, 'Iced Americano', 'Chilled espresso with water over ice.', 75, 'drinks', 'cold', 0),
(4, 'Café Latte', 'Smooth espresso with steamed milk.', 85, 'drinks', 'hot', 12),
(5, 'Caramel Macchiato', 'Layered espresso, milk, and caramel drizzle.', 95, 'drinks', 'hot', 6),
(6, 'Classic Waffles', 'Golden waffles served with maple syrup and butter.', 120, 'pastries', NULL, 4),
(7, 'Avocado Toast', 'Toasted sourdough topped with mashed avocado and chili flakes.', 150, 'food', NULL, 8),
(8, 'Egg Sandwich', 'Scrambled eggs with cheese on a brioche bun.', 110, 'food', NULL, 2),
(9, 'Croissant', 'Buttery and flaky freshly baked croissant.', 55, 'pastries', NULL, 5),
(10, 'Chocolate Muffin', 'Rich chocolate muffin with gooey center.', 60, 'pastries', NULL, 6),
(11, 'Blueberry Pancakes', 'Fluffy pancakes topped with fresh blueberries and syrup.', 140, 'pastries', NULL, 7),
(12, 'Caesar Salad', 'Crisp romaine with Caesar dressing, croutons, and parmesan.', 130, 'food', NULL, 1),
(13, 'Chicken Wrap', 'Grilled chicken, veggies, and sauce in a tortilla wrap.', 160, 'food', NULL, 1),
(14, 'Club Sandwich', 'Triple layered sandwich with ham, cheese, egg, and veggies.', 165, 'food', NULL, 2),
(15, 'Fruit Smoothie', 'Blended seasonal fruits with yogurt and honey.', 90, 'drinks', 'cold', 1),
(16, 'Iced Tea', 'Brewed black tea served over ice with lemon.', 60, 'drinks', 'cold', 1),
(17, 'Hot Chocolate', 'Creamy cocoa topped with whipped cream.', 85, 'drinks', 'hot', 4),
(18, 'Bottled Water', 'Mineral water (500ml).', 30, 'drinks', 'cold', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `order_id`, `message`, `is_read`, `created_at`) VALUES
(1, 28, 'New order placed by user.', 1, '2025-09-14 09:09:55'),
(2, 29, 'New order placed by user.', 1, '2025-09-14 09:18:08'),
(3, 30, 'New order placed by user.', 1, '2025-09-14 09:34:05'),
(4, 31, 'New order placed by user.', 1, '2025-09-14 09:34:31'),
(5, 32, 'New order placed by user.', 1, '2025-09-14 09:35:10'),
(6, 33, 'New order placed by user.', 1, '2025-09-14 09:36:31'),
(7, 34, 'New order placed by user.', 1, '2025-09-15 06:09:12'),
(8, 35, 'New order placed by user.', 1, '2025-09-15 06:18:16'),
(9, 36, 'New order placed by user.', 1, '2025-09-22 06:29:04'),
(10, 37, 'New order placed by user.', 1, '2025-09-22 06:42:09'),
(11, 38, 'New order placed by user.', 1, '2025-09-22 08:14:25'),
(12, 39, 'New order placed by user.', 1, '2025-09-22 08:33:40'),
(13, 41, 'New order placed by user.', 1, '2025-09-22 08:43:04'),
(14, 42, 'New order placed by user.', 1, '2025-09-22 08:49:57'),
(15, 43, 'New order placed by user.', 1, '2025-09-22 09:12:16');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `size_info` text DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_proof` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `id`, `name`, `description`, `size_info`, `status`, `address`, `amount`, `date`, `payment_proof`) VALUES
(1, 1, 'kael', 'Cappucino', NULL, 'food_otw', '3asdasd', 75, '2025-08-15 10:49:20', NULL),
(43, 15, 'awdawd', '1-Café Latte-85,1-Cappuccino-100,1-Caramel Macchiato-143,1-Espresso-105,2-Hot Chocolate-85,3-Classic Waffles-120,4-Croissant-55,5-Chocolate Muffin-60,6-Blueberry Pancakes-140,', '[{\"menu_id\":4,\"size\":\"short\",\"quantity\":1,\"item_name\":\"Café Latte\"},{\"menu_id\":2,\"size\":\"tall\",\"quantity\":1,\"item_name\":\"Cappuccino\"},{\"menu_id\":5,\"size\":\"grande\",\"quantity\":1,\"item_name\":\"Caramel Macchiato\"},{\"menu_id\":1,\"size\":\"venti\",\"quantity\":1,\"item_name\":\"Espresso\"},{\"menu_id\":17,\"size\":\"short\",\"quantity\":2,\"item_name\":\"Hot Chocolate\"}]', 'in_progress', 'TRY', 2323, '2025-09-22 09:12:16', 'payment_1758532336_15.png');

-- --------------------------------------------------------

--
-- Table structure for table `size_pricing`
--

CREATE TABLE `size_pricing` (
  `id` int(11) NOT NULL,
  `size_name` varchar(20) NOT NULL,
  `size_description` varchar(50) NOT NULL,
  `multiplier` decimal(3,2) NOT NULL DEFAULT 1.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `size_pricing`
--

INSERT INTO `size_pricing` (`id`, `size_name`, `size_description`, `multiplier`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'short', '8 oz', 1.00, 1, '2025-09-22 07:48:12', '2025-09-22 09:17:27'),
(2, 'tall', '12 oz', 1.25, 1, '2025-09-22 07:48:12', '2025-09-22 09:32:45'),
(3, 'grande', '16 oz', 1.50, 1, '2025-09-22 07:48:12', '2025-09-22 07:48:12'),
(4, 'venti', '20 oz', 1.75, 1, '2025-09-22 07:48:12', '2025-09-22 09:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id` int(100) NOT NULL,
  `list` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`id`, `list`) VALUES
(5, 'hello'),
(6, 'hello'),
(7, 'hello'),
(8, 'hello'),
(9, 'hello'),
(10, 'hello'),
(11, 'hello'),
(12, 'frfrv'),
(13, 'vdbvd'),
(14, 'vsrtsbdrtb'),
(15, 'vdsvsdv'),
(16, 'neeffvr'),
(17, 'rgdrhgdh'),
(18, 'sevsr'),
(19, 'sevsrgrdb'),
(20, ' dvdrv');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(7, 'daryll bobis', 'dar@gmail.com', '$2y$12$HnGo4wp8kUajBFKoDV2FY.EdVO3YY8gLa7q.FH9AMV1nx4e9E/pg6'),
(15, 'awdawd', 'awd@gmail.com', '$2y$12$SQyJYE2WJcTmV2NJuYKlZOKQBtA2F.uIj.V6DykbF7fyR9WXRd8zy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `size_pricing`
--
ALTER TABLE `size_pricing`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `size_name` (`size_name`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `size_pricing`
--
ALTER TABLE `size_pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
