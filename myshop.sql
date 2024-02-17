-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2024 at 11:09 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `date_created`) VALUES
(1, 'qwerty', '$2y$10$NsLt1woYThRzWO78ZaLG5usELGjaNd6KrY4tMJERc5x8XhdNFT.eK', '2023-10-01 10:29:37'),
(2, 'aaa', '$2y$10$ioyGVXE992fS0/Gy3X9o1e4S6g/TIk51.qCFU2RzSnDdZcZ8MO.u6', '2023-10-01 10:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_email`) VALUES
(21, 'Johnny Depp', 'depp@gmail.com'),
(23, 'Jason Stathan', 'Js@gmail.com'),
(31, 'Max', 'max@gmail.com'),
(32, 'Mark', 'mark@gmail.com'),
(42, 'Max', 'abc@gmail.com'),
(47, 'Wasted', 'waste@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `register_id` int(11) NOT NULL,
  `action_made` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `register_id`, `action_made`, `timestamp`, `role`) VALUES
(1, 2, 'Logged in the system', '2023-10-02 23:19:21', NULL),
(2, 2, 'Viewed the record with Customer ID : 21', '2023-10-02 23:22:27', NULL),
(3, 2, 'Viewed the record with Customer ID : 23', '2023-10-02 23:25:02', NULL),
(4, 2, 'Viewed the record with Customer ID : 31', '2023-10-02 23:26:31', NULL),
(5, 2, 'Viewed the record with Customer ID : 49', '2023-10-02 23:28:26', NULL),
(6, 2, 'Deleted record with Customer ID: 49', '2023-10-02 23:30:29', NULL),
(7, 2, 'Logged out from the system', '2023-10-02 23:30:51', NULL),
(8, 2, 'Logged in the system', '2023-10-02 23:31:00', NULL),
(9, 2, 'Logged out from the system', '2023-10-02 23:37:34', NULL),
(10, 2, 'Logged in the system', '2023-10-02 23:37:41', NULL),
(11, 2, 'Logged out from the system', '2023-10-02 23:38:03', NULL),
(12, 3, 'Logged in the system', '2023-10-02 23:38:30', NULL),
(13, 3, 'Viewed the record with Customer ID : 21', '2023-10-02 23:39:54', NULL),
(14, 3, 'Updated the record with Customer ID: 48', '2023-10-02 23:40:20', NULL),
(15, 3, 'Deleted record with Customer ID: 48', '2023-10-02 23:41:49', NULL),
(16, 3, 'Logged out from the system', '2023-10-02 23:42:01', NULL),
(17, 2, 'Logged in the system', '2023-10-02 23:42:26', NULL),
(18, 2, 'Logged out from the system', '2023-10-02 23:43:10', NULL),
(19, 2, 'Logged in the system', '2023-10-04 22:53:07', NULL),
(20, 2, 'Logged out from the system', '2023-10-04 22:53:09', NULL),
(21, 4, 'Logged in the system', '2023-12-08 12:30:34', NULL),
(22, 4, 'Viewed the record with Customer ID : 21', '2023-12-08 12:31:20', NULL),
(23, 4, 'Logged out from the system', '2023-12-08 12:32:09', NULL),
(24, 3, 'Logged in the system', '2023-12-14 15:58:19', NULL),
(25, 3, 'Logged out from the system', '2023-12-14 16:04:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `product_id`, `order_date`) VALUES
(21, 21, 21, '2023-05-14 23:26:47'),
(23, 23, 23, '2023-05-15 05:02:55'),
(31, 31, 31, '2023-05-18 14:18:35'),
(32, 32, 32, '2023-05-18 14:21:25'),
(42, 42, 42, '2023-05-22 08:30:15'),
(47, 47, 47, '2023-05-23 23:29:24');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`) VALUES
(21, 'Toyota Celica', 20000000000.00),
(23, 'Nissan Skyline', 50000000000000.00),
(31, 'Ferrari', 5000000000.00),
(32, 'Mustang GT', 500000000000.00),
(42, 'Mitsubishi', 500000000.00),
(47, 'Honda S 2000', 200000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `username`, `password`, `date_created`, `role`) VALUES
(1, 'admin', '$2y$10$4EPXUXezq1pk/9XC5dp6A.RH.1BFnoVntQX.KngSutA2aChyVulz.', '2023-10-02 23:12:58', NULL),
(2, 'mark', '$2y$10$gBmZKUC7b7jHuphXyOJ3suoHxAkPKsKX5OevEVMYAgKT/8DpG.Wfe', '2023-10-02 23:17:49', 'admin'),
(3, 'ivan', '$2y$10$c6iVCavWY28lNhcp8IOUyu8omuquNA4BKFy70Yn5RmT.c7un0zj9C', '2023-12-14 15:58:11', 'user'),
(4, 'marky', '$2y$10$/92LSs7Yz4EvKez1zc2LruL3SErkvVVdtJiarYAuiOMAIg63qrnzu', '2023-12-08 12:30:29', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `register_id` (`register_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`register_id`) REFERENCES `register` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
