-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 03:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vc1_database_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `parent_category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `parent_category_id`, `created_at`, `updated_at`) VALUES
(28, 'Pizza', NULL, '2025-04-10 08:19:47', '2025-04-10 08:19:47'),
(29, 'Drinks', NULL, '2025-04-10 08:19:52', '2025-04-10 08:19:52'),
(30, 'Noodle', NULL, '2025-04-10 08:19:58', '2025-04-10 08:19:58'),
(31, 'IceDessert', NULL, '2025-04-10 08:20:14', '2025-04-10 08:20:14');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `reorder_level` int(11) NOT NULL DEFAULT 0,
  `stock_location` varchar(100) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `money_history`
--

CREATE TABLE `money_history` (
  `id` int(11) NOT NULL,
  `total_money` decimal(10,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `money_history`
--

INSERT INTO `money_history` (`id`, `total_money`, `updated_at`) VALUES
(948, 487.29, '2025-04-13 10:41:58'),
(949, 738.11, '2025-04-16 01:30:04'),
(950, 796.61, '2025-04-16 01:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Already ',
  `payment_mode` enum('Cash Payment','Card Payment') NOT NULL DEFAULT 'Cash Payment',
  `order_reference` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `order_date`, `status`, `payment_mode`, `order_reference`) VALUES
(125, 59, 5.63, '2025-04-14 01:53:45', 'Already ', 'Cash Payment', NULL),
(126, 59, 4.50, '2025-04-14 01:57:17', 'Already ', 'Card Payment', NULL),
(128, 59, 9.00, '2025-04-14 02:01:15', 'Already ', 'Cash Payment', NULL),
(130, 59, 30.00, '2025-04-14 02:03:45', 'Already ', 'Cash Payment', NULL),
(131, 59, 25.00, '2025-04-14 02:05:49', 'Already ', 'Cash Payment', NULL),
(132, 59, 15.75, '2025-04-14 02:07:15', 'Already ', 'Card Payment', NULL),
(133, 59, 12.00, '2025-04-14 02:13:35', 'Already ', 'Cash Payment', NULL),
(134, 59, 1.26, '2025-04-15 01:23:12', 'Already ', 'Card Payment', NULL),
(135, 59, 16.50, '2025-04-15 01:34:18', 'Already ', 'Cash Payment', NULL),
(136, 59, 0.63, '2025-04-15 01:38:10', 'Already ', 'Cash Payment', NULL),
(137, 59, 4.14, '2025-04-15 02:14:11', 'Already ', 'Cash Payment', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`, `total_price`) VALUES
(135, 125, 174, 1, 5.00, 0.00),
(136, 125, 180, 1, 0.63, 0.00),
(137, 126, 193, 3, 0.75, 0.00),
(138, 126, 205, 3, 0.75, 0.00),
(140, 128, 175, 3, 3.00, 0.00),
(142, 130, 210, 20, 0.75, 0.00),
(143, 130, 212, 20, 0.75, 0.00),
(144, 131, 178, 5, 5.00, 0.00),
(145, 132, 217, 21, 0.75, 0.00),
(146, 133, 175, 4, 3.00, 0.00),
(147, 134, 180, 2, 0.63, 0.00),
(148, 135, 215, 22, 0.75, 0.00),
(149, 136, 179, 1, 0.63, 0.00),
(150, 137, 194, 3, 0.63, 0.00),
(151, 137, 193, 3, 0.75, 0.00);

--
-- Triggers `order_items`
--
DELIMITER $$
CREATE TRIGGER `reduce_product_quantity` AFTER INSERT ON `order_items` FOR EACH ROW BEGIN
    UPDATE products 
    SET quantity = quantity - NEW.quantity
    WHERE product_id = NEW.product_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` enum('Cash','Credit Card','QR Code','Online') NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost_product` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `image` varchar(225) NOT NULL,
  `barcode` varchar(14) DEFAULT NULL,
  `in_stock` tinyint(1) NOT NULL,
  `quantity` int(20) NOT NULL,
  `discounted_price` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `category_id`, `supplier_id`, `price`, `cost_product`, `created_at`, `updated_at`, `image`, `barcode`, `in_stock`, `quantity`, `discounted_price`) VALUES
