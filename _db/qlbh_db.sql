-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 15, 2024 at 08:01 AM
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
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(10) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `delete_flag` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `date_created`, `name`, `description`, `status`, `delete_flag`) VALUES
(1, NULL, 'M', 'Size M', 1, 1),
(2, '2024-05-15 14:07:36', 'L', 'Size L', 1, 0),
(3, '2024-05-15 14:08:55', 'M', 'Size M', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

DROP TABLE IF EXISTS `category_list`;
CREATE TABLE IF NOT EXISTS `category_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Cafe', 'Coffee', 1, 0, '2022-04-22 09:59:46', '2024-05-07 20:46:46'),
(2, 'Trà Sữa', 'Trà Sữa', 1, 0, '2022-04-22 10:01:06', '2024-05-07 20:46:35'),
(3, 'M', 'Size M', 1, 1, '2024-05-15 13:53:42', '2024-05-15 13:53:52');

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
  `has_attribute` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `category_id`, `name`, `description`, `price`, `has_attribute`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 1, 'Arabica', 'Arabica is the most popular type of bean used for coffee. Arabica beans are considered higher quality than Robusta, and they\'re also more expensive.', 150.00, 0, 1, 1, '2022-04-22 10:16:50', '2022-04-22 10:22:07'),
(2, 1, 'Robusta', 'Robusta beans are typically cheaper to produce because the Robusta plant is easier to grow.', 145.00, 0, 1, 1, '2022-04-22 10:17:20', '2022-04-22 10:22:11'),
(3, 1, 'Cafe đen', 'Black coffee is made from plain ground coffee beans that are brewed hot. It\'s served without added sugar, milk, or flavorings.', 12000.00, 0, 1, 0, '2022-04-22 10:17:54', '2024-05-07 20:47:16'),
(4, 1, 'Bạc sỉu', 'Coffee beans naturally contain caffeine, but roasters can use several different processes to remove almost all of it. Decaf coffee is brewed with these decaffeinated beans.', 18000.00, 0, 1, 0, '2022-04-22 10:18:15', '2024-05-07 20:47:41'),
(5, 1, 'Espresso', 'Most people know that a shot of espresso is stronger than the same amount of coffee, but what\'s the difference, exactly? There isn\'t anything inherently different about the beans themselves, but when beans are used to make espresso they\'re more finely ground, and they\'re brewed with a higher grounds-to-water ratio than what\'s used for coffee.', 125.00, 0, 1, 0, '2022-04-22 10:19:18', '2022-04-22 10:19:18'),
(6, 1, 'Latte', 'This classic drink is typically 1/3 espresso and 2/3 steamed milk, topped with a thin layer of foam, but coffee shops have come up with seemingly endless customizations. You can experiment with flavored syrups like vanilla and pumpkin spice or create a nondairy version by using oat milk. Skilled baristas often swirl the foam into latte art!', 125.00, 0, 1, 0, '2022-04-22 10:19:47', '2022-04-22 10:19:47'),
(7, 1, 'Cafe sữa', 'This espresso-based drink is similar to a latte, but the frothy top layer is thicker. The standard ratio is equal parts espresso, steamed milk, and foam. It\'s often served in a 6-ounce cup (smaller than a latte cup) and can be topped with a sprinkling of cinnamon.', 15000.00, 0, 1, 0, '2022-04-22 10:20:06', '2024-05-07 20:47:29'),
(8, 1, 'Macchiato', 'A macchiato is a shot of espresso with just a touch of steamed milk or foam. In Italian, macchiato means \"stained\" or \"spotted,\" so a caffè macchiato refers to coffee that\'s been stained with milk.', 150.00, 0, 1, 0, '2022-04-22 10:20:26', '2022-04-22 10:20:26'),
(9, 2, 'Trà sữa Thái', 'Is there anything better than a glass of iced coffee on a hot day (or any day, for that matter)? The simplest way to make it: Brew a regular cup of hot coffee, then cool it over ice. Add whatever milk and sweeteners you like.', 20000.00, 0, 1, 0, '2022-04-22 10:20:53', '2024-05-07 20:48:31'),
(10, 2, 'Iced Latte', 'The chilled version of a latte is simply espresso and milk over ice.', 145.00, 0, 1, 0, '2022-04-22 10:21:17', '2022-04-22 10:21:17'),
(11, 2, 'Trà sữa truyền thống', 'Cold brew is one of the biggest coffee trends of the last decade, and for good reason: It\'s made by slowly steeping coffee grounds over cool or room-temperature water, so it tastes smoother and less bitter than regular iced coffee, which is brewed hot.', 0.00, 0, 1, 0, '2022-04-22 10:21:42', '2024-05-15 14:36:34');

-- --------------------------------------------------------

--
-- Table structure for table `sale_list`
--

DROP TABLE IF EXISTS `sale_list`;
CREATE TABLE IF NOT EXISTS `sale_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `code` varchar(100) NOT NULL,
  `client_name` text NOT NULL,
  `amount` float(15,2) NOT NULL DEFAULT '0.00',
  `tendered` float(15,2) NOT NULL DEFAULT '0.00',
  `payment_type` tinyint(1) NOT NULL COMMENT '1 = Cash,\r\n2 = Debit Card,\r\n3 = Credit Card',
  `payment_code` text,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sale_list`
--

INSERT INTO `sale_list` (`id`, `user_id`, `code`, `client_name`, `amount`, `tendered`, `payment_type`, `payment_code`, `date_created`, `date_updated`) VALUES
(1, 1, '202204220001', 'Guest', 710.00, 1000.00, 1, '', '2022-04-22 13:54:44', '2022-04-22 13:54:44'),
(2, 2, '202204220002', 'Guest', 675.00, 700.00, 2, '123121ABcdF', '2022-04-22 15:27:02', '2022-04-22 15:27:02'),
(3, 1, '202405070001', 'Guest', 48000.00, 0.00, 1, '', '2024-05-07 20:50:16', '2024-05-07 20:50:16'),
(5, 1, '202405140001', 'Guest', 45400.00, 0.00, 1, '', '2024-05-14 15:29:14', '2024-05-14 15:29:14');

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
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sale_products`
--

INSERT INTO `sale_products` (`sale_id`, `product_id`, `qty`, `price`) VALUES
(1, 11, 3, 140.00),
(1, 10, 2, 145.00),
(2, 9, 1, 150.00),
(2, 3, 3, 75.00),
(2, 8, 2, 150.00),
(3, 4, 2, 18000.00),
(3, 3, 1, 12000.00),
(5, 4, 1, 18000.00),
(5, 3, 1, 12000.00),
(5, 7, 1, 15000.00),
(5, 5, 1, 125.00),
(5, 8, 1, 150.00),
(5, 6, 1, 125.00);

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
(1, 'name', 'Phần mềm bán hàng'),
(6, 'short_name', 'SKUN BAKERY - CAFE - MILK TEA'),
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
