-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: vm019.db.swarm.test
-- Generation Time: Mar 05, 2026 at 03:47 PM
-- Server version: 10.4.28-MariaDB-1:10.4.28+maria~ubu2004
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bistro_fdi`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`) VALUES
(5, 'Coffee', 'Americano,Latte,Capuccino', NULL),
(6, 'Pizza', 'Margherita,Vegetarian,Pepperoni', NULL),
(7, 'Pasta', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `daily_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` enum('Local','Takeaway') NOT NULL,
  `status` enum('New','Received','In preparation','Cooking','Ready','Finished','Delivered','Cancelled') DEFAULT 'New',
  `total_price` decimal(10,2) NOT NULL,
  `is_paid` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `daily_number`, `user_id`, `order_date`, `type`, `status`, `total_price`, `is_paid`) VALUES
(1, 1, 6, '2026-03-03 20:24:06', 'Local', 'New', 16.49, 0),
(2, 2, 6, '2026-03-03 20:25:45', 'Takeaway', 'New', 14.30, 0),
(3, 3, 6, '2026-03-03 20:38:01', 'Local', 'New', 45.50, 0),
(4, 1, 6, '2026-03-04 12:01:36', 'Takeaway', 'New', 7.80, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price_at_purchase`) VALUES
(1, 1, 5, 1, 16.49),
(2, 2, 7, 1, 14.30),
(3, 3, 7, 3, 14.30),
(4, 3, 9, 1, 2.60),
(5, 4, 9, 3, 2.60);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `vat` int(11) DEFAULT NULL CHECK (`vat` in (4,10,21)),
  `is_available` tinyint(1) DEFAULT 1,
  `is_offered` tinyint(1) DEFAULT 1,
  `stock` int(11) DEFAULT 1,
  `is_active` tinyint(4) DEFAULT 1,
  `image_url` varchar(255) DEFAULT 'assets/products/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `image`, `base_price`, `vat`, `is_available`, `is_offered`, `stock`, `is_active`, `image_url`) VALUES
(5, 'Pepperoni', '', 6, NULL, 14.99, 10, 1, 1, 0, 1, 'pepperoni_pizza.jpeg'),
(6, 'Americano', '', 5, NULL, 1.00, 4, 1, 1, 7, 1, 'americano.jpeg'),
(7, 'Margherita', '', 6, NULL, 13.00, 10, 1, 1, 1, 1, 'margherita_pizza.jpg'),
(8, 'Vegetarian', '', 6, NULL, 17.00, 10, 1, 1, 5, 1, 'vegetarian_pizza.jpg'),
(9, 'Latte', '', 5, NULL, 2.50, 4, 1, 1, 15, 1, 'latte.jpg'),
(10, 'Cappuccino', '', 5, NULL, 2.00, 4, 1, 1, 15, 1, 'cappuccino.png'),
(11, 'Spaghetti Carbonara', '', 7, NULL, 19.00, 10, 1, 1, 9, 1, 'carbonara.webp'),
(12, 'Pasta Alfredo', '', 7, NULL, 17.90, 10, 1, 1, 9, 1, 'alfredo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `role` enum('client','waiter','cook','manager') DEFAULT 'client',
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `role`, `avatar`) VALUES
(1, 'stefana', 'raisadimofte11@gmail.com', '$2y$10$aezM8LE01GRwEHmCR/775OF7BIxNFc/u04652/gFBvzEVFckwCjbe', 'stefana', 'dimofte', 'client', 'uploads/avatars/1772372024_1.jpeg'),
(3, 'admin1', 'raisadimofte11@gmail.com', '$2y$10$8VTGnos7Kp0B9EYNwWbyXOZkasAkyeQHVzYDNKV7FeIA3nvqlVM66', 'raisa', 'dimofte', 'manager', 'uploads/avatars/1772371948_3.jpeg'),
(4, 'ana', 'ana_waiter@gmail.com', '$2y$10$mBEe/amHdwryp41QO50dce4/MOqUqa9EvMY2Fsi4T2uEA4LBqJSWS', 'ana', 'smith', 'waiter', 'uploads/avatars/1772371970_4.jpeg'),
(5, 'maria', 'maria_cook@gmail.com', '$2y$10$5IBUCls8oz4sIjwo03Lo8OoHXiX4zzWgAJVtYO8W1OfPgcfa1.G/2', 'maria', 'gomez', 'cook', 'uploads/avatars/1772372048_5.jpeg'),
(6, 'elena', 'elena@gmail.com', '$2y$10$EK1f2ml9gyXGwLsi73D3HePVM4WXB0nLJagqcimeFLS84vPYljCdq', 'Elena', 'Thea', 'client', 'uploads/avatars/1772371884_6.jpeg'),
(8, 'leon', 'leon.romania@gmail.com', '$2y$10$v9Ha/UgSVxv8wzBdEf1bEui2vNg98/FPLlmbIk4Fo9KRgZ2nXARSe', 'Leon', 'romania', 'client', 'assets/avatars/default.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_order` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_item` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_order` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_item` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