(174, 'ភីសារសជាតិប៉េងបោះធំ', 'I want to buy it into stock now.', 28, NULL, 5.00, 4.50, '2025-04-16 01:26:43', '2025-04-16 01:26:43', 'uploads/3.jpg', '1234567891234', 0, 25, 0),
(175, 'ភីសាស្លឹលខ្ទឹមតូច', 'I want to buy it into stock now.', 28, NULL, 3.00, 2.50, '2025-04-14 02:13:35', '2025-04-14 02:13:35', 'uploads/4.jpg', '1234567891235', 0, 3, 0),
(176, 'ភីសាររសជាតិជូធំ', 'I want to buy it into stock now.', 28, NULL, 5.00, 4.50, '2025-04-16 01:27:30', '2025-04-16 01:27:30', 'uploads/5.jpg', '1234567891236', 1, 25, 0),
(177, 'ភីសារហត់ដក់តូច', 'I want to buy it into stock now.', 28, NULL, 3.00, 2.50, '2025-04-16 01:27:00', '2025-04-16 01:27:00', 'uploads/images__4_.jpg', '1234567891238', 0, 25, 0),
(178, 'ភីសារហត់ដក់ធំ', 'I want to buy it into stock now.', 28, NULL, 5.00, 4.50, '2025-04-16 01:27:12', '2025-04-16 01:27:12', 'uploads/images__3_.jpg', '1234567891237', 1, 25, 0),
(179, 'ម៉ាម៉ាមីនូដលសាច់', 'I want to buy it into stock now.', 30, NULL, 0.63, 0.50, '2025-04-16 01:28:21', '2025-04-16 01:28:21', 'uploads/mama.jpg', '1234567891239', 1, 22, 0),
(180, 'ម៉ាម៉ាមីនូដលភ្លៅមាន់', 'I want to buy it into stock now.', 30, NULL, 0.63, 0.50, '2025-04-15 01:23:12', '2025-04-15 01:23:12', 'uploads/mama-instant-cup-noodles-chicken-70g.jpg', '1234567891240', 1, 3, 0),
(181, 'ម៉ាម៉ាមីនូដលបង្កង', 'I want to buy it into stock now.', 30, NULL, 0.63, 0.50, '2025-04-16 01:28:36', '2025-04-16 01:28:36', 'uploads/mamanoodle.png', '1234567891241', 1, 25, 0),
(182, 'ម៉ាម៉ាមីនូដលGreen Curry', 'I want to buy it into stock now.', 30, NULL, 0.63, 0.50, '2025-04-16 01:28:03', '2025-04-16 01:28:03', 'uploads/Mama-Cup-Noodles-Green.jpg', '1234567891242', 1, 25, 0),
(185, 'ទឹកកកឈូសក្រូច', 'I want to buy it into stock now.', 31, NULL, 0.50, 0.40, '2025-04-16 01:32:46', '2025-04-16 01:32:46', 'uploads/tikice.jpg', '1234567891243', 0, 25, 0),
(186, 'ទឹកកកឈូសស្ទបប័ររី', 'I want to buy it into stock now.', 31, NULL, 0.50, 0.40, '2025-04-16 01:32:57', '2025-04-16 01:32:57', 'uploads/ice2.jpg', '1234567891244', 1, 24, 0),
(187, 'ទឹកកកឈូសសីរ៉ូ', 'I want to buy it into stock now.', 31, NULL, 0.50, 0.40, '2025-04-10 10:45:13', '2025-04-10 10:45:13', 'uploads/ice2.png', '1234567891245', 1, 9, 0),
(188, 'ទឹកកកឈូសសណ្តែក', 'I want to buy it into stock now.', 31, NULL, 0.50, 0.40, '2025-04-16 01:33:08', '2025-04-16 01:33:08', 'uploads/ice.jpg', '1234567891247', 1, 25, 0),
(189, 'ទឹកកកឈូសប័រ', 'I want to buy it into stock now.', 31, NULL, 0.50, 0.40, '2025-04-16 01:32:34', '2025-04-16 01:32:34', 'uploads/ice4.jpg', '1234567891248', 1, 20, 0),
(190, 'ទឹកកកឈូសទឹកដោះគោ', 'I want to buy it into stock now.', 31, NULL, 0.50, 0.40, '2025-04-14 02:01:37', '2025-04-14 02:01:37', 'uploads/photo_2025-03-24_00-44-28.jpg', '1234567891249', 1, 4, 0),
(191, 'កូកាកូឡា', 'I want to buy it into stock now.', 29, NULL, 0.63, 0.50, '2025-04-10 10:50:42', '2025-04-10 10:50:42', 'uploads/coca.jpeg', '1234567891250', 1, 10, 0),
(192, 'ឆែមពានហ្គ្រីន', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-10 10:51:43', '2025-04-10 10:51:43', 'uploads/Champion-Green.png', '1234567891251', 1, 10, 0),
(193, 'ឆែមពានអាយ', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-15 02:14:11', '2025-04-15 02:14:11', 'uploads/Champion-Ice-New.png', '1234567891252', 1, 4, 0),
(194, 'ហ្វាន់តាGreen', 'I want to buy it into stock now.', 29, NULL, 0.63, 0.50, '2025-04-15 02:14:11', '2025-04-15 02:14:11', 'uploads/fanta.jpg', '1234567891253', 1, 7, 0),
(195, 'ហ្វាន់តាទំពាងបាយជូ', 'I want to buy it into stock now.', 29, NULL, 0.63, 0.50, '2025-04-11 07:25:04', '2025-04-11 07:25:04', 'uploads/fanta-grape.jpeg', '1234567891254', 1, 10, 0),
(196, 'ហ្វាន់តាក្រូច', 'I want to buy it into stock now.', 29, NULL, 0.63, 0.50, '2025-04-11 07:26:05', '2025-04-11 07:26:05', 'uploads/Fanta-Orange-Soft-Drink.jpg', '1234567891255', 1, 10, 0),
(197, 'អូអិឈិកទឹកឃ្មុំ', 'I want to buy it into stock now.', 29, NULL, 0.63, 0.50, '2025-04-11 07:27:35', '2025-04-11 07:27:35', 'uploads/honey-.jpg', '1234567891256', 1, 10, 0),
(198, 'អូអិឈិកខ្មៅ', 'I want to buy it into stock now.', 29, NULL, 0.63, 0.50, '2025-04-11 07:28:46', '2025-04-11 07:28:46', 'uploads/oishi_black.jpg', '1234567891257', 1, 10, 0),
(199, 'អូអិឈិកទទឹម', 'I want to buy it into stock now.', 29, NULL, 0.63, 0.50, '2025-04-11 07:33:05', '2025-04-11 07:33:05', 'uploads/oishi_red.jpg', '1234567891258', 1, 10, 0),
(200, 'អិឈីតានគូលេន', 'I want to buy it into stock now.', 29, NULL, 0.63, 0.50, '2025-04-11 07:35:02', '2025-04-11 07:35:02', 'uploads/echitan.jpg', '1234567891259', 1, 10, 0),
(201, 'អិឈីតានទឹកឃ្មុំ', 'I want to buy it into stock now.', 29, NULL, 0.63, 0.50, '2025-04-11 07:36:39', '2025-04-11 07:36:39', 'uploads/ichitan.jpg', '1234567891260', 1, 10, 0),
(202, 'ស្ទិងលឿងដប', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-11 07:37:53', '2025-04-11 07:37:53', 'uploads/sting_yellow.jpg', '1234567891261', 1, 10, 0),
(203, 'ស្ទិងក្រហមដប', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-11 07:38:56', '2025-04-11 07:38:56', 'uploads/sting_red.png', '1234567891262', 1, 10, 0),
(204, 'ស្ទិងក្រហម', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-11 07:39:42', '2025-04-11 07:39:42', 'uploads/red-sting-energy.jpg', '1234567891263', 1, 10, 0),
(205, 'ស្ទិងលឿង', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-14 01:57:17', '2025-04-14 01:57:17', 'uploads/sting2.jpg', '1234567891264', 1, 7, 0),
(206, 'ទឹកដោះគោ', 'I want to buy it into stock now.', 29, NULL, 0.50, 0.40, '2025-04-11 07:42:32', '2025-04-11 07:42:32', 'uploads/images__1_.jpg', '1234567891265', 0, 10, 0),
(207, 'លេតតាសយ', 'I want to buy it into stock now.', 29, NULL, 0.63, 0.50, '2025-04-11 07:43:32', '2025-04-11 07:43:32', 'uploads/lactasoy.jpg', '1234567891266', 1, 10, 0),
(208, 'ទឹកដោះគោ', 'I want to buy it into stock now.', 29, NULL, 0.50, 0.40, '2025-04-11 07:44:31', '2025-04-11 07:44:31', 'uploads/images.jpg', '1234567891267', 1, 10, 0),
(209, 'តែក្រូចឆ្មារ', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-11 07:45:30', '2025-04-11 07:45:30', 'uploads/tea4.jpg', '1234567891268', 1, 10, 0),
(210, 'តែជ្រក់ខៀវ', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-16 01:33:49', '2025-04-16 01:33:49', 'uploads/tea1.jpg', '1234567891269', 1, 20, 0),
(211, 'តែក្រហម', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-11 07:48:09', '2025-04-11 07:48:09', 'uploads/tea2.jpg', '1234567891270', 0, 10, 0),
(212, 'ស្ទបប័ររីក្រឡុក', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-14 02:04:12', '2025-04-14 02:04:12', 'uploads/krolok5.jpg', '1234567891271', 0, 7, 0),
(213, 'ត្រាវក្រឡុក', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-11 07:50:50', '2025-04-11 07:50:50', 'uploads/krolok4.jpg', '1234567891272', 0, 10, 0),
(214, 'តែក្រូចឆ្មារទឹកឃ្មុំ', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-11 07:52:18', '2025-04-11 07:52:18', 'uploads/tea-green.jpg', '1234567891273', 1, 10, 0),
(215, 'តែបៃតងទឹកដោះគោដូងក្រអូប', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-16 01:33:27', '2025-04-16 01:33:27', 'uploads/ber.jpg', '1234567891274', 1, 22, 0),
(216, 'តែគុជត្រាវ', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-16 01:34:06', '2025-04-16 01:34:06', 'uploads/krolok2.jpg', '1234567891275', 1, 20, 0),
(217, 'គីវីសូដា', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-16 01:26:23', '2025-04-16 01:26:23', 'uploads/tea_bee.jpg', '1234567891276', 0, 21, 0),
(218, 'តែគុជត្រសក់ស្រូវ', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-12 11:15:25', '2025-04-12 11:15:25', 'uploads/krolok1.jpg', '1234567891277', 1, 20, 0),
(219, 'តែគុជទឹកដោះគោ', 'I want to buy it into stock now.', 29, NULL, 0.75, 0.63, '2025-04-12 11:15:35', '2025-04-12 11:15:35', 'uploads/krolok3.jpg', '1234567891278', 1, 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` enum('admin','user','staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `stock_history`
--

CREATE TABLE `stock_history` (
  `id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_history`
--

INSERT INTO `stock_history` (`id`, `total`, `updated_at`) VALUES
(541, 485, '2025-04-13 10:41:58'),
(542, 527, '2025-04-16 01:30:04'),
(543, 623, '2025-04-16 01:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `role_id`, `phone_number`, `profile_image`) VALUES
(59, 'Chhea Chhouy', 'chhea.chhouy@student.passerellesnumeriques.org', '$2y$10$hKRBleqep5XEzW70kP1DXOutY8KVwJj4cmSIEbK7LnoQyEUACVYkm', 1, '0976313871', '/Views/assets/uploads/67e9dace21df2-67d9245315317-1.jpg'),
(60, 'Kin Doung', 'kin@gmail.com', '$2y$10$W9hKbwVZSVhOs9bCKKo1denBjynmq1/GoPLGzErFLC7kqw.IpuTiC', 3, '0976313871', '/Views/assets/uploads/67fdb81391ed2-kin.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `weather`
--

CREATE TABLE `weather` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `temperature` float NOT NULL,
  `weather_condition` varchar(100) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_category_id` (`parent_category_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `money_history`
--
ALTER TABLE `money_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_reference` (`order_reference`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_items_ibfk_1` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `stock_history`
--
ALTER TABLE `stock_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `weather`
--
ALTER TABLE `weather`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `location_id` (`location_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `money_history`
--
ALTER TABLE `money_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=951;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_history`
--
ALTER TABLE `stock_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=544;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `weather`
--
ALTER TABLE `weather`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
