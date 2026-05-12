-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2025 at 08:30 AM
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
-- Database: `halfday`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cust_order`
--

CREATE TABLE `cust_order` (
  `order_id` int(11) NOT NULL,
  `order_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','preparing','ready','completed','cancelled') DEFAULT 'pending',
  `table_no` int(11) DEFAULT NULL,
  `receipt_path` varchar(255) DEFAULT NULL,
  `payment_status` enum('unpaid','paid') DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cust_order`
--

INSERT INTO `cust_order` (`order_id`, `order_time`, `total_amount`, `status`, `table_no`, `receipt_path`, `payment_status`) VALUES
(37, '2025-06-14 12:37:36', 29.00, 'pending', 1, 'receipt_1749904706_2783.jpg', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `item_options`
--

CREATE TABLE `item_options` (
  `option_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `option_name` varchar(100) DEFAULT NULL,
  `additional_price` decimal(10,2) DEFAULT 0.00,
  `option_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_options`
--

INSERT INTO `item_options` (`option_id`, `item_id`, `option_name`, `additional_price`, `option_type`) VALUES
(2, 1, 'Change to Oat Milk', 2.00, NULL),
(1, 1, 'Extra Espresso Shot', 3.00, NULL),
(41, 2, 'Extra Esspresso Shot', 3.00, 'Other Option'),
(39, 2, 'Hot', 0.00, 'Variation'),
(40, 2, 'Iced', 1.00, 'Variation'),
(42, 2, 'Oat Milk', 2.00, 'Other Option'),
(37, 3, 'Extra Esspresso Shot', 3.00, 'Add-on'),
(35, 3, 'Hot', 0.00, 'Variation'),
(36, 3, 'Iced', 1.00, 'Variation'),
(38, 3, 'Oat Milk', 2.00, 'Add-on'),
(45, 4, 'Extra Esspresso Shot', 3.00, 'Other Option'),
(43, 4, 'Hot', 0.00, 'Variation'),
(44, 4, 'Iced', 1.00, 'Variation'),
(46, 4, 'Oat Milk', 2.00, 'Other Option'),
(3, 8, 'Extra Esspresso Shot', 3.00, NULL),
(50, 9, 'Elderflower', 2.00, 'Flavor Syrup'),
(56, 9, 'Extra Esspresso Shot', 3.00, 'Add-on'),
(51, 9, 'Hazelnut', 2.00, 'Flavor Syrup'),
(52, 9, 'Honey', 2.00, 'Flavor Syrup'),
(48, 9, 'Hot', 0.00, 'Variation'),
(49, 9, 'Iced', 1.00, 'Variation'),
(53, 9, 'Lemon', 2.00, 'Flavor Syrup'),
(54, 9, 'Mint', 2.00, 'Flavor Syrup'),
(55, 9, 'Rose', 2.00, 'Flavor Syrup'),
(59, 10, 'Caramel', 2.00, 'Flavor Syrup'),
(61, 10, 'Chocolate (Mocha)', 2.00, 'Flavor Syrup'),
(65, 10, 'Extra Espresso Shot', 3.00, 'Other Option'),
(64, 10, 'Hazelnut', 2.00, 'Flavor Syrup'),
(60, 10, 'Honey', 2.00, 'Flavor Syrup'),
(57, 10, 'Hot', 0.00, 'Variation'),
(58, 10, 'Iced', 1.00, 'Variation'),
(63, 10, 'Macadami Nuts', 2.00, 'Flavor Syrup'),
(66, 10, 'Oat Milk', 2.00, 'Other Option'),
(62, 10, 'Rose', 2.00, 'Flavor Syrup'),
(8, 11, 'Extra Esspresso Shot', 3.00, NULL),
(105, 11, 'Hot', 0.00, 'Variation'),
(106, 11, 'Iced', 1.00, 'Variation'),
(9, 11, 'Oat Milk', 2.00, NULL),
(4, 12, 'Extra Esspresso Shot', 3.00, NULL),
(107, 12, 'Hot', 0.00, 'Variation'),
(108, 12, 'Iced', 1.00, 'Variation'),
(7, 12, 'Oat Milk', 2.00, NULL),
(5, 13, 'Extra Esspresso Shot', 3.00, NULL),
(109, 13, 'Hot', 0.00, 'Variation'),
(110, 13, 'Iced', 1.00, 'Variation'),
(6, 13, 'Oat Milk', 2.00, NULL),
(12, 14, 'Extra Esspresso Shot', 3.00, NULL),
(111, 14, 'Hot', 0.00, 'Variation'),
(112, 14, 'Iced', 1.00, 'Variation'),
(13, 14, 'Oat Milk', 2.00, NULL),
(14, 15, 'Extra Esspresso Shot', 3.00, NULL),
(113, 15, 'Hot', 0.00, 'Variation'),
(114, 15, 'Iced', 1.00, 'Variation'),
(15, 15, 'Oat Milk', 2.00, NULL),
(10, 16, 'Extra Esspresso Shot', 3.00, NULL),
(115, 16, 'Hot', 0.00, 'Variation'),
(116, 16, 'Iced', 1.00, 'Variation'),
(11, 16, 'Oat Milk', 2.00, NULL),
(16, 17, 'Extra Esspresso Shot', 3.00, NULL),
(117, 17, 'Hot', 0.00, 'Variation'),
(118, 17, 'Iced', 1.00, 'Variation'),
(17, 17, 'Oat Milk', 2.00, NULL),
(18, 18, 'Oat Milk', 2.00, NULL),
(19, 23, 'Fried Egg', 2.00, NULL),
(134, 23, 'Original', 0.00, 'Flavor'),
(135, 23, 'Spicy', 0.00, 'Flavor'),
(137, 26, 'Korean', 0.00, 'Flavor of Fried Chicken'),
(136, 26, 'Original', 0.00, 'Flavor of Fried Chicken'),
(138, 26, 'Soy Garlic', 0.00, 'Flavor of Fried Chicken'),
(24, 32, 'Boiled Shrimp Gyoza', 3.00, NULL),
(25, 32, 'Extra Noodles', 2.00, NULL),
(27, 32, 'Fried Egg', 2.00, NULL),
(23, 32, 'Fried Shrimp Gyoza', 3.00, NULL),
(21, 32, 'Korean Fried Chicken', 5.00, NULL),
(26, 32, 'Onsen Egg', 2.00, NULL),
(20, 32, 'Original Fried Chicken', 5.00, NULL),
(22, 32, 'Soy garlic Fried Chicken', 5.00, NULL),
(68, 33, 'After Meal', 0.00, 'Serving Time'),
(67, 33, 'Serve now', 0.00, 'Serving Time'),
(72, 34, 'After meal', 0.00, 'Serving Time'),
(71, 34, 'Serve now', 0.00, 'Serving Time'),
(73, 35, 'After Meal', 0.00, 'Serving Time'),
(74, 35, 'Serve now', 0.00, 'Serving Time'),
(70, 37, 'After meal', 0.00, 'Serving Time'),
(69, 37, 'Serve now', 0.00, 'Serving Time'),
(79, 38, 'After Meal', 0.00, 'Serving Time'),
(78, 38, 'Serve now', 0.00, 'Serving Time'),
(83, 39, 'Chocolate', 0.00, 'Ice Cream Selection'),
(82, 39, 'Mint', 0.00, 'Ice Cream Selection'),
(81, 39, 'Taro/ Yam', 0.00, 'Ice Cream Selection'),
(80, 39, 'Vanilla', 0.00, 'Ice Cream Selection'),
(85, 40, 'After Meal', 0.00, 'Serving Time'),
(87, 40, 'Chocolate', 3.00, 'Add-on Ice Cream'),
(89, 40, 'Mint', 3.00, 'Add-on Ice Cream'),
(84, 40, 'Serve now', 0.00, 'Serving Time'),
(88, 40, 'Taro/ Yam', 3.00, 'Add-on Ice Cream'),
(86, 40, 'Vanilla', 3.00, 'Add-on Ice Cream'),
(92, 41, 'Chocolate Mint Ice Cream', 1.00, 'Flavor'),
(90, 41, 'Cream Cheese + Blueberry Sauce', 0.00, 'Flavor'),
(91, 41, 'Yam Ice Cream & Nuts', 1.00, 'Flavor'),
(94, 42, 'Chicken Loaf & Egg Mayo', 2.00, 'Flavor'),
(93, 42, 'Egg Mayo & Cheese', 0.00, 'Flavor'),
(129, 45, 'Chili Sauce', 0.00, 'Condiments'),
(130, 45, 'Mayo', 0.00, 'Condiments'),
(131, 45, 'Toasted Mentai', 2.00, 'Condiments'),
(133, 46, 'Chili Sauce', 0.00, 'Condiments'),
(132, 46, 'Ginger in Vinegar', 0.00, 'Condiments'),
(29, 48, 'Apple Peach', 1.00, NULL),
(30, 48, 'Original Black Tea', 0.00, NULL),
(28, 48, 'Pineapple', 1.00, NULL),
(123, 49, 'Elderflower', 0.00, 'Flavor'),
(124, 49, 'Honey', 0.00, 'Flavor'),
(119, 49, 'Hot', 0.00, 'Variation'),
(120, 49, 'Iced', 1.00, 'Variation'),
(121, 49, 'Mint', 0.00, 'Flavor'),
(122, 49, 'Rose', 0.00, 'Flavor'),
(31, 51, 'Elderflower', 0.00, NULL),
(34, 51, 'Honey Lemon', 1.00, NULL),
(125, 51, 'Hot', 0.00, 'Variation'),
(126, 51, 'Iced', 1.00, 'Variation'),
(32, 51, 'Rose', 0.00, NULL),
(33, 51, 'White Peach', 0.00, NULL),
(127, 52, 'Hot', 0.00, 'Variation'),
(128, 52, 'Iced', 1.00, 'Variation'),
(76, 53, 'After Meal', 0.00, 'Serving Time'),
(75, 53, 'Serve now', 0.00, 'Serving Time'),
(77, 53, 'Takeaway', 0.00, 'Serving Time'),
(47, 56, 'Extra Esspresso Shot', 3.00, 'Add-on'),
(100, 57, 'After Meal', 0.00, 'Serving Time'),
(104, 57, 'Chocolate', 3.00, 'Add-on Ice Cream'),
(96, 57, 'Dark Chocolate', 0.00, 'Flavor'),
(97, 57, 'Homemade Blueberry', 0.00, 'Flavor'),
(95, 57, 'Lemon Curd', 0.00, 'Flavor'),
(103, 57, 'Mint', 3.00, 'Add-on Ice Cream'),
(99, 57, 'Serve now', 0.00, 'Serving Time'),
(98, 57, 'Strawberry', 0.00, 'Flavor'),
(102, 57, 'Taro/ Yam', 3.00, 'Add-on Ice Cream'),
(101, 57, 'Vanilla', 3.00, 'Add-on Ice Cream');

