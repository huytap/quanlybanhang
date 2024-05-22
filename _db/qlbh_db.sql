-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 22, 2024 at 08:54 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlbh_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

DROP TABLE IF EXISTS `attributes`;
CREATE TABLE IF NOT EXISTS `attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `delete_flag` int DEFAULT '0',
  `type` int DEFAULT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `date_created`, `name`, `description`, `status`, `delete_flag`, `type`, `price`) VALUES
(2, '2024-05-15 14:07:36', 'L', 'Size L', 1, 0, 0, 5000),
(3, '2024-05-15 14:08:55', 'M', 'Size M', 1, 0, 0, 0),
(4, '2024-05-18 09:51:58', 'Khúc bạch', 'Khúc bạch', 1, 0, 1, 7000),
(5, '2024-05-18 09:59:04', 'Bánh Flan', 'Bánh Flan', 1, 0, 1, 7000),
(6, '2024-05-18 09:59:26', 'Trân châu trắng', 'Trân châu trắng', 1, 0, 1, 7000),
(7, '2024-05-18 09:59:42', 'Kem cheese', 'Kem cheese', 1, 0, 1, 7000),
(8, '2024-05-18 09:59:55', 'Phô mai tươi', 'Phô mai tươi', 1, 0, 1, 10000),
(9, '2024-05-18 10:00:08', 'Trân châu đen', 'Trân châu đen', 1, 0, 1, 5000),
(10, '2024-05-18 10:00:22', 'Kem trứng', 'Kem trứng', 1, 0, 1, 7000);

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

DROP TABLE IF EXISTS `category_list`;
CREATE TABLE IF NOT EXISTS `category_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `has_attribute` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `description`, `has_attribute`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Cafe', 'Coffee', 0, 1, 0, '2022-04-22 09:59:46', '2024-05-07 20:46:46'),
(2, 'Trà Sữa', 'Trà Sữa', 1, 1, 0, '2022-04-22 10:01:06', '2024-05-15 15:39:01'),
(3, 'M', 'Size M', 0, 1, 1, '2024-05-15 13:53:42', '2024-05-15 13:53:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

DROP TABLE IF EXISTS `product_attributes`;
CREATE TABLE IF NOT EXISTS `product_attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `attribute_id` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `attribute_id`, `price`, `date_created`, `delete_flag`) VALUES
(1, 10, 3, 1115, '2024-05-15 14:48:04', 0),
(2, 10, 2, 2225, '2024-05-15 14:48:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

DROP TABLE IF EXISTS `product_list`;
CREATE TABLE IF NOT EXISTS `product_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `price` float(15,2) NOT NULL DEFAULT '0.00',
  `upsize` float DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `category_id`, `name`, `description`, `price`, `upsize`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 1, 'Arabica', 'Arabica is the most popular type of bean used for coffee. Arabica beans are considered higher quality than Robusta, and they\'re also more expensive.', 150.00, NULL, 1, 1, '2022-04-22 10:16:50', '2022-04-22 10:22:07'),
(2, 1, 'Robusta', 'Robusta beans are typically cheaper to produce because the Robusta plant is easier to grow.', 145.00, NULL, 1, 1, '2022-04-22 10:17:20', '2022-04-22 10:22:11'),
(3, 1, 'Cafe đen', 'Bạc xỉu', 15000.00, NULL, 1, 0, '2022-04-22 10:17:54', '2024-05-18 10:32:44'),
(4, 1, 'Bạc xỉu', 'Bạc xỉu', 17000.00, NULL, 1, 0, '2022-04-22 10:18:15', '2024-05-18 10:32:27'),
(5, 1, 'Cacao Sữa', 'Cacao Sữa', 30000.00, NULL, 1, 0, '2022-04-22 10:19:18', '2024-05-18 10:15:13'),
(6, 1, 'Cafe muối', 'Cafe muối', 20000.00, NULL, 1, 0, '2022-04-22 10:19:47', '2024-05-18 10:32:16'),
(7, 1, 'Cafe sữa', 'This espresso-based drink is similar to a latte, but the frothy top layer is thicker. The standard ratio is equal parts espresso, steamed milk, and foam. It\'s often served in a 6-ounce cup (smaller than a latte cup) and can be topped with a sprinkling of cinnamon.', 15000.00, NULL, 1, 0, '2022-04-22 10:20:06', '2024-05-07 20:47:29'),
(8, 2, 'Trà sữa kem Cheese', 'Trà sữa kem Cheese', 25000.00, NULL, 1, 0, '2022-04-22 10:20:26', '2024-05-18 10:35:01'),
(9, 2, 'Trà thái xanh', 'Trà sữa thái xanh', 20000.00, 1, 1, 0, '2022-04-22 10:20:53', '2024-05-18 10:34:19'),
(10, 2, 'Hồng trà sữa', 'Hồng trà sữa', 20000.00, 1, 1, 0, '2022-04-22 10:21:17', '2024-05-18 10:33:33'),
(11, 2, 'Trà sữa kem trứng', 'Trà sữa kem trứng', 25000.00, 1, 1, 0, '2022-04-22 10:21:42', '2024-05-18 10:34:42'),
(13, 2, 'Trà sữa Đài Loan', 'Trà sữa Đài Loan', 30000.00, 2, 1, 0, '2024-05-18 10:36:32', '2024-05-18 10:36:37'),
(14, 2, 'Sữa tươi trân châu đường đen', 'Sữa tươi trân châu đường đen', 25000.00, 1, 1, 0, '2024-05-18 10:36:59', '2024-05-18 10:38:25');

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `product_ids` text,
  `product_type` varchar(100) DEFAULT NULL,
  `discount_type` varchar(100) DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `buy` int DEFAULT NULL,
  `gift` int DEFAULT NULL,
  `min_amount` float DEFAULT NULL,
  `delete_flag` int NOT NULL DEFAULT '0',
  `status` int DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `promotion`
