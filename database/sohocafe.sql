-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2025 at 04:41 PM
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
(1, 'Espresso', 'Strong and bold espresso shot made from freshly ground beans.', 60, 'drinks', 'hot', 0),
(2, 'Cappuccino', 'Espresso topped with steamed milk and foam.', 80, 'drinks', 'hot', 1),
(3, 'Iced Americano', 'Chilled espresso with water over ice.', 75, 'drinks', 'cold', 0),
(4, 'Café Latte', 'Smooth espresso with steamed milk.', 85, 'drinks', 'hot', 3),
(5, 'Caramel Macchiato', 'Layered espresso, milk, and caramel drizzle.', 95, 'drinks', 'hot', 2),
(6, 'Classic Waffles', 'Golden waffles served with maple syrup and butter.', 120, 'pastries', NULL, 0),
(7, 'Avocado Toast', 'Toasted sourdough topped with mashed avocado and chili flakes.', 150, 'food', NULL, 7),
(8, 'Egg Sandwich', 'Scrambled eggs with cheese on a brioche bun.', 110, 'food', NULL, 1),
(9, 'Croissant', 'Buttery and flaky freshly baked croissant.', 55, 'pastries', NULL, 0),
(10, 'Chocolate Muffin', 'Rich chocolate muffin with gooey center.', 60, 'pastries', NULL, 0),
(11, 'Blueberry Pancakes', 'Fluffy pancakes topped with fresh blueberries and syrup.', 140, 'pastries', NULL, 0),
(12, 'Caesar Salad', 'Crisp romaine with Caesar dressing, croutons, and parmesan.', 130, 'food', NULL, 1),
(13, 'Chicken Wrap', 'Grilled chicken, veggies, and sauce in a tortilla wrap.', 160, 'food', NULL, 0),
(14, 'Club Sandwich', 'Triple layered sandwich with ham, cheese, egg, and veggies.', 165, 'food', NULL, 1),
(15, 'Fruit Smoothie', 'Blended seasonal fruits with yogurt and honey.', 90, 'drinks', 'cold', 1),
(16, 'Iced Tea', 'Brewed black tea served over ice with lemon.', 60, 'drinks', 'cold', 1),
(17, 'Hot Chocolate', 'Creamy cocoa topped with whipped cream.', 85, 'drinks', 'hot', 1),
(18, 'Bottled Water', 'Mineral water (500ml).', 30, 'drinks', 'cold', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_proof` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `id`, `name`, `description`, `status`, `address`, `amount`, `date`, `payment_proof`) VALUES
(1, 1, 'kael', 'Cappucino', 'food_otw', '3asdasd', 75, '2025-08-15 10:49:20', NULL),
(22, 12, 'user', '1-Café Latte-85,', 'Cancelled', 'awdawd', 85, '2025-08-31 02:31:43', NULL),
(23, 12, 'user', '1-Café Latte-85,', 'food_otw', 'awdaw', 85, '2025-09-02 01:22:22', NULL),
(24, 12, 'user', '1-Cappuccino-80,', 'delivered', 'awdwa', 80, '2025-09-02 01:48:21', NULL),
(25, 12, 'user', '1-Café Latte-85,', 'in_progress', 'yse', 85, '2025-09-02 13:43:34', ''),
(26, 12, 'user', '1-Caramel Macchiato-95,', 'in_progress', 'adwadw', 95, '2025-09-02 13:44:54', 'payment_1756820694_12.jpg'),
(27, 12, 'user', '1-Caramel Macchiato-95,7-Avocado Toast-150,1-Egg Sandwich-110,1-Caesar Salad-130,1-Club Sandwich-165,1-Fruit Smoothie-90,1-Iced Tea-60,1-Hot Chocolate-85,1-Bottled Water-30,', 'food_otw', 'awd', 1815, '2025-09-03 05:38:42', 'payment_1756877922_12.jpg');

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
(12, 'user', 'desu@gmail.com', '$2y$12$lPbTtU0Cp/HcLLn28w08uOr3mxDv67JY1fu7XaoJyDvlWje3nuFXi');

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

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
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
