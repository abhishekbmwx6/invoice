-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 10, 2018 at 06:53 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purches_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` float NOT NULL,
  `total_before_tax` float NOT NULL,
  `total_after_tax` float NOT NULL,
  `saler_id` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `user_id`, `purches_date`, `total`, `total_before_tax`, `total_after_tax`, `saler_id`, `status`, `created_at`, `updated_at`) VALUES
(52, 1, '2018-03-10 12:36:51', 605, 560, 605, 1, 'active', '2018-03-10 12:36:51', '0000-00-00 00:00:00'),
(53, 1, '2018-03-02 13:58:13', 2730, 2440, 2730, 1, 'inactive', '2018-03-02 13:58:13', '2018-03-02 14:06:13'),
(54, 1, '2018-03-02 14:11:18', 574, 514, 574, 1, 'active', '2018-03-02 14:11:18', '0000-00-00 00:00:00'),
(55, 1, '2018-03-02 14:13:02', 448, 400, 448, 1, 'active', '2018-03-02 14:13:02', '0000-00-00 00:00:00'),
(56, 1, '2018-03-10 12:40:38', 15332, 13690, 15332, 1, 'active', '2018-03-10 12:40:38', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_products`
--

CREATE TABLE `invoice_products` (
  `invoice_product_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `Product_desc` text NOT NULL,
  `product_value` float NOT NULL,
  `value_before_tax` float NOT NULL,
  `value_after_tax` float NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `final_product_value` float NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_products`
--

INSERT INTO `invoice_products` (`invoice_product_id`, `invoice_id`, `product_name`, `Product_desc`, `product_value`, `value_before_tax`, `value_after_tax`, `quantity`, `final_product_value`, `created_at`, `updated_at`) VALUES
(46, 53, 'nokia chager', '', 130, 130, 144, 1, 144, '2018-03-02 13:58:13', '0000-00-00 00:00:00'),
(47, 53, 'battery', '', 770, 770, 2586, 3, 2586, '2018-03-02 13:58:13', '0000-00-00 00:00:00'),
(52, 54, 'samsung charger', '', 34, 34, 38, 1, 38, '2018-03-02 14:11:18', '0000-00-00 00:00:00'),
(53, 54, 'samsung charger old ', '', 120, 120, 536, 4, 536, '2018-03-02 14:11:18', '0000-00-00 00:00:00'),
(55, 55, 'mobile repair', '', 400, 400, 448, 1, 448, '2018-03-02 14:13:02', '0000-00-00 00:00:00'),
(58, 52, 'motorola charger', '', 70, 70, 234, 3, 234, '2018-03-10 12:36:51', '0000-00-00 00:00:00'),
(59, 52, 'samsung repair', '', 350, 350, 371, 1, 371, '2018-03-10 12:36:52', '0000-00-00 00:00:00'),
(62, 56, 'oppo mobile', '', 13690, 13690, 15332, 1, 15332, '2018-03-10 12:40:38', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_tax`
--

CREATE TABLE `invoice_tax` (
  `invoice_tax_id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `rate` float NOT NULL,
  `tax_amount` float NOT NULL,
  `invoice_product_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_tax`
--

INSERT INTO `invoice_tax` (`invoice_tax_id`, `tax_id`, `rate`, `tax_amount`, `invoice_product_id`, `invoice_id`) VALUES
(74, 1, 6, 7.8, 46, 53),
(75, 2, 6, 7.8, 46, 53),
(76, 1, 6, 46.2, 47, 53),
(77, 2, 6, 46.2, 47, 53),
(86, 1, 6, 2.04, 52, 54),
(87, 2, 6, 2.04, 52, 54),
(88, 1, 6, 7.2, 53, 54),
(89, 2, 6, 7.2, 53, 54),
(92, 1, 6, 24, 55, 55),
(93, 2, 6, 24, 55, 55),
(97, 1, 6, 4.2, 58, 52),
(98, 2, 6, 4.2, 58, 52),
(101, 1, 6, 821.4, 62, 56),
(102, 2, 6, 821.4, 62, 56);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(11) NOT NULL,
  `password` varchar(11) NOT NULL,
  `status` enum('active','inactive','','') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `user_id`, `username`, `password`, `status`) VALUES
(1, 1, 'admin', 'admin', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `tax_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('active','inactive','','') NOT NULL DEFAULT 'active',
  `value` float NOT NULL,
  `tax_type` enum('value','percentage','','') NOT NULL DEFAULT 'percentage'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`tax_id`, `name`, `description`, `status`, `value`, `tax_type`) VALUES
(1, 'SGST', 'SGST', 'active', 6, 'percentage'),
(2, 'CGST', 'CGST', 'active', 6, 'percentage');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `contact` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text,
  `role` enum('user','admin','dealer','') NOT NULL DEFAULT 'user',
  `invoice_template` text,
  `pen_no` varchar(255) DEFAULT NULL,
  `gst_no` varchar(255) DEFAULT NULL,
  `invoice_id_prefix` varchar(255) DEFAULT NULL,
  `shop_name` text,
  `sold_by` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `contact`, `email`, `address`, `role`, `invoice_template`, `pen_no`, `gst_no`, `invoice_id_prefix`, `shop_name`, `sold_by`, `created_at`, `updated_at`) VALUES
(1, 'Dilip Gupta', 8898177032, 'abhishekbmwx1@gmail.com', 'bhyandar east', 'user', NULL, 'BGJPD3577M', 'GST8888/BGJPD3577M', 'AKM00', '<h3>A.K. Mobiles</h3><br><h6>SALES & SERVICE CENTER</h6>', '<P>Shop No. 12,\r\n<br>O.P. Commerce Center.\r\n<br>Opp. Indra Varun Sabha Gruh,\r\n<br>Jesal Park,\r\n<br>Bhayndar (E),\r\n<br> Pin code: 40 105 \r\n </P>', '2018-02-21 14:06:52', '2018-03-02 13:53:31'),
(2, 'Abhi Dub', 7021209577, NULL, 'Santacruz East', 'user', NULL, NULL, NULL, NULL, NULL, NULL, '2018-02-21 14:11:12', NULL),
(3, 'Abhi', 8898177034, NULL, 'santa', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-02-27 14:32:20', '2018-02-27 14:32:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `FOREIGN_KEY_INVOICE` (`user_id`),
  ADD KEY `FOREIGN_KEY_INVOICE_SALER` (`saler_id`);

--
-- Indexes for table `invoice_products`
--
ALTER TABLE `invoice_products`
  ADD PRIMARY KEY (`invoice_product_id`),
  ADD KEY `FOREIGN_KEY_INVOICE_PRODUCT` (`invoice_id`);

--
-- Indexes for table `invoice_tax`
--
ALTER TABLE `invoice_tax`
  ADD PRIMARY KEY (`invoice_tax_id`),
  ADD KEY `invoice_tax_ibfk_1` (`invoice_product_id`),
  ADD KEY `invoice_tax_ibfk_2` (`tax_id`),
  ADD KEY `invoice_tax_ibfk_3` (`invoice_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FOREIGN_KEY` (`user_id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `contact` (`contact`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `invoice_products`
--
ALTER TABLE `invoice_products`
  MODIFY `invoice_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `invoice_tax`
--
ALTER TABLE `invoice_tax`
  MODIFY `invoice_tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `FOREIGN_KEY_INVOICE` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FOREIGN_KEY_INVOICE_SALER` FOREIGN KEY (`saler_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_products`
--
ALTER TABLE `invoice_products`
  ADD CONSTRAINT `FOREIGN_KEY_INVOICE_PRODUCT` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_tax`
--
ALTER TABLE `invoice_tax`
  ADD CONSTRAINT `invoice_tax_ibfk_1` FOREIGN KEY (`invoice_product_id`) REFERENCES `invoice_products` (`invoice_product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_tax_ibfk_2` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`tax_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_tax_ibfk_3` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`) ON DELETE CASCADE;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `FOREIGN_KEY` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