--

INSERT INTO `promotion` (`id`, `name`, `description`, `from_date`, `to_date`, `product_ids`, `product_type`, `discount_type`, `discount`, `buy`, `gift`, `min_amount`, `delete_flag`, `status`, `date_created`, `date_updated`, `updated_by`) VALUES
(1, 'Mua 1 tặng 1 nhân dịp khai trương', 'Mua 1 tặng 1 nhân dịp khai trương', '2024-05-26', '2024-05-27', '[\"6\"]', 'SAME', 'PRODUCT', 0, 1, 1, 0, 0, 1, '2024-05-21 13:28:07', '2024-05-22 15:49:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promotion_code`
--

DROP TABLE IF EXISTS `promotion_code`;
CREATE TABLE IF NOT EXISTS `promotion_code` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `type` int DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `min_amount` float DEFAULT NULL,
  `product_type` int DEFAULT NULL,
  `product_ids` text,
  `quantity` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `delete_flag` int DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `promotion_code`
--

INSERT INTO `promotion_code` (`id`, `code`, `name`, `description`, `from_date`, `to_date`, `type`, `discount`, `min_amount`, `product_type`, `product_ids`, `quantity`, `status`, `delete_flag`, `date_created`, `date_updated`, `updated_by`) VALUES
(1, 'HFBGCDEG', 'Mua 1 tặng 1 nhân dịp khai trương', 'Mua 1 tặng 1 nhân dịp khai trương', '2024-05-26', '2024-05-27', 2, 1, 0, NULL, NULL, 1000, 1, 0, '2024-05-20 15:06:17', '2024-05-20 15:09:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sale_attributes`
--

DROP TABLE IF EXISTS `sale_attributes`;
CREATE TABLE IF NOT EXISTS `sale_attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sale_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `attribute_id` int DEFAULT NULL,
  `sale_product_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_list`
--

DROP TABLE IF EXISTS `sale_list`;
CREATE TABLE IF NOT EXISTS `sale_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `promotion_id` int DEFAULT NULL,
  `code` varchar(100) NOT NULL,
  `client_name` text NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `amount` float(15,2) NOT NULL DEFAULT '0.00',
  `tendered` float(15,2) NOT NULL DEFAULT '0.00',
  `surplus_amount` float DEFAULT NULL,
  `no_receive_change` int DEFAULT NULL,
  `payment_type` tinyint(1) NOT NULL COMMENT '1 = Tiền mặt,\r\n2 = Chuyển khoản,\r\n3 = Credit Card',
  `payment_code` text,
  `status` int DEFAULT NULL,
  `type` int DEFAULT NULL,
  `total_received` float DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sale_list`
--

INSERT INTO `sale_list` (`id`, `user_id`, `promotion_id`, `code`, `client_name`, `phone_number`, `amount`, `tendered`, `surplus_amount`, `no_receive_change`, `payment_type`, `payment_code`, `status`, `type`, `total_received`, `date_created`, `date_updated`) VALUES
(1, 1, NULL, '202204220001', 'Guest', NULL, 710.00, 1000.00, NULL, NULL, 1, '', NULL, NULL, NULL, '2022-04-22 13:54:44', '2022-04-22 13:54:44'),
(2, 2, NULL, '202204220002', 'Guest', NULL, 675.00, 700.00, NULL, NULL, 2, '123121ABcdF', NULL, NULL, NULL, '2022-04-22 15:27:02', '2022-04-22 15:27:02'),
(3, 1, NULL, '202405070001', 'Guest', NULL, 48000.00, 0.00, NULL, NULL, 1, '', NULL, NULL, NULL, '2024-05-07 20:50:16', '2024-05-07 20:50:16'),
(5, 1, NULL, '202405140001', 'Guest', NULL, 96000.00, 100000.00, NULL, NULL, 1, '', 1, NULL, NULL, '2024-05-14 15:29:14', '2024-05-20 13:37:17'),
(7, 1, NULL, '202405180001', 'Guest', NULL, 18000.00, 0.00, NULL, NULL, 1, '', NULL, NULL, NULL, '2024-05-18 08:11:16', '2024-05-18 08:11:16'),
(8, 1, NULL, '202405180002', 'Guest', NULL, 15000.00, 20000.00, NULL, NULL, 1, '', 1, NULL, NULL, '2024-05-18 08:30:28', '2024-05-21 15:28:47'),
(9, 1, 1, '202405220001', 'Guest', NULL, 85000.00, 100000.00, NULL, NULL, 1, '', 1, NULL, NULL, '2024-05-22 12:54:25', '2024-05-22 14:19:58'),
(10, 1, 1, '202405220002', 'Guest', NULL, 20000.00, 0.00, NULL, NULL, 0, NULL, 0, NULL, NULL, '2024-05-22 14:53:49', '2024-05-22 14:53:49'),
(11, 1, 1, '202405220003', 'Guest', NULL, 20000.00, 0.00, NULL, NULL, 0, NULL, 0, NULL, NULL, '2024-05-22 14:53:56', '2024-05-22 14:53:56'),
(14, 1, 1, '202405220004', 'Guest', NULL, 20000.00, 0.00, NULL, NULL, 0, NULL, 0, NULL, NULL, '2024-05-22 15:01:46', '2024-05-22 15:01:46'),
(15, 1, 1, '202405220005', 'Guest', NULL, 20000.00, 0.00, NULL, NULL, 0, NULL, 0, NULL, NULL, '2024-05-22 15:02:28', '2024-05-22 15:02:28'),
(16, 1, 1, '202405220006', 'Guest', NULL, 20000.00, 0.00, NULL, NULL, 0, NULL, 0, NULL, NULL, '2024-05-22 15:03:58', '2024-05-22 15:03:58'),
(17, 1, 1, '202405220007', 'Guest', NULL, 20000.00, 0.00, NULL, NULL, 0, NULL, 0, NULL, NULL, '2024-05-22 15:05:30', '2024-05-22 15:05:30'),
(18, 1, 1, '202405220008', 'Guest', NULL, 32000.00, 0.00, NULL, NULL, 0, NULL, 0, NULL, NULL, '2024-05-22 15:06:13', '2024-05-22 15:34:31'),
(19, 1, NULL, '202405220009', 'Guest', '', 42000.00, 0.00, NULL, NULL, 0, NULL, 0, NULL, NULL, '2024-05-22 15:50:18', '2024-05-22 15:50:18');

-- --------------------------------------------------------

--
-- Table structure for table `sale_products`
--

DROP TABLE IF EXISTS `sale_products`;
CREATE TABLE IF NOT EXISTS `sale_products` (
  `sale_id` int NOT NULL,
  `product_id` int NOT NULL,
  `qty` int NOT NULL,
  `price` float(15,2) NOT NULL DEFAULT '0.00',
  `attribute_id` text,
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sale_products`
--

INSERT INTO `sale_products` (`sale_id`, `product_id`, `qty`, `price`, `attribute_id`) VALUES
(1, 11, 3, 140.00, NULL),
(1, 10, 2, 145.00, NULL),
(2, 9, 1, 150.00, NULL),
(2, 3, 3, 75.00, NULL),
(2, 8, 2, 150.00, NULL),
(3, 4, 2, 18000.00, NULL),
(3, 3, 1, 12000.00, NULL),
(7, 4, 1, 18000.00, NULL),
(8, 7, 1, 15000.00, NULL),
(1, 13, 1, 11.00, NULL),
(1, 11, 1, 11.00, NULL),
(5, 4, 3, 18000.00, NULL),
(5, 3, 1, 12000.00, NULL),
(5, 7, 2, 15000.00, NULL),
(9, 4, 5, 17000.00, NULL),
(9, 4, 5, 0.00, NULL),
(18, 10, 1, 32000.00, '3,9,4'),
(18, 10, 1, 0.00, '3,9,4'),
(19, 4, 1, 17000.00, ''),
(19, 10, 1, 25000.00, '3,9');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

DROP TABLE IF EXISTS `system_info`;
CREATE TABLE IF NOT EXISTS `system_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'SKUN'),
(6, 'short_name', 'BAKERY - CAFE - MILK TEA'),
(11, 'logo', 'uploads/logo.png?v=1650590302'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1715094685');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/1.png?v=1649834664', NULL, 1, '2021-01-20 14:02:37', '2022-04-13 15:24:24'),
(2, 'Mark', 'Cooper', 'mcooper', '0c4635c5af0f173c26b0d85b6c9b398b', 'uploads/avatars/2.png?v=1650520142', NULL, 3, '2022-04-21 13:49:02', '2022-04-21 13:49:54'),
(4, 'Johnny', 'Smith', 'jsmith', '202cb962ac59075b964b07152d234b70', 'uploads/avatars/4.png?v=1650531008', NULL, 2, '2022-04-21 16:50:08', '2024-05-07 22:06:21');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_list`
--
ALTER TABLE `product_list`
  ADD CONSTRAINT `category_id_fk_pl` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_list`
--
ALTER TABLE `sale_list`
  ADD CONSTRAINT `user_id_fk_sl` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sale_products`
--
ALTER TABLE `sale_products`
  ADD CONSTRAINT `product_id_fk_sp` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_id_fk_sp` FOREIGN KEY (`sale_id`) REFERENCES `sale_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
