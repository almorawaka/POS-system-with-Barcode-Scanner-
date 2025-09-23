-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 23, 2025 at 07:08 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `address`, `phone`) VALUES
(1, 'Asanka', 'colombo', '0718278524'),
(2, 'Jayani', 'KAdawtha', '0716167577'),
(4, 'Dinuth', 'Kadawatha', '0718278522'),
(5, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(50) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_address` text,
  `customer_phone` varchar(20) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_number` (`invoice_number`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `customer_name`, `customer_address`, `customer_phone`, `total_amount`, `created_at`) VALUES
(1, 'INV37301', NULL, NULL, NULL, NULL, '2025-07-13 05:04:13'),
(2, 'INV86761', NULL, NULL, NULL, NULL, '2025-07-13 05:05:39'),
(3, 'INV08891', 'Asanka', 'colombo', '0718278524', 4.00, '2025-07-13 05:10:59'),
(4, 'INV42823', 'Asanka', 'colombo', '0718278524', 4.00, '2025-07-13 05:13:19'),
(5, 'INV51574', 'Jayani', 'KAdawtha', '0716167577', 2.00, '2025-07-13 05:15:50'),
(6, 'INV59394', 'Jayani', 'KAdawtha', '0716167577', 6.00, '2025-07-13 05:27:43'),
(7, 'INV11629', 'Jayani', 'KAdawtha', '0716167577', 6.00, '2025-07-13 05:36:06'),
(8, 'INV67901', 'Jayani', 'KAdawtha', '0716167577', 10.00, '2025-07-13 06:27:26'),
(9, 'INV28667', '', '', '', 900.00, '2025-07-13 07:31:34'),
(10, 'INV45631', 'Dinuth', 'Kadawatha', '0718278522', 5500.00, '2025-07-13 17:27:39'),
(11, 'INV47948', 'Dinuth', 'Kadawatha', '0718278522', 4.03, '2025-07-13 17:50:45'),
(12, 'INV07232', '', '', '', 0.00, '2025-07-13 17:54:00'),
(13, 'INV06575', '', '', '', 650.00, '2025-07-20 17:30:47'),
(14, 'INV99164', '', '', '', 650.00, '2025-07-20 17:32:58'),
(15, 'INV41491', '', '', '', 650.00, '2025-07-20 17:33:59'),
(16, 'INV17657', '', '', '', 650.00, '2025-07-20 17:41:14'),
(17, 'INV63376', '', '', '', 650.00, '2025-07-20 17:43:00'),
(18, 'INV19788', '', '', '', 0.00, '2025-07-21 17:44:18'),
(19, 'INV01127', '', '', '', 0.00, '2025-07-21 17:45:04'),
(20, 'INV51522', '', '', '', 9.00, '2025-07-21 17:57:03'),
(21, 'INV12978', '', '', '', 9.00, '2025-07-21 17:58:12'),
(22, 'INV92461', '', '', '', 45.00, '2025-07-21 17:59:33'),
(23, 'INV22498', '', '', '', 45.00, '2025-07-21 18:11:09'),
(24, 'INV64864', '', '', '', 45.00, '2025-07-21 18:11:10'),
(25, 'INV79020', '', '', '', 60.00, '2025-07-21 18:11:37'),
(26, 'INV33779', '', '', '', 60.00, '2025-07-21 18:11:38'),
(27, 'INV31459', '', '', '', 60.00, '2025-07-21 18:11:39'),
(28, 'INV19847', '', '', '', 60.00, '2025-07-21 18:11:39'),
(29, 'INV52543', '', '', '', 60.00, '2025-07-21 18:12:00'),
(30, 'INV84152', '', '', '', 60.00, '2025-07-21 18:13:42'),
(31, 'INV52761', '', '', '', 60.00, '2025-07-21 18:13:43'),
(32, 'INV72695', '', '', '', 60.00, '2025-07-21 18:13:44'),
(33, 'INV44833', '', '', '', 0.00, '2025-07-21 18:14:13'),
(34, 'INV82222', '', '', '', 0.00, '2025-07-21 18:14:36'),
(35, 'INV34316', '', '', '', 0.00, '2025-07-21 18:16:47'),
(36, 'INV55960', '', '', '', 0.00, '2025-07-21 18:16:48'),
(37, 'INV07009', '', '', '', 0.00, '2025-07-21 18:16:48'),
(38, 'INV83635', '', '', '', 0.00, '2025-07-21 18:19:00'),
(39, 'INV44822', '', '', '', 0.00, '2025-07-21 18:21:49'),
(40, 'INV01314', '', '', '', 0.00, '2025-07-21 18:22:15'),
(41, 'INV94055', '', '', '', 9.00, '2025-07-22 09:41:39'),
(42, 'INV94919', '', '', '', 9.00, '2025-07-22 09:45:41'),
(43, 'INV39403', 'Asanka', 'colombo', '0718278524', 0.00, '2025-07-22 09:56:53');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
CREATE TABLE IF NOT EXISTS `invoice_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoice_id` int NOT NULL,
  `item_code` varchar(100) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `item_code`, `item_name`, `price`, `qty`, `total`) VALUES
