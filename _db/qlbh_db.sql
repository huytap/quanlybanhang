-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 27, 2024 at 03:09 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

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
  `category_ids` json DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `delete_flag` int DEFAULT '0',
  `type` int DEFAULT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `category_ids`, `date_created`, `name`, `description`, `status`, `delete_flag`, `type`, `price`) VALUES
(2, '[\"2\"]', '2024-05-15 14:07:36', 'L', 'Size L', 1, 0, 0, 5000),
(3, '[\"2\"]', '2024-05-15 14:08:55', 'M', 'Size M', 1, 0, 0, 0),
(4, '[\"2\", \"5\", \"6\"]', '2024-05-18 09:51:58', 'Khúc bạch', 'Khúc bạch', 1, 0, 1, 7000),
(5, '[\"2\", \"5\", \"6\"]', '2024-05-18 09:59:04', 'Bánh Flan', 'Bánh Flan', 1, 0, 1, 7000),
(6, NULL, '2024-05-18 09:59:26', 'Trân châu trắng', 'Trân châu trắng', 1, 0, 1, 7000),
(7, NULL, '2024-05-18 09:59:42', 'Kem cheese', 'Kem cheese', 1, 0, 1, 7000),
(8, NULL, '2024-05-18 09:59:55', 'Phô mai tươi', 'Phô mai tươi', 1, 0, 1, 10000),
(9, NULL, '2024-05-18 10:00:08', 'Trân châu đen', 'Trân châu đen', 1, 0, 1, 5000),
(10, NULL, '2024-05-18 10:00:22', 'Kem trứng', 'Kem trứng', 1, 0, 1, 7000),
(11, NULL, '2024-05-26 23:51:13', 'Ít đường', 'Ít đường', 1, 0, 3, 0),
(12, NULL, '2024-05-26 23:51:35', 'Không đá', 'Không đá', 1, 0, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `attribute_categories`
--

DROP TABLE IF EXISTS `attribute_categories`;
CREATE TABLE IF NOT EXISTS `attribute_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_ids` json DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `status` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attribute_categories`
--

INSERT INTO `attribute_categories` (`id`, `category_ids`, `name`, `status`) VALUES
(1, NULL, 'Size', 0),
(2, NULL, 'Topping', 0),
(3, NULL, 'Mức đá', 0),
(4, NULL, 'Mức đường', 0);

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
  `attribute_id` json DEFAULT NULL,
  `has_print_tem` int DEFAULT NULL,
  `group_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `description`, `has_attribute`, `status`, `delete_flag`, `date_created`, `date_updated`, `attribute_id`, `has_print_tem`, `group_id`) VALUES
(1, 'Cafe', 'Coffee', 0, 1, 0, '2022-04-22 09:59:46', '2024-06-10 15:08:16', NULL, 1, 2),
(2, 'Trà sữa', 'Trà sữa', 1, 1, 0, '2022-04-22 10:01:06', '2024-06-01 00:10:36', NULL, 1, NULL),
(4, 'Bánh kem', 'Bánh kem', 1, 1, 0, '2024-05-22 22:02:28', '2024-06-10 15:08:10', NULL, 1, 1),
(5, 'Trà trái cây', 'Trà trái cây', 0, 1, 0, '2024-05-22 22:02:53', '2024-06-01 00:10:33', NULL, 1, NULL),
(6, 'Nước ép', 'Nước ép', 0, 1, 0, '2024-05-22 22:03:09', '2024-06-10 15:09:14', NULL, 1, 2),
(7, 'Yogurt', 'Yogurt', 0, 1, 0, '2024-05-22 22:07:42', '2024-06-01 00:10:45', NULL, 1, NULL),
(8, 'Kem', 'Kem', 0, 1, 0, '2024-05-22 22:09:57', '2024-06-10 15:09:08', NULL, 0, 3);

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
  `attribute_category` json DEFAULT NULL,
  `unit` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `category_id`, `name`, `description`, `price`, `upsize`, `status`, `delete_flag`, `date_created`, `date_updated`, `attribute_category`, `unit`) VALUES
