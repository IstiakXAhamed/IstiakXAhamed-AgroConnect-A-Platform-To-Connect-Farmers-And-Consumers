-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2026 at 07:10 PM
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
-- Database: `agroconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address_line` varchar(500) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_default` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `created_at`) VALUES
(1, 'Vegetables', 'vegetables.png', '2026-01-15 18:06:31'),
(2, 'Fruits', 'fruits.png', '2026-01-15 18:06:31'),
(3, 'Grains', 'grains.png', '2026-01-15 18:06:31'),
(4, 'Dairy', 'dairy.png', '2026-01-15 18:06:31'),
(5, 'Fish & Meat', 'meat.png', '2026-01-15 18:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_rules`
--

CREATE TABLE `delivery_rules` (
  `id` int(11) NOT NULL,
  `inside_city_charge` int(11) NOT NULL DEFAULT 100,
  `outside_city_charge` int(11) NOT NULL DEFAULT 150,
  `base_weight` int(11) NOT NULL DEFAULT 5,
  `extra_weight_unit` int(11) NOT NULL DEFAULT 5,
  `extra_charge` int(11) NOT NULL DEFAULT 30,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_rules`
--

INSERT INTO `delivery_rules` (`id`, `inside_city_charge`, `outside_city_charge`, `base_weight`, `extra_weight_unit`, `extra_charge`, `updated_at`) VALUES
(1, 100, 150, 5, 7, 100, '2026-01-14 22:47:57');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total_amount`, `status`, `created_at`) VALUES
(1, 2, 500.00, 'pending', '2026-01-14 23:36:23'),
(2, 5, 1200.00, 'completed', '2026-01-14 23:36:23'),
(3, 2, 350.00, 'pending', '2026-01-14 23:36:23'),
(4, 5, 800.00, 'processing', '2026-01-14 23:36:23'),
(5, 2, 2500.00, 'completed', '2026-01-14 23:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platform_commission`
--

CREATE TABLE `platform_commission` (
  `id` int(11) NOT NULL,
  `farmer_commission` float(5,2) NOT NULL DEFAULT 5.00,
  `transporter_commission` float(5,2) NOT NULL DEFAULT 5.00,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `platform_commission`
--

INSERT INTO `platform_commission` (`id`, `farmer_commission`, `transporter_commission`, `updated_at`) VALUES
(1, 7.00, 5.00, '2026-01-14 22:47:57');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `farmer_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `farmer_id`, `name`, `price`, `quantity`, `status`, `created_at`, `image`, `description`, `category_id`) VALUES
(1, 1, 'Fresh Tomato', 80.00, 100, 1, '2026-01-14 23:36:03', NULL, NULL, NULL),
(2, 1, 'Green Chili', 120.00, 50, 1, '2026-01-14 23:36:03', NULL, NULL, NULL),
(3, 3, 'Potato', 40.00, 200, 1, '2026-01-14 23:36:03', NULL, NULL, NULL),
(4, 3, 'Onion', 60.00, 150, 1, '2026-01-14 23:36:03', NULL, NULL, NULL),
(5, 1, 'Rice (5kg)', 350.00, 30, 1, '2026-01-14 23:36:03', NULL, NULL, NULL),
(6, 2, 'Fresh Tomato', 60.00, 100, 0, '2026-01-16 00:09:58', 'tomato.jpg', 'Farm fresh organic tomatoes', 1),
(7, 2, 'Potato (Deshi)', 35.00, 500, 0, '2026-01-16 00:09:58', 'potato.jpg', 'Best quality round potato', 1),
(8, 2, 'Mango (Himsagar)', 120.00, 50, 0, '2026-01-16 00:09:58', 'mango.jpg', 'Sweet and fresh mangoes from Rajshahi', 2),
(9, 2, 'Miniket Rice', 75.00, 200, 0, '2026-01-16 00:09:58', 'rice.jpg', 'Premium polished rice', 3),
(10, 2, 'Cow Milk', 90.00, 30, 0, '2026-01-16 00:09:58', 'milk.jpg', 'Pure fresh milk', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL,
  `phone` int(11) NOT NULL,
  `role` enum('admin','farmer','customer','transporter') NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `status`, `created_at`, `profile_image`, `address`) VALUES
(1, 'Istiak', 'admin@test.com', '$2y$10$musavL3tCFDiT7OarO0PCOuMsXpEFM5luZtHZ1wpN6bQ10CRadBcu', 0, 'admin', 1, '2026-01-14 22:37:09', NULL, NULL),
(2, 'Kawshik', 'admin2@test.com', '$2y$10$2rwGpHtgPyTYv724X5NO2.gNq1yCvuacuNC5piIFji8Ahc3BGDe9O', 0, 'admin', 1, '2026-01-14 22:37:09', NULL, NULL),
(3, 'sanim7004', 'sanim1728@gmail.com', '$2y$10$qtWEF1.mMzFBa3X31I4B9.KywY/7CsFwxLbNgfw/UPUD0C0PUyuJS', 1991523289, 'customer', 1, '2026-01-14 22:37:09', NULL, NULL),
(4, 'Rahim Farmer', 'rahim@farmer.com', '123456', 1711111111, 'farmer', 1, '2026-01-14 23:35:47', NULL, NULL),
(5, 'Karim Customer', 'karim@customer.com', '123456', 1722222222, 'customer', 1, '2026-01-14 23:35:47', NULL, NULL),
(6, 'Jabbar Farmer', 'jabbar@farmer.com', '123456', 1733333333, 'farmer', 0, '2026-01-14 23:35:47', NULL, NULL),
(7, 'Salam Transporter', 'salam@trans.com', '123456', 1744444444, 'transporter', 0, '2026-01-14 23:35:47', NULL, NULL),
(8, 'Mina Customer', 'mina@customer.com', '123456', 1755555555, 'customer', 0, '2026-01-14 23:35:47', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_rules`
--
ALTER TABLE `delivery_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `platform_commission`
--
ALTER TABLE `platform_commission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery_rules`
--
ALTER TABLE `delivery_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `platform_commission`
--
ALTER TABLE `platform_commission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