-- --------------------------------------------------------

--
-- Table structure for table `item_options_backup`
--

CREATE TABLE `item_options_backup` (
  `option_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `option_name` varchar(100) DEFAULT NULL,
  `additional_price` decimal(10,2) DEFAULT 0.00,
  `option_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_options_backup`
--

INSERT INTO `item_options_backup` (`option_id`, `item_id`, `option_name`, `additional_price`, `option_type`) VALUES
(1, 1, 'Extra Espresso Shot', 3.00, NULL),
(2, 1, 'Change to Oat Milk', 2.00, NULL),
(13, 8, 'Extra Esspresso Shot', 3.00, NULL),
(17, 12, 'Extra Esspresso Shot', 3.00, NULL),
(19, 13, 'Extra Esspresso Shot', 3.00, NULL),
(20, 13, 'Oat Milk', 2.00, NULL),
(21, 12, 'Oat Milk', 2.00, NULL),
(22, 11, 'Extra Esspresso Shot', 3.00, NULL),
(23, 11, 'Oat Milk', 2.00, NULL),
(24, 16, 'Extra Esspresso Shot', 3.00, NULL),
(25, 16, 'Oat Milk', 2.00, NULL),
(26, 14, 'Extra Esspresso Shot', 3.00, NULL),
(27, 14, 'Oat Milk', 2.00, NULL),
(28, 15, 'Extra Esspresso Shot', 3.00, NULL),
(29, 15, 'Oat Milk', 2.00, NULL),
(30, 17, 'Extra Esspresso Shot', 3.00, NULL),
(31, 17, 'Oat Milk', 2.00, NULL),
(32, 18, 'Oat Milk', 2.00, NULL),
(39, 23, 'Fried Egg', 2.00, NULL),
(40, 32, 'Original Fried Chicken', 5.00, NULL),
(41, 32, 'Korean Fried Chicken', 5.00, NULL),
(42, 32, 'Soy garlic Fried Chicken', 5.00, NULL),
(43, 32, 'Fried Shrimp Gyoza', 3.00, NULL),
(44, 32, 'Boiled Shrimp Gyoza', 3.00, NULL),
(45, 32, 'Extra Noodles', 2.00, NULL),
(46, 32, 'Onsen Egg', 2.00, NULL),
(47, 32, 'Fried Egg', 2.00, NULL),
(56, 48, 'Pineapple', 1.00, NULL),
(57, 48, 'Apple Peach', 1.00, NULL),
(58, 48, 'Original Black Tea', 0.00, NULL),
(70, 51, 'Elderflower', 0.00, NULL),
(71, 51, 'Rose', 0.00, NULL),
(72, 51, 'White Peach', 0.00, NULL),
(73, 51, 'Honey Lemon', 1.00, NULL),
(74, 3, 'Hot', 0.00, 'Variation'),
(75, 3, 'Iced', 1.00, 'Variation'),
(76, 3, 'Extra Esspresso Shot', 3.00, 'Add-on'),
(77, 3, 'Oat Milk', 2.00, 'Add-on'),
(78, 2, 'Hot', 0.00, 'Variation'),
(79, 2, 'Iced', 1.00, 'Variation'),
(80, 2, 'Extra Esspresso Shot', 3.00, 'Other Option'),
(81, 2, 'Oat Milk', 2.00, 'Other Option'),
(82, 4, 'Hot', 0.00, 'Variation'),
(83, 4, 'Iced', 1.00, 'Variation'),
(84, 4, 'Extra Esspresso Shot', 3.00, 'Other Option'),
(85, 4, 'Oat Milk', 2.00, 'Other Option'),
(86, 56, 'Extra Esspresso Shot', 3.00, 'Add-on'),
(87, 9, 'Hot', 0.00, 'Variation'),
(88, 9, 'Iced', 1.00, 'Variation'),
(89, 9, 'Elderflower', 2.00, 'Flavor Syrup'),
(90, 9, 'Hazelnut', 2.00, 'Flavor Syrup'),
(91, 9, 'Honey', 2.00, 'Flavor Syrup'),
(92, 9, 'Lemon', 2.00, 'Flavor Syrup'),
(93, 9, 'Mint', 2.00, 'Flavor Syrup'),
(94, 9, 'Rose', 2.00, 'Flavor Syrup'),
(95, 9, 'Extra Esspresso Shot', 3.00, 'Add-on'),
(96, 10, 'Hot', 0.00, 'Variation'),
(97, 10, 'Iced', 1.00, 'Variation'),
(98, 10, 'Caramel', 2.00, 'Flavor Syrup'),
(99, 10, 'Honey', 2.00, 'Flavor Syrup'),
(100, 10, 'Chocolate (Mocha)', 2.00, 'Flavor Syrup'),
(101, 10, 'Rose', 2.00, 'Flavor Syrup'),
(102, 10, 'Macadami Nuts', 2.00, 'Flavor Syrup'),
(103, 10, 'Hazelnut', 2.00, 'Flavor Syrup'),
(104, 10, 'Extra Espresso Shot', 3.00, 'Other Option'),
(105, 10, 'Oat Milk', 2.00, 'Other Option'),
(106, 33, 'Serve now', 0.00, 'Serving Time'),
(107, 33, 'After Meal', 0.00, 'Serving Time'),
(108, 37, 'Serve now', 0.00, 'Serving Time'),
(109, 37, 'After meal', 0.00, 'Serving Time'),
(110, 34, 'Serve now', 0.00, 'Serving Time'),
(111, 34, 'After meal', 0.00, 'Serving Time'),
(112, 35, 'After Meal', 0.00, 'Serving Time'),
(113, 35, 'Serve now', 0.00, 'Serving Time'),
(114, 53, 'Serve now', 0.00, 'Serving Time'),
(115, 53, 'After Meal', 0.00, 'Serving Time'),
(116, 53, 'Takeaway', 0.00, 'Serving Time'),
(119, 38, 'Serve now', 0.00, 'Serving Time'),
(120, 38, 'After Meal', 0.00, 'Serving Time'),
(121, 39, 'Vanilla', 0.00, 'Ice Cream Selection'),
(122, 39, 'Taro/ Yam', 0.00, 'Ice Cream Selection'),
(123, 39, 'Mint', 0.00, 'Ice Cream Selection'),
(124, 39, 'Chocolate', 0.00, 'Ice Cream Selection'),
(125, 40, 'Serve now', 0.00, 'Serving Time'),
(126, 40, 'After Meal', 0.00, 'Serving Time'),
(127, 40, 'Vanilla', 3.00, 'Add-on Ice Cream'),
(128, 40, 'Chocolate', 3.00, 'Add-on Ice Cream'),
(129, 40, 'Taro/ Yam', 3.00, 'Add-on Ice Cream'),
(130, 40, 'Mint', 3.00, 'Add-on Ice Cream'),
(131, 41, 'Cream Cheese + Blueberry Sauce', 0.00, 'Flavor'),
(132, 41, 'Yam Ice Cream & Nuts', 1.00, 'Flavor'),
(133, 41, 'Chocolate Mint Ice Cream', 1.00, 'Flavor'),
(134, 42, 'Egg Mayo & Cheese', 0.00, 'Flavor'),
(135, 42, 'Chicken Loaf & Egg Mayo', 2.00, 'Flavor'),
(136, 57, 'Lemon Curd', 0.00, 'Flavor'),
(137, 57, 'Dark Chocolate', 0.00, 'Flavor'),
(138, 57, 'Homemade Blueberry', 0.00, 'Flavor'),
(139, 57, 'Strawberry', 0.00, 'Flavor'),
(140, 57, 'Serve now', 0.00, 'Serving Time'),
(141, 57, 'After Meal', 0.00, 'Serving Time'),
(142, 57, 'Vanilla', 3.00, 'Add-on Ice Cream'),
(143, 57, 'Taro/ Yam', 3.00, 'Add-on Ice Cream'),
(144, 57, 'Mint', 3.00, 'Add-on Ice Cream'),
(145, 57, 'Chocolate', 3.00, 'Add-on Ice Cream'),
(146, 11, 'Hot', 0.00, 'Variation'),
(147, 11, 'Iced', 1.00, 'Variation'),
(148, 12, 'Hot', 0.00, 'Variation'),
(149, 12, 'Iced', 1.00, 'Variation'),
(150, 13, 'Hot', 0.00, 'Variation'),
(151, 13, 'Iced', 1.00, 'Variation'),
(152, 14, 'Hot', 0.00, 'Variation'),
(153, 14, 'Iced', 1.00, 'Variation'),
(154, 15, 'Hot', 0.00, 'Variation'),
(155, 15, 'Iced', 1.00, 'Variation'),
(156, 16, 'Hot', 0.00, 'Variation'),
(157, 16, 'Iced', 1.00, 'Variation'),
(158, 17, 'Hot', 0.00, 'Variation'),
(159, 17, 'Iced', 1.00, 'Variation'),
(172, 49, 'Hot', 0.00, 'Variation'),
(173, 49, 'Iced', 1.00, 'Variation'),
(174, 49, 'Mint', 0.00, 'Flavor'),
(175, 49, 'Rose', 0.00, 'Flavor'),
(176, 49, 'Elderflower', 0.00, 'Flavor'),
(177, 49, 'Honey', 0.00, 'Flavor'),
(178, 51, 'Hot', 0.00, 'Variation'),
(179, 51, 'Iced', 1.00, 'Variation'),
(180, 52, 'Hot', 0.00, 'Variation'),
(181, 52, 'Iced', 1.00, 'Variation'),
(182, 45, 'Chili Sauce', 0.00, 'Condiments'),
(183, 45, 'Mayo', 0.00, 'Condiments'),
(184, 45, 'Toasted Mentai', 2.00, 'Condiments'),
(185, 46, 'Ginger in Vinegar', 0.00, 'Condiments'),
(186, 46, 'Chili Sauce', 0.00, 'Condiments'),
(187, 23, 'Original', 0.00, 'Flavor'),
(188, 23, 'Spicy', 0.00, 'Flavor'),
(189, 26, 'Original', 0.00, 'Flavor of Fried Chicken'),
(190, 26, 'Korean', 0.00, 'Flavor of Fried Chicken'),
(191, 26, 'Soy Garlic', 0.00, 'Flavor of Fried Chicken');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `name`, `price`, `category`, `is_available`, `image_path`) VALUES
(1, 'Iced Watermelon YURI Matcha Milk', 13.00, 'Niko Neko Japanese Tea', 1, '../images/1749831039_watermelon yuri.jpg'),
(2, 'YURI Matcha Milk', 11.00, 'Niko Neko Japanese Tea', 1, '../images/1749837682_yuri matcha milk.jpeg'),
(3, 'SUISEN Genmai Milk', 11.00, 'Niko Neko Japanese Tea', 1, '../images/1749830953_suisen genmai.jpg'),
(4, 'TSUBAKI Houjicha Milk', 11.00, 'Niko Neko Japanese Tea', 1, '../images/1749830990_hoijicha milkshake.jpeg'),
(5, 'YURI Matcha Milkshake', 13.00, 'Niko Neko Japanese Tea', 1, '../images/1749831065_yuri matcha milkshake.jpeg'),
(6, 'TSUBAKI Houjicha Chocolate Milkshake', 13.00, 'Niko Neko Japanese Tea', 1, '../images/1749830971_tsubaki houjicha.jpeg'),
(8, 'Aero Iced Black Coffee', 11.00, 'Espresso Coffee', 1, '../images/1749830248_dirty.jpeg'),
(9, 'Black Coffee', 9.00, 'Espresso Coffee', 1, '../images/1749830296_black coffee.jpeg'),
(10, 'White Milk Coffee', 10.00, 'Espresso Coffee', 1, '../images/1749830352_white milk coffee.jpeg'),
(11, 'Fresh Milk', 8.00, 'Fresh Milk Series', 1, '../images/1749830448_fresh milk.jpg'),
(12, 'Dark Sweet Chocolate Milk', 10.00, 'Fresh Milk Series', 1, '../images/1749830408_dark sweet chocolate milk.jpg'),
(13, 'Earl Grey Black Tea Milk', 10.00, 'Fresh Milk Series', 1, '../images/1749830431_earl grey.jpg'),
(14, 'Honey Milk', 10.00, 'Fresh Milk Series', 1, '../images/1749830497_honey milk.jpg'),
(15, 'Macadamia Nuts Syrup Milk', 10.00, 'Fresh Milk Series', 1, '../images/1749830515_macadamia-milk.webp'),
(16, 'Hazelnut Syrup Milk', 10.00, 'Fresh Milk Series', 1, '../images/1749830469_hazulnut syrup.webp'),
(17, 'Rose Milk', 10.00, 'Fresh Milk Series', 1, '../images/1749830534_rose milk.jpeg'),
(18, 'Iced Strawberry Milk', 11.00, 'Fresh Milk Series', 1, '../images/1749825280_strawberry milk.jpg'),
(19, 'Oreo', 13.00, 'Milkshake', 1, '../images/1749831381_milkshake selection.jpg'),
(20, 'Chocolate', 13.00, 'Milkshake', 1, '../images/1749831340_milkshake selection.jpg'),
(21, 'Mint Chocolate', 13.00, 'Milkshake', 1, '../images/1749831365_milkshake selection.jpg'),
(22, 'Strawberry', 13.00, 'Milkshake', 1, '../images/1749831398_milkshake selection.jpg'),
(23, 'Butter Chicken with Rice', 18.00, 'Mains', 1, '../images/1749830719_butterciken rice.jpg'),
(24, 'Nasi Lemak Ijo Ayam Goreng', 18.00, 'Mains', 1, '../images/1749830757_n.l ijo ayam grg.jpg'),
(25, 'Oyakodon', 18.00, 'Mains', 1, '../images/1749830810_oyakodpon.jpg'),
(26, 'Scallion Oil Rice Bowl with Chicken', 12.00, 'Mains', 1, '../images/1749830844_scallion oil  iken.jpeg'),
(27, 'Original Fried Chciken', 18.00, 'Mains', 1, '../images/1749830782_fried ciken.jpg'),
(28, 'Soy Garlic Fried Chciken', 18.00, 'Mains', 1, '../images/1749830899_soy garlic.jpg'),
(29, 'Korean Fried Chciken', 18.00, 'Mains', 1, '../images/1749830739_korean fried ciken.jpg'),
(31, 'Scallion Shrimp Ramen', 18.00, 'Mains', 1, '../images/1749830863_shrimp ramen.webp'),
(32, 'Signature Noodles and Egg', 10.00, 'Mains', 1, '../images/1749830884_signature noodle eggs.jpg'),
(33, 'Affogato (Espresso Coffee + Vanilla Ice Cream)', 11.00, 'Heyee Self-made Desserts', 1, '../images/1749826307_affogato.jpg'),
(34, 'Pistachio Baked Burnt Cheese Cake', 14.00, 'Heyee Self-made Desserts', 1, '../images/1749828061_pistachio bake burnt.jpg'),
(35, 'Yuri Matcha Cheese Cake', 13.00, 'Heyee Self-made Desserts', 1, '../images/1749830682_yuri matcha chesse cake.jpg'),
(37, 'Strawberry Cheese Cake', 13.00, 'Heyee Self-made Desserts', 1, '../images/1749830635_strawberry chesse.jpg'),
(38, 'Tiramisu Semifreddo', 14.00, 'Heyee Self-made Desserts', 1, '../images/1749830659_tiramisu.jpg'),
(39, 'Dark Chocolate Brownie Ice Cream', 14.00, 'Heyee Self-made Desserts', 1, '../images/1749830594_dark chocolate.jpg'),
(40, 'Honey Butter Cinnamon Roll', 10.00, 'Bakery', 1, '../images/1749822173_honey butter rolls.jpg'),
(41, 'Sweet Croissant', 12.00, 'Bakery', 1, '../images/1749829994_sweet croisant.jpg'),
(42, 'Savoury Croissant', 13.00, 'Bakery', 1, '../images/1749822271_savoury croissant.webp'),
(44, 'Fries', 10.00, 'Sides', 1, '../images/1749822453_fries.jpeg'),
(45, 'Fried Shrimp Gyoza', 11.00, 'Sides', 1, '../images/1749831209_fried shrimp.webp'),
(46, 'Shrimp Gyoza', 13.00, 'Sides', 1, '../images/1749831255_shrimp gyoza.jpeg'),
(47, 'Nuggets & Fries', 15.00, 'Sides', 1, '../images/1749831235_nugget and fries.jpg'),
(48, 'Iced Kombucha Selection', 10.00, 'Refreshment Soda', 1, '../images/1749831106_kombucha selection.jpg'),
(49, 'Lemonade Based Selection', 8.00, 'Refreshment Soda', 1, '../images/1749831123_lemonade selection.jpg'),
(50, 'Iced Lemonade Osmanthus Jelly Soda', 9.00, 'Refreshment Soda', 1, '../images/1749831145_lemonae watermelon.jpeg'),
(51, 'Black Tea Selection', 8.00, 'Tea Drinks', 1, '../images/1749831280_black tea.jpeg'),
(52, 'Green Tea Selection', 8.00, 'Tea Drinks', 1, '../images/1749831295_green tea selection.jpeg'),
(53, 'Mango Cheese Cake', 13.00, 'Heyee Self-made Desserts', 1, '../images/1749827661_mango cheesecake.jpg'),
(55, 'SUISEN Genmai Taro Milkshake', 13.00, 'Niko Neko Japanese Tea', 1, '../images/1749848700_taro milkshake.jpeg'),
(56, 'Dirty', 13.00, 'Espresso Coffee', 1, '../images/1749848754_dirty.jpeg'),
(57, 'Cookies Dough Tart', 10.00, 'Bakery', 1, '../images/1749850273_cookies dough tart.jpg'),
(58, 'Taro / Yam', 13.00, 'Milkshake', 1, '../images/1749852399_milkshake selection.jpg'),
(62, 'Beef Noodle Soup', 18.00, 'Mains', 1, '../images/1749852271_beef noodle soup.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price_at_order_time` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `item_id`, `quantity`, `price_at_order_time`) VALUES
(47, 37, 13, 1, 11.00),
(48, 37, 25, 1, 18.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_item_options`
--

CREATE TABLE `order_item_options` (
  `order_item_option_id` int(11) NOT NULL,
  `order_item_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item_options`
--

INSERT INTO `order_item_options` (`order_item_option_id`, `order_item_id`, `option_id`) VALUES
(13, 47, 151);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `receipt_path` varchar(255) NOT NULL,
  `payment_time` datetime DEFAULT current_timestamp(),
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `cust_order`
--
ALTER TABLE `cust_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `item_options`
--
ALTER TABLE `item_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `uniq_option` (`item_id`,`option_name`,`additional_price`,`option_type`);

--
-- Indexes for table `item_options_backup`
--
ALTER TABLE `item_options_backup`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `order_item_options`
--
ALTER TABLE `order_item_options`
  ADD PRIMARY KEY (`order_item_option_id`),
  ADD KEY `order_item_id` (`order_item_id`),
  ADD KEY `option_id` (`option_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cust_order`
--
ALTER TABLE `cust_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `item_options`
--
ALTER TABLE `item_options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `item_options_backup`
--
ALTER TABLE `item_options_backup`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `order_item_options`
--
ALTER TABLE `order_item_options`
  MODIFY `order_item_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item_options`
--
ALTER TABLE `item_options`
  ADD CONSTRAINT `fk_item` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`item_id`),
  ADD CONSTRAINT `item_options_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`item_id`);

--
-- Constraints for table `item_options_backup`
--
ALTER TABLE `item_options_backup`
  ADD CONSTRAINT `item_options_backup_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`item_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `cust_order` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`item_id`);

--
-- Constraints for table `order_item_options`
--
ALTER TABLE `order_item_options`
  ADD CONSTRAINT `order_item_options_ibfk_1` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`order_item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_options_ibfk_2` FOREIGN KEY (`option_id`) REFERENCES `item_options_backup` (`option_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `cust_order` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