(1, 1, 'Arabica', 'Arabica is the most popular type of bean used for coffee. Arabica beans are considered higher quality than Robusta, and they\'re also more expensive.', 150.00, NULL, 1, 1, '2022-04-22 10:16:50', '2022-04-22 10:22:07', NULL, NULL),
(2, 1, 'Robusta', 'Robusta beans are typically cheaper to produce because the Robusta plant is easier to grow.', 145.00, NULL, 1, 1, '2022-04-22 10:17:20', '2022-04-22 10:22:11', NULL, NULL),
(3, 1, 'Cafe đen', 'Bạc xỉu', 15000.00, NULL, 1, 0, '2022-04-22 10:17:54', '2024-06-03 14:41:32', '[\"2\", \"3\"]', 2),
(4, 1, 'Bạc xỉu', 'Bạc xỉu', 17000.00, 0, 1, 0, '2022-04-22 10:18:15', '2024-06-03 15:30:16', '[\"2\", \"3\"]', 2),
(5, 1, 'Cacao Sữa', 'Cacao Sữa', 30000.00, NULL, 1, 0, '2022-04-22 10:19:18', '2024-06-03 14:41:23', '[\"2\", \"3\"]', 2),
(6, 1, 'Cafe muối', 'Cafe muối', 20000.00, NULL, 1, 0, '2022-04-22 10:19:47', '2024-06-03 14:41:37', NULL, 2),
(7, 1, 'Cafe sữa', 'This espresso-based drink is similar to a latte, but the frothy top layer is thicker. The standard ratio is equal parts espresso, steamed milk, and foam. It\'s often served in a 6-ounce cup (smaller than a latte cup) and can be topped with a sprinkling of cinnamon.', 15000.00, NULL, 1, 0, '2022-04-22 10:20:06', '2024-06-03 14:41:42', NULL, 2),
(8, 2, 'Trà sữa kem Cheese', 'Trà sữa kem Cheese', 25000.00, NULL, 1, 0, '2022-04-22 10:20:26', '2024-05-18 10:35:01', NULL, NULL),
(9, 2, 'Trà thái xanh', 'Trà sữa thái xanh', 20000.00, 1, 1, 0, '2022-04-22 10:20:53', '2024-05-18 10:34:19', NULL, NULL),
(10, 2, 'Hồng trà sữa', 'Hồng trà sữa', 20000.00, 1, 1, 0, '2022-04-22 10:21:17', '2024-06-03 15:30:24', NULL, 2),
(11, 2, 'Trà sữa kem trứng', 'Trà sữa kem trứng', 25000.00, 1, 1, 0, '2022-04-22 10:21:42', '2024-05-18 10:34:42', NULL, NULL),
(13, 2, 'Trà sữa Đài Loan', 'Trà sữa Đài Loan', 30000.00, 2, 1, 0, '2024-05-18 10:36:32', '2024-05-27 01:29:14', '[\"0\", \"1\", \"2\", \"3\"]', NULL),
(14, 2, 'Sữa tươi trân châu đường đen', 'Sữa tươi trân châu đường đen', 25000.00, 1, 1, 0, '2024-05-18 10:36:59', '2024-05-27 06:57:11', '[\"0\", \"1\", \"2\", \"3\"]', NULL),
(15, 5, 'Trà vải', 'Trà vải', 30000.00, NULL, 1, 0, '2024-05-22 22:03:43', '2024-05-22 22:03:43', NULL, NULL),
(16, 5, 'Trà đào cam sả', 'Trà đào cam sả', 30000.00, NULL, 1, 0, '2024-05-22 22:03:58', '2024-05-22 22:03:58', NULL, NULL),
(17, 5, 'Trà việt quất', 'Trà việt quất', 30000.00, NULL, 1, 0, '2024-05-22 22:04:15', '2024-05-22 22:04:15', NULL, NULL),
(18, 5, 'Trà chanh dây', 'Trà chanh dây', 30000.00, NULL, 1, 0, '2024-05-22 22:04:37', '2024-05-22 22:04:37', NULL, NULL),
(19, 5, 'Trà dâu tây', 'Trà dâu tây', 30000.00, NULL, 1, 0, '2024-05-22 22:04:53', '2024-05-22 22:04:53', NULL, NULL),
(20, 5, 'Trà ổi', 'Trà ổi', 30000.00, NULL, 1, 0, '2024-05-22 22:05:06', '2024-05-22 22:05:06', NULL, NULL),
(21, 5, 'Trà chanh', 'Trà chanh', 15000.00, NULL, 1, 0, '2024-05-22 22:05:27', '2024-05-22 22:05:27', NULL, NULL),
(22, 5, 'Trà tắc', 'Trà tắc', 15000.00, NULL, 1, 0, '2024-05-22 22:05:37', '2024-05-22 22:05:37', NULL, NULL),
(23, 6, 'Cam', 'Cam', 20000.00, NULL, 1, 0, '2024-05-22 22:05:54', '2024-06-03 15:30:02', NULL, 2),
(24, 6, 'Ổi', 'Ổi', 25000.00, NULL, 1, 0, '2024-05-22 22:06:07', '2024-05-22 22:06:07', NULL, NULL),
(25, 6, 'Cà rốt', 'Cà rốt', 25000.00, NULL, 1, 0, '2024-05-22 22:06:17', '2024-06-03 15:29:55', '[\"1\", \"2\", \"3\"]', 2),
(26, 6, 'Cam cà rốt', 'Cam cà rốt', 25000.00, NULL, 1, 0, '2024-05-22 22:06:33', '2024-05-22 22:06:33', NULL, NULL),
(27, 6, 'Dưa hấu', 'Dưa hấu', 25000.00, NULL, 1, 0, '2024-05-22 22:06:47', '2024-05-22 22:06:47', NULL, NULL),
(28, 6, 'Thơm', 'Thơm', 25000.00, NULL, 1, 0, '2024-05-22 22:06:55', '2024-05-22 22:06:55', NULL, NULL),
(29, 5, 'Táo', 'Táo', 35000.00, NULL, 1, 0, '2024-05-22 22:07:09', '2024-05-22 22:07:09', NULL, NULL),
(30, 6, 'Lựu', 'Lựu', 35000.00, NULL, 1, 0, '2024-05-22 22:07:21', '2024-05-22 22:07:21', NULL, NULL),
(31, 7, 'Dâu', 'Dâu', 30000.00, NULL, 1, 0, '2024-05-22 22:08:10', '2024-05-22 22:08:10', NULL, NULL),
(32, 7, 'Chanh dây', 'Chanh dây', 30000.00, NULL, 1, 0, '2024-05-22 22:08:26', '2024-05-22 22:08:26', NULL, NULL),
(33, 7, 'Việt quất', 'Việt quất', 30000.00, NULL, 1, 0, '2024-05-22 22:09:15', '2024-05-22 22:09:15', NULL, NULL),
(34, 7, 'Nha đam', 'Nha đam', 30000.00, NULL, 1, 0, '2024-05-22 22:09:28', '2024-05-22 22:09:28', NULL, NULL),
(35, 7, 'Dừa non', 'Dừa non', 30000.00, NULL, 1, 0, '2024-05-22 22:09:40', '2024-05-22 22:09:40', NULL, NULL),
(36, 8, '3 viên', '3 viên', 35000.00, NULL, 1, 0, '2024-05-22 22:10:10', '2024-05-22 22:10:10', NULL, NULL);

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
  `category_apply` json DEFAULT NULL,
  `delete_flag` int NOT NULL DEFAULT '0',
  `status` int DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `promotion`
