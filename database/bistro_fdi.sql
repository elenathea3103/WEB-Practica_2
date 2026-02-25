-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2026 at 06:13 PM
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
-- Database: `bistro_fdi`
--

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
(1, 'stefana', 'raisadimofte11@gmail.com', '$2y$10$aezM8LE01GRwEHmCR/775OF7BIxNFc/u04652/gFBvzEVFckwCjbe', 'stefana', 'dimofte', 'client', 'uploads/avatars/1771791125_1.jpeg'),
(3, 'admin', 'raisadimofte11@gmail.com', '$2y$10$8VTGnos7Kp0B9EYNwWbyXOZkasAkyeQHVzYDNKV7FeIA3nvqlVM66', 'raisa', 'dimofte', 'manager', 'assets/avatars/avatar2.jpeg'),
(4, 'ana', 'ana_waiter@gmail.com', '$2y$10$mBEe/amHdwryp41QO50dce4/MOqUqa9EvMY2Fsi4T2uEA4LBqJSWS', 'ana', 'smith', 'waiter', 'uploads/avatars/1771860056_4.jpeg'),
(5, 'maria', 'maria_cook@gmail.com', '$2y$10$5IBUCls8oz4sIjwo03Lo8OoHXiX4zzWgAJVtYO8W1OfPgcfa1.G/2', 'maria', 'gomez', 'cook', 'uploads/avatars/1771853308_5.jpeg'),
(6, 'elena', 'elena@gmail.com', '$2y$10$EK1f2ml9gyXGwLsi73D3HePVM4WXB0nLJagqcimeFLS84vPYljCdq', 'Elena', 'Thea', 'client', 'uploads/avatars/1771875565_6.jpeg'),
(7, 'admin1', 'raisadimofte11@gmail.com', '$2y$10$I3PdEUoyeBtT3SEefFp6du6hD3e.auy3GojGSCkVVI6pYiojkhjZ6', 'raisa', 'dimofte', 'client', 'assets/avatars/avatar1.jpeg');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