(1, 3, 'G71C000CQ110', 'Toshiba - 5V Power Supply ', 4.00, 1, 4.00),
(2, 4, 'G71C000CQ110', 'Toshiba - 5V Power Supply ', 4.00, 1, 4.00),
(3, 5, '4796002051398', 'Permenent Marker', 2.00, 1, 2.00),
(4, 6, '4796002051398', 'Permenent Marker', 2.00, 1, 2.00),
(5, 6, 'G71C000CQ110', 'Toshiba - 5V Power Supply ', 4.00, 1, 4.00),
(6, 7, '4796002051398', 'Permenent Marker', 2.00, 1, 2.00),
(7, 7, 'G71C000CQ110', 'Toshiba - 5V Power Supply ', 4.00, 1, 4.00),
(8, 8, '4796002051398', 'Permenent Marker', 2.00, 1, 2.00),
(9, 8, 'G71C000CQ110', 'Toshiba - 5V Power Supply ', 4.00, 2, 8.00),
(10, 9, 'V041891510413038647', 'Micromax 3.7V 1200mAh D200 Battery', 900.00, 1, 900.00),
(11, 10, '6938936710035', 'PLA Black Plylite', 5500.00, 1, 5500.00),
(12, 11, 'G71C000CQ110', 'Toshiba - 5V Power Supply ', 4.03, 1, 4.00),
(13, 13, '4792210131938', 'Single rule Atlas Book 80 pgs', NULL, 1, 0.00),
(14, 13, '4796004080303', 'Pelwathha Butter ', NULL, 1, 650.00),
(15, 14, '4792210131938', 'Single rule Atlas Book 80 pgs', NULL, 1, 0.00),
(16, 14, '4796004080303', 'Pelwathha Butter ', NULL, 1, 650.00),
(17, 15, '4796004080303', 'Pelwathha Butter ', NULL, 1, 650.00),
(18, 16, '4796004080303', 'Pelwathha Butter ', NULL, 1, 650.00),
(19, 17, '4796004080303', 'Pelwathha Butter ', NULL, 1, 650.00),
(20, 19, '4792210131938', 'Single rule Atlas Book 80 pgs', NULL, 1, 0.00),
(21, 20, '4792210131129', 'Book4', NULL, 1, 9.00),
(22, 21, '4792210131129', 'Book4', 9.00, 1, 9.00),
(23, 22, '4792210131129', 'Book4', 9.00, 5, 45.00),
(24, 23, '4792210131129', 'Book4', 9.00, 5, 45.00),
(25, 24, '4792210131129', 'Book4', 9.00, 5, 45.00),
(26, 25, 'SMF01', 'File cover', 60.00, 1, 60.00),
(27, 26, 'SMF01', 'File cover', 60.00, 1, 60.00),
(28, 27, 'SMF01', 'File cover', 60.00, 1, 60.00),
(29, 28, 'SMF01', 'File cover', 60.00, 1, 60.00),
(30, 29, 'SMF01', 'File cover', 60.00, 1, 60.00),
(31, 30, 'SMF01', 'File cover', 60.00, 1, 60.00),
(32, 31, 'SMF01', 'File cover', 60.00, 1, 60.00),
(33, 32, 'SMF01', 'File cover', 60.00, 1, 60.00),
(34, 33, 'R161', 'Rathne Rice', 0.00, 1, 0.00),
(35, 34, 'R161', 'Rathne Rice', 0.00, 1, 0.00),
(36, 35, 'R161', 'Rathne Rice', 0.00, 1, 0.00),
(37, 36, 'R161', 'Rathne Rice', 0.00, 1, 0.00),
(38, 37, 'R161', 'Rathne Rice', 0.00, 1, 0.00),
(39, 38, 'R161', 'Rathne Rice', 0.00, 1, 0.00),
(40, 40, 'R161', 'Rathne Rice', 0.00, 1, 0.00),
(41, 41, '4792210131129', 'Book4', 9.00, 1, 9.00),
(42, 42, '4792210131129', 'Book4', 9.00, 1, 9.00),
(43, 43, '4792210131938', 'Single rule Atlas Book 80 pgs', 0.00, 1, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_code` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` text,
  `buying_price` decimal(10,2) DEFAULT '0.00',
  `selling_price` decimal(10,2) DEFAULT '0.00',
  `quantity` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `item_code` (`item_code`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_code`, `name`, `image`, `buying_price`, `selling_price`, `quantity`) VALUES
(1, 'RES1001', 'Resistor 1k Ohm', NULL, 0.00, 0.00, 0),
(2, 'CAP2201', 'Capacitor 10uF', NULL, 0.00, 0.00, 0),
(3, 'LED3001', 'LED Red 5mm', NULL, 0.00, 0.00, 0),
(4, 'TRN4001', 'Transformer 12V 1A', NULL, 0.00, 0.00, 0),
(5, 'IC5001', 'IC 555 Timer', NULL, 0.00, 0.00, 0),
(6, 'R161', 'Rathne Rice', NULL, 0.00, 0.00, 0),
(7, '4796002051398', 'Permenent Marker', NULL, 0.00, 0.00, 0),
(8, 'G71C000CQ110', 'Toshiba - 5V Power Supply ', '', 98.00, 75.00, 5),
(9, 'V041891510413038647', 'Micromax 3.7V 1200mAh D200 Battery', NULL, 0.00, 0.00, 0),
(10, '6938936710035', 'PLA Black Plylite', NULL, 0.00, 0.00, 0),
(11, 'G71C000CQ111', 'Power pack', 'uploads/logo.png', 0.00, 0.00, 0),
(12, '4894128100386', 'Transformer ', 'uploads/1753023365_Screenshot 2025-04-07 202338.png', 0.00, 0.00, 0),
(13, '4792210131938', 'Single rule Atlas Book 80 pgs', 'uploads/1753027854_Screenshot 2025-03-26 210922.png,uploads/1753027854_Screenshot 2025-03-26 215705.png,uploads/1753027854_Screenshot 2025-03-26 215725.png,uploads/1753027854_Screenshot 2025-06-02 202201.png,uploads/1753027854_Screenshot 2025-06-02 202833.png', 0.00, 0.00, -1),
(14, '4796004080303', 'Pelwathha Butter ', 'uploads/1753028910_Screenshot 2025-07-12 230333.png,uploads/1753028910_Screenshot 2025-07-10 221742.png,uploads/1753028910_Screenshot 2025-07-12 231609.png,uploads/1753028910_Screenshot 2025-06-23 225616.png,uploads/1753028910_Screenshot 2025-06-23 225413.png', 485.00, 650.00, 0),
(15, 'SMF01', 'File cover', 'uploads/1753030371_Screenshot 2025-03-26 215800.png,uploads/1753030371_Screenshot 2025-03-26 215705.png,uploads/1753030371_Screenshot 2025-03-26 215725.png,uploads/1753030371_Screenshot 2025-07-13 224440.png,uploads/1753030371_Screenshot 2025-07-10 221527.png', 45.00, 60.00, 0),
(16, '4792210131936', 'Book', '', 50.00, 60.00, 0),
(17, '4792210131912', 'Book', '', 90.00, 100.00, 0),
(18, '4792210131976', 'Book 2', 'uploads/1753031446_Screenshot 2025-06-13 192559.png', 10.00, 12.00, 0),
(19, '4792210131123', 'Book3', '', 15.00, 18.00, 10),
(20, '4792210131129', 'Book4', 'uploads/1753032285_Screenshot 2025-03-26 215800.png', 80.00, 9.00, 18);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
