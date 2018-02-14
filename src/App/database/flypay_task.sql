-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2018 at 12:57 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flypay_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20180212140813, 'CreatePaymentTable', '2018-02-14 10:57:10', '2018-02-14 10:57:10', 0),
(20180213080121, 'CreatePaymentDetailTable', '2018-02-14 10:57:10', '2018-02-14 10:57:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(10) UNSIGNED NOT NULL,
  `amount` double(5,2) NOT NULL,
  `tip` double(5,2) NOT NULL,
  `currency` enum('USD','EUR') COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `table_number` int(11) NOT NULL,
  `reference` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `card_type` enum('VISA','Mastercard','American Express','Discover','JCB','Diners Club','Maestro','InstaPayment') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `amount`, `tip`, `currency`, `location`, `table_number`, `reference`, `card_type`, `created_at`) VALUES
(1, 999.99, 15.98, 'USD', 'COVENT GARDEN GBK', 628, 'TR74624', 'InstaPayment', '2018-02-14 12:57:21'),
(2, 17.35, 999.99, 'USD', 'Great Portland Street GBK', 998, 'TR74737', 'InstaPayment', '2018-02-14 12:57:21'),
(3, 999.99, 999.99, 'EUR', 'Great Portland Street GBK', 511, 'TR63165', 'Mastercard', '2018-02-14 12:57:21'),
(4, 999.99, 977.36, 'USD', 'BIRMINGHAM RESORTS WORLD GBK', 5, 'TR86929', 'Maestro', '2018-02-14 12:57:21'),
(5, 999.99, 999.99, 'USD', 'BIRMINGHAM RESORTS WORLD GBK', 66, 'TR74126', 'American Express', '2018-02-14 12:57:21'),
(6, 999.99, 999.99, 'USD', 'SOHO GBK', 443, 'TR21323', 'InstaPayment', '2018-02-14 12:57:21'),
(7, 999.99, 999.65, 'EUR', 'Great Portland Street GBK', 107, 'TR75055', 'American Express', '2018-02-14 12:57:21'),
(8, 999.99, 999.99, 'USD', 'MAIDSTONE GBK', 654, 'TR56362', 'American Express', '2018-02-14 12:57:21'),
(9, 999.99, 999.99, 'USD', 'Great Portland Street GBK', 962, 'TR60690', 'InstaPayment', '2018-02-14 12:57:21'),
(10, 999.99, 67.16, 'EUR', 'SOHO GBK', 441, 'TR87411', 'Discover', '2018-02-14 12:57:21'),
(11, 999.99, 880.00, 'USD', 'BIRMINGHAM RESORTS WORLD GBK', 220, 'TR76153', 'American Express', '2018-02-14 12:57:21'),
(12, 556.63, 999.99, 'EUR', 'SOHO GBK', 613, 'TR85168', 'Discover', '2018-02-14 12:57:21'),
(13, 999.99, 999.99, 'USD', 'BIRMINGHAM RESORTS WORLD GBK', 608, 'TR75380', 'Mastercard', '2018-02-14 12:57:21'),
(14, 999.99, 999.99, 'EUR', 'BIRMINGHAM RESORTS WORLD GBK', 245, 'TR13343', 'InstaPayment', '2018-02-14 12:57:21'),
(15, 999.99, 999.99, 'EUR', 'COVENT GARDEN GBK', 624, 'TR84220', 'Mastercard', '2018-02-14 12:57:21'),
(16, 999.99, 999.99, 'EUR', 'Great Portland Street GBK', 147, 'TR15875', 'Discover', '2018-02-14 12:57:21'),
(17, 999.99, 999.99, 'USD', 'Great Portland Street GBK', 629, 'TR32355', 'VISA', '2018-02-14 12:57:21'),
(18, 999.99, 238.93, 'EUR', 'MAIDSTONE GBK', 990, 'TR75826', 'Diners Club', '2018-02-14 12:57:21'),
(19, 999.99, 377.91, 'EUR', 'BIRMINGHAM RESORTS WORLD GBK', 860, 'TR44418', 'Maestro', '2018-02-14 12:57:21'),
(20, 999.99, 797.03, 'EUR', 'MAIDSTONE GBK', 806, 'TR40595', 'Discover', '2018-02-14 12:57:21');

-- --------------------------------------------------------

--
-- Table structure for table `payment_detail`
--

CREATE TABLE `payment_detail` (
  `payment_id` int(10) UNSIGNED NOT NULL,
  `card_holder` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `device` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_detail`
--

INSERT INTO `payment_detail` (`payment_id`, `card_holder`, `phone_number`, `device`) VALUES
(2, 'Montana Veum III', '1-903-609-7145', 'Andoid'),
(3, 'Morris Schuster Sr.', '+1-243-433-4933', 'iOS'),
(4, 'Dr. Caterina Green MD', '943-385-8052 x5148', 'iOS'),
(5, 'Lonie Hartmann', '+1.403.534.2911', 'Andoid'),
(7, 'Florence Thiel', '512-994-9102 x576', 'iOS'),
(10, 'Breanne Auer', '(379) 970-9397 x351', 'iOS'),
(13, 'Rosemary Dickinson', '+1-226-535-0073', 'iOS'),
(14, 'Freeda Rath', '291-973-8041', 'Andoid'),
(16, 'Adeline Gislason DVM', '(645) 200-8451 x277', 'iOS'),
(18, 'Uriah Hickle', '462.219.3130 x292', 'Andoid'),
(19, 'Dorthy Carroll', '268-457-6476', 'Andoid'),
(20, 'Rosario Walter', '+1-438-526-2215', 'iOS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_reference_unique` (`reference`);

--
-- Indexes for table `payment_detail`
--
ALTER TABLE `payment_detail`
  ADD PRIMARY KEY (`payment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment_detail`
--
ALTER TABLE `payment_detail`
  ADD CONSTRAINT `payment_detail_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