--

INSERT INTO `promotion` (`id`, `name`, `description`, `from_date`, `to_date`, `product_ids`, `product_type`, `discount_type`, `discount`, `buy`, `gift`, `min_amount`, `category_apply`, `delete_flag`, `status`, `date_created`, `date_updated`, `updated_by`) VALUES
(1, 'Mua 1 tặng 1 nhân dịp khai trương', 'Mua 1 tặng 1 nhân dịp khai trương', '2024-05-22', '2024-05-27', '[\"10\",\"16\",\"20\"]', 'SAME', 'PRODUCT', 0, 1, 1, 0, '[\"1\", \"4\", \"7\", \"8\"]', 0, 1, '2024-05-21 13:28:07', '2024-05-25 23:20:00', NULL),
(2, 'Mua 1 tặng 1', 'Mua 1 tặng 1', '2024-05-25', '2024-05-27', '[\"10\",\"16\",\"20\"]', 'LIST', 'PRODUCT', 0, 1, 1, 1, '[\"2\", \"5\", \"6\"]', 0, 1, '2024-05-25 23:42:07', '2024-05-25 23:42:07', NULL),
(3, 'Tặng bánh Donut cho đơn hàng trên 100k', 'Tặng bánh Donut cho đơn hàng trên 100k', '2024-05-31', '2024-06-01', '[\"36\"]', 'LIST', 'PRODUCT', 0, 0, 0, 100000, '[\"1\", \"2\", \"4\", \"5\", \"6\", \"7\", \"8\"]', 0, 1, '2024-05-31 23:28:17', '2024-05-31 23:47:26', NULL),
(4, 'Mua 10 ly tặng 1 ly', 'Mua 10 ly tặng 1 ly', '2024-06-02', '2024-06-30', '[\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"29\",\"24\",\"25\",\"26\",\"27\",\"28\",\"23\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\"]', 'LIST', 'PRODUCT', 0, 2, 1, 0, '[\"1\", \"2\", \"5\", \"6\"]', 0, 1, '2024-06-02 14:09:45', '2024-06-02 14:15:07', NULL);

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
  `order_type` int DEFAULT NULL,
  `payment_code` text,
  `status` int DEFAULT NULL,
  `type` int DEFAULT NULL,
  `total_received` float DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_flag` int NOT NULL DEFAULT '0',
  `time_shipping` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sale_list`
--

INSERT INTO `sale_list` (`id`, `user_id`, `promotion_id`, `code`, `client_name`, `phone_number`, `amount`, `tendered`, `surplus_amount`, `no_receive_change`, `payment_type`, `order_type`, `payment_code`, `status`, `type`, `total_received`, `date_created`, `date_updated`, `deleted_flag`, `time_shipping`) VALUES
(1, 1, 1, '202405220001', 'Guest', '0982007996', 152000.00, 500000.00, NULL, NULL, 1, NULL, '', 1, NULL, NULL, '2024-05-22 22:35:44', '2024-05-22 22:42:49', 0, NULL),
(2, 1, 1, '202405230001', 'Guest', '', 25000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-23 08:15:17', '2024-05-23 08:15:17', 0, NULL),
(3, 1, 2, '202405260001', 'Guest', '', 25000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-26 00:38:10', '2024-05-26 00:38:10', 0, NULL),
(4, 1, 2, '202405260002', 'Guest', '', 25000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-26 00:38:16', '2024-05-26 00:38:16', 0, NULL),
(5, 1, 2, '202405260003', 'Guest', '', 25000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-26 00:40:45', '2024-05-26 00:40:45', 0, NULL),
(6, 1, 2, '202405260004', 'Guest', '', 42000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-26 00:45:10', '2024-05-26 00:45:46', 0, NULL),
(7, 1, 2, '202405260005', 'Guest', '', 30000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-26 00:55:13', '2024-05-26 00:55:13', 0, NULL),
(8, 1, 2, '202405260006', 'Guest', '', 25000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-26 02:06:27', '2024-05-26 02:06:27', 0, NULL),
(9, 1, 2, '202405260007', 'Guest', '', 44000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-26 02:14:13', '2024-05-26 02:14:13', 0, NULL),
(10, 1, 2, '202405260008', 'Guest', '', 45000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-26 06:58:55', '2024-05-26 06:58:55', 0, NULL),
(11, 1, 2, '202405260009', 'Guest', '', 45000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-26 06:58:59', '2024-05-26 06:58:59', 0, NULL),
(12, 1, 2, '202405260010', 'Guest', '', 45000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-26 06:59:32', '2024-05-26 06:59:32', 0, NULL),
(13, 1, 2, '202405260011', 'Guest', '', 55000.00, 0.00, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-05-26 07:00:29', '2024-05-26 07:40:43', 1, NULL),
(15, 1, 2, '202405260013', 'Guest', '', 75000.00, 100000.00, NULL, NULL, 1, 0, NULL, 1, NULL, NULL, '2024-05-26 07:17:49', '2024-05-26 07:17:49', 0, NULL),
(16, 1, 2, '202405260012', 'Guest', '', 25000.00, 100000.00, NULL, NULL, 1, 0, NULL, 1, NULL, NULL, '2024-05-26 07:29:35', '2024-05-26 07:29:35', 0, NULL),
(17, 1, 2, '202405260014', 'Guest', '', 55000.00, 100000.00, NULL, NULL, 1, 0, NULL, 1, NULL, NULL, '2024-05-26 23:23:24', '2024-05-26 23:34:05', 0, NULL),
(18, 1, 2, '202405270001', 'Guest', '', 17000.00, 0.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-05-27 01:41:29', '2024-05-27 01:41:29', 0, NULL),
(19, 1, 2, '202405270002', 'Guest', '', 32000.00, 0.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-05-27 01:42:23', '2024-05-27 01:42:23', 0, NULL),
(20, 1, 2, '202405270003', 'Guest', '', 39000.00, 39000.00, NULL, NULL, 1, 0, NULL, 1, NULL, NULL, '2024-05-27 02:31:00', '2024-05-27 02:31:00', 0, NULL),
(21, 1, 2, '202405270004', 'Guest', '', 17000.00, 0.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-05-27 06:53:27', '2024-05-27 06:53:27', 0, NULL),
(22, 1, 2, '202405270005', 'Guest', '', 45000.00, 30000.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-05-27 06:57:32', '2024-05-27 06:57:56', 0, NULL),
(23, 1, 2, '202405270006', 'Guest', '', 50000.00, 0.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-05-27 06:58:38', '2024-05-27 06:58:38', 0, NULL),
(24, 1, NULL, '202405280001', 'Guest', '', 39000.00, 0.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-05-28 21:53:43', '2024-05-28 21:53:43', 0, NULL),
(25, 1, NULL, '202405280002', 'Guest', '', 62000.00, 0.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-05-28 22:36:42', '2024-05-28 22:36:42', 0, NULL),
(26, 1, NULL, '202405290001', 'Guest', '', 17000.00, 0.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-05-29 23:17:32', '2024-05-29 23:17:32', 0, NULL),
(27, 2, NULL, '202405290002', 'Guest', '', 35000.00, 0.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-05-29 23:19:57', '2024-05-29 23:19:57', 0, NULL),
(28, 1, 3, '202405310001', 'Guest', '', 105000.00, 0.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-05-31 23:48:04', '2024-05-31 23:48:04', 0, NULL),
(29, 1, 3, '202406010001', 'Guest', '', 52000.00, 0.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-06-01 00:10:58', '2024-06-01 00:10:58', 0, NULL),
(30, 1, 4, '202406020001', 'Guest', '', 84000.00, 0.00, NULL, NULL, 1, 0, NULL, 0, NULL, NULL, '2024-06-02 15:34:28', '2024-06-02 15:34:28', 0, '');

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
(1, 14, 3, 39000.00, '3,4,5'),
(1, 14, 3, 0.00, '3,4,5'),
(1, 14, 1, 35000.00, '3,8'),
(1, 14, 1, 0.00, '3,8'),
(2, 10, 1, 25000.00, '3,9'),
(2, 10, 1, 0.00, '3,9'),
(6, 25, 1, 25000.00, ''),
(6, 20, 1, 0.00, ''),
(6, 4, 1, 17000.00, ''),
(6, 4, 1, 0.00, ''),
(7, 13, 1, 30000.00, '3'),
(7, 16, 1, 0.00, '3'),
(8, 14, 1, 25000.00, ''),
(8, 16, 1, 0.00, '3'),
(9, 14, 1, 44000.00, '3,9,4,5'),
(9, 16, 1, 0.00, ''),
(10, 10, 1, 20000.00, '3'),
(10, 10, 1, 0.00, '3'),
(10, 11, 1, 0.00, '3'),
(10, 10, 0, 0.00, ''),
(11, 10, 1, 20000.00, '3'),
(11, 10, 1, 0.00, '3'),
(11, 11, 1, 0.00, '3'),
(11, 10, 0, 0.00, ''),
(12, 10, 1, 20000.00, '3'),
(12, 10, 1, 0.00, '3'),
(12, 11, 1, 0.00, '3'),
(13, 13, 1, 30000.00, '3'),
(13, 10, 1, 0.00, '3'),
(13, 14, 1, 0.00, '3'),
(15, 25, 1, 25000.00, ''),
(15, 10, 1, 0.00, ''),
(15, 25, 1, 25000.00, ''),
(15, 10, 1, 0.00, ''),
(15, 25, 1, 25000.00, ''),
(15, 10, 1, 0.00, ''),
(16, 25, 1, 25000.00, ''),
(16, 10, 1, 0.00, ''),
(17, 14, 1, 30000.00, '3,9'),
(17, 10, 1, 0.00, '3'),
(17, 25, 1, 25000.00, ''),
(17, 10, 1, 0.00, ''),
(18, 4, 1, 17000.00, '12,11'),
(18, 4, 1, 0.00, '12,11'),
(19, 4, 1, 17000.00, '12'),
(19, 4, 1, 0.00, '12'),
(19, 7, 1, 15000.00, ''),
(19, 7, 1, 0.00, ''),
(20, 25, 1, 39000.00, '4,5,12'),
(20, 10, 1, 0.00, '4'),
(21, 4, 1, 17000.00, ''),
(21, 4, 1, 0.00, ''),
(22, 14, 1, 30000.00, '3,9,12'),
(22, 10, 1, 0.00, '3'),
(22, 21, 1, 15000.00, ''),
(22, 10, 1, 0.00, ''),
(23, 14, 1, 30000.00, '3,9,12'),
(23, 10, 1, 0.00, '3'),
(23, 23, 1, 20000.00, ''),
(23, 10, 1, 0.00, ''),
(24, 14, 1, 39000.00, '3,4,5,12'),
(25, 5, 1, 30000.00, ''),
(25, 14, 1, 32000.00, '3,6,12,11'),
(26, 4, 1, 17000.00, ''),
(27, 36, 1, 35000.00, ''),
(28, 14, 1, 80000.00, '2,9,4,5,6,7,10,8'),
(28, 14, 1, 25000.00, '3'),
(28, 36, 1, 0.00, '3'),
(29, 4, 1, 17000.00, ''),
(29, 36, 1, 35000.00, ''),
(30, 4, 2, 17000.00, ''),
(30, 25, 2, 25000.00, ''),
(30, 3, 1, 0.00, '');

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
(1, 'name', 'SKUN BAKERY CAFE'),
(6, 'short_name', 'Đường số 7, Ấp 1, Hưng Hòa'),
(11, 'logo', 'uploads/logo.png?v=1650590302');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
CREATE TABLE IF NOT EXISTS `unit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `name`) VALUES
(1, 'Cái'),
(2, 'Ly');

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
(2, 'Mark', 'Cooper', 'mcooper', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/2.png?v=1650520142', NULL, 3, '2022-04-21 13:49:02', '2024-05-22 15:55:14'),
(4, 'Johnny', 'Smith', 'jsmith', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/4.png?v=1650531008', NULL, 2, '2022-04-21 16:50:08', '2024-05-22 15:55:17');

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
