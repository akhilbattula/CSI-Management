-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2018 at 02:13 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inventorymanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE IF NOT EXISTS `billing` (
  `bill_no` bigint(6) NOT NULL AUTO_INCREMENT,
  `cust_id` bigint(6) NOT NULL,
  `total_price` bigint(10) NOT NULL,
  `bill_date` date NOT NULL,
  `store_id` varchar(6) NOT NULL,
  `IMEI` varchar(250) NOT NULL,
  `bill_status` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`bill_no`),
  UNIQUE KEY `IMEI1_2` (`IMEI`),
  KEY `cust_id` (`cust_id`),
  KEY `IMEI1` (`IMEI`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `cust_id` bigint(6) NOT NULL AUTO_INCREMENT,
  `cust_first_name` varchar(30) NOT NULL,
  `cust_last_name` varchar(30) NOT NULL,
  `cust_gender` varchar(6) NOT NULL,
  `cust_dob` date NOT NULL,
  `cust_address` varchar(150) NOT NULL,
  `cust_city` varchar(20) NOT NULL,
  `cust_state` varchar(20) NOT NULL,
  `cust_country` varchar(15) NOT NULL,
  `cust_postcode` varchar(7) NOT NULL,
  `cust_aadhar` varchar(12) NOT NULL,
  `cust_mobileno1` varchar(10) NOT NULL,
  `cust_mobileno2` varchar(10) DEFAULT NULL,
  `cust_panno` varchar(12) DEFAULT NULL,
  `cust_purchasecount` bigint(3) NOT NULL DEFAULT '0',
  `cust_email` varchar(50) NOT NULL,
  `cust_comments` varchar(150) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_by` varchar(50) DEFAULT NULL,
  `last_edited` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cust_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `emi`
--

CREATE TABLE IF NOT EXISTS `emi` (
  `emi_id` bigint(6) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(15) NOT NULL,
  `bill_no` varchar(15) NOT NULL,
  `no_of_months` int(2) NOT NULL,
  `emi_amount` bigint(8) NOT NULL,
  PRIMARY KEY (`emi_id`),
  UNIQUE KEY `invoice_id` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` varchar(15) NOT NULL,
  `cust_id` varchar(20) NOT NULL,
  `no_of_products` bigint(3) NOT NULL DEFAULT '0',
  `total_amount` bigint(15) NOT NULL DEFAULT '0',
  `invoice_status` varchar(10) NOT NULL,
  `mode_of_payment` varchar(30) NOT NULL,
  `emi_vendor` varchar(30) DEFAULT NULL,
  `no_of_months` int(2) DEFAULT NULL,
  `emi_amount` bigint(5) DEFAULT NULL,
  `bill_no` varchar(15) NOT NULL,
  `comments` varchar(150) DEFAULT NULL,
  `store_id` varchar(10) NOT NULL,
  `invoice_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(60) NOT NULL,
  `last_edited_by` varchar(60) DEFAULT NULL,
  `last_modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`invoice_id`),
  KEY `cust_id` (`cust_id`),
  KEY `cust_id_2` (`cust_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_products`
--

CREATE TABLE IF NOT EXISTS `invoice_products` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL,
  `quantity` bigint(4) NOT NULL,
  `invoice_id` varchar(15) NOT NULL,
  `discount` int(5) NOT NULL,
  `total_cost` bigint(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` bigint(6) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username` (`username`,`password`),
  UNIQUE KEY `staff_id` (`staff_id`),
  KEY `staff_id_2` (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `log_register`
--

CREATE TABLE IF NOT EXISTS `log_register` (
  `ts_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `ID` int(11) NOT NULL,
  `staff_id` bigint(6) NOT NULL,
  `user` varchar(10) NOT NULL,
  `login_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logout_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ts_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `log_register`
--

INSERT INTO `log_register` (`ts_id`, `ID`, `staff_id`, `user`, `login_at`, `logout_at`) VALUES
(1, 1, 1, 'admin', '2018-07-23 19:40:05', '2018-08-09 15:19:57'),
(2, 1, 1, 'admin', '2018-08-05 07:36:39', NULL),
(3, 1, 1, 'admin', '2018-08-13 18:12:24', NULL),
(4, 1, 1, 'admin', '2018-08-15 07:33:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `needs`
--

CREATE TABLE IF NOT EXISTS `needs` (
  `id` bigint(6) NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(6) NOT NULL,
  `product_id` varchar(20) DEFAULT NULL,
  `product_name` varchar(60) NOT NULL,
  `quantity` bigint(6) NOT NULL,
  `comments` varchar(150) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `others`
--

CREATE TABLE IF NOT EXISTS `others` (
  `ID` bigint(6) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  `Keyword` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `others`
--

INSERT INTO `others` (`ID`, `Name`, `Keyword`) VALUES
(1, 'Manager', 'Designations'),
(2, 'Pending', 'Needs_Status'),
(3, 'M.D', 'Designations'),
(4, 'CEO', 'Designations'),
(5, 'Stock Incharge', 'Designations'),
(6, 'Store Manager', 'Designations'),
(7, 'Processed', 'Invoice Status'),
(8, 'Cancelled', 'Invoice Status');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `prod_id` bigint(20) NOT NULL,
  `prod_category` varchar(20) NOT NULL,
  `prod_name` varchar(30) NOT NULL,
  `prod_price` double NOT NULL,
  `gst` double NOT NULL,
  `require_auth` varchar(10) NOT NULL,
  `imei_nos` varchar(50) NOT NULL,
  `model_no` varchar(30) NOT NULL,
  `from_shipment_id` varchar(25) NOT NULL,
  `no_in_stock` int(5) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`prod_id`),
  KEY `from_shipment_id` (`from_shipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_category`, `prod_name`, `prod_price`, `gst`, `require_auth`, `imei_nos`, `model_no`, `from_shipment_id`, `no_in_stock`, `date_created`, `last_edited`) VALUES
(1, 'Mobiles', 'VIVO V5', 20000, 12, 'Admin', '2', '', '0', 0, '2018-04-30 13:26:57', '2018-07-18 17:32:01'),
(3, 'Mobiles', 'OPPO F3', 17000, 12, 'Admin', '2', '', '1', 0, '2018-05-05 18:47:02', '2018-05-09 15:58:11'),
(7, 'Mobiles', 'OPPO F3', 17000, 12, 'Admin', '2', '', '0', 0, '2018-05-05 17:01:31', '2018-05-11 14:55:57'),
(12, 'Accesssories', 'sad', 12000, 21, 'Admin', '312', '', '0', 0, '2018-05-14 19:28:12', '2018-05-14 19:28:12'),
(13, 'Mobiles', '546', 321312131, 231321, 'Admin', '1321', '', '0', 0, '2018-05-14 19:23:25', '2018-05-14 19:23:25'),
(51424, 'Accesssories', 'adfa', 132, 321, 'Admin', '123', '', '0', 0, '2018-05-14 19:26:39', '2018-05-14 19:26:39'),
(31321321, 'Mobiles', 'adfas', 312231, 12, 'Admin', '0', '', 'SPM-201806', 21, '2018-06-19 19:20:44', '2018-06-19 19:20:44'),
(121145121, 'Accesssories', 'sdfd', 1213232, 12, 'Admin', '1', '', '0', 1212, '2018-05-20 15:14:31', '2018-05-20 15:14:31'),
(123456789, 'Mobiles', 'asdf', 12133, 12, 'Admin', '2', '', '0', 40, '2018-06-20 17:23:20', '2018-07-19 17:33:39'),
(142536789, 'Mobiles', 'asasass', 12211212, 12, 'Admin', '0', '', '1122331', 1245, '2018-06-18 17:23:54', '2018-06-18 17:23:54'),
(656654656, 'Mobiles', 'VIVO', 17000, 12, 'Admin', '2', '', '0', 5, '2018-05-20 14:29:04', '2018-05-20 14:59:54'),
(32112321231, 'Mobiles', '6556', 132231231, 32, 'Manager', '2', '', 'SPM-201806', 213, '2018-06-19 19:34:49', '2018-06-19 19:34:49'),
(65665465645, 'Mobiles', 'VIVO', 17000, 12, 'Admin', '2', '', '0', 5, '2018-05-20 15:00:44', '2018-05-20 15:00:44'),
(101010101010, 'Mobiles', 'sadfasdf', 12312312, 13, 'Manager', '1', '', '0', 24, '2018-07-19 18:45:35', '2018-08-01 15:15:53'),
(1234567891234, 'Mobiles', 'Vivo', 123456, 12, 'Admin', '2', '', 'asdf', 12, '2018-06-18 17:20:34', '2018-06-18 17:20:34');

-- --------------------------------------------------------

--
-- Table structure for table `shipment`
--

CREATE TABLE IF NOT EXISTS `shipment` (
  `shipment_id` varchar(20) NOT NULL,
  `dealer_name` varchar(35) NOT NULL,
  `dealer_address` varchar(120) NOT NULL,
  `no_of_products` int(5) NOT NULL,
  `total_price` double NOT NULL,
  `gst_paid` int(5) NOT NULL,
  `comments` varchar(300) DEFAULT NULL,
  `shipment_date` varchar(15) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`shipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipment`
--

INSERT INTO `shipment` (`shipment_id`, `dealer_name`, `dealer_address`, `no_of_products`, `total_price`, `gst_paid`, `comments`, `shipment_date`, `created_date`, `last_modified`) VALUES
('SPM-20180621-01', 'asdfsdfasdfasdfasdf', 'Vijayawada', 32, 11223344, 15, '', '2018-06-21', '2018-06-21 17:43:02', '2018-07-19 17:50:16'),
('SPM-20180719-01', 'OPPO', 'vijayawada', 12, 100000, 12, '', '2018-07-19', '2018-07-19 17:32:13', '2018-07-19 17:32:13'),
('SPM-20180719-02', 'asdfasdf', 'sdfsdf`', 12, 12121212122, 12, 'sdadfs', '2018-07-19', '2018-07-19 18:04:12', '2018-07-19 18:04:12'),
('SPM-20180720-01', '12212', 'sadfdsf', 321, 20121212112, 12, '', '2018-07-20', '2018-07-19 18:45:04', '2018-07-19 18:45:04'),
('SPM-20180720-02', '2321231', 'dacfsafd', 12, 12321132, 12, '', '2018-07-20', '2018-07-19 18:58:24', '2018-07-19 18:58:24'),
('SPM-20180720-03', '213123', '132132', 32321, 1233, 21312, '', '2018-01-31', '2018-07-19 19:32:51', '2018-07-19 19:32:51'),
('SPM-20180720-04', 'safsadfds', 'sadfasdfsdf', 56, 465656565, 12, '', '2018-07-20', '2018-07-19 19:34:29', '2018-07-19 19:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `shipment_products`
--

CREATE TABLE IF NOT EXISTS `shipment_products` (
  `sh_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `prod_id` varchar(20) NOT NULL,
  `prod_name` varchar(60) NOT NULL,
  `prod_category` varchar(20) NOT NULL,
  `prod_price` bigint(10) NOT NULL,
  `gst_percentage` int(2) NOT NULL,
  `require_auth` varchar(20) NOT NULL,
  `imei_nos` varchar(50) NOT NULL,
  `quantity` bigint(10) NOT NULL,
  `shipment_id` varchar(30) NOT NULL,
  `date_created` date NOT NULL,
  PRIMARY KEY (`sh_id`),
  KEY `shipment_id` (`shipment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `shipment_products`
--

INSERT INTO `shipment_products` (`sh_id`, `prod_id`, `prod_name`, `prod_category`, `prod_price`, `gst_percentage`, `require_auth`, `imei_nos`, `quantity`, `shipment_id`, `date_created`) VALUES
(10, '5556565', '12213sad', 'Mobiles', 22123132, 5, 'Admin', '1', 3, 'SPM-20180621-01', '2018-06-21'),
(11, '5556565', '12213sad', 'Mobiles', 22123132, 5, 'Admin', '1', 3, 'SPM-20180621-01', '2018-06-21'),
(12, '5556565', '12213sad', 'Mobiles', 22123132, 5, 'Admin', '1', 3, 'SPM-20180621-01', '2018-06-21'),
(13, '123456789', 'fwefwfe', 'Mobiles', 121212, 12, 'Manager', '2', 10, 'SPM-20180719-01', '2018-07-19'),
(14, '212311232', '3123asdadsf', 'Mobiles', 32133213, 21, 'Admin', '1', 21, 'SPM-20180719-02', '2018-07-19'),
(15, '5526253223', '3asdfsda', 'Mobiles', 23321123, 121, 'Manager', '1', 12, 'SPM-20180719-02', '2018-07-19'),
(16, '101010101010', 'sadfasdf', 'Mobiles', 12312312, 13231, 'Manager', '1', 4, 'SPM-20180720-01', '2018-07-20'),
(17, '101010101010', '121321', 'Mobiles', 132323123, 321321, 'Manager', '3', 10, 'SPM-20180720-03', '2018-07-20'),
(18, '101010101010', '131sdfasd', 'Mobiles', 133165165, 12, 'Manager', '2', 10, 'SPM-20180720-04', '2018-07-20');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` bigint(6) NOT NULL AUTO_INCREMENT,
  `staff_first_name` varchar(30) NOT NULL,
  `staff_last_name` varchar(30) NOT NULL,
  `staff_gender` varchar(6) NOT NULL,
  `staff_dob` date NOT NULL,
  `staff_address` varchar(150) NOT NULL,
  `staff_city` varchar(25) NOT NULL,
  `staff_state` varchar(25) NOT NULL,
  `staff_country` varchar(15) NOT NULL,
  `staff_postcode` varchar(6) NOT NULL,
  `staff_aadhar` varchar(12) DEFAULT NULL,
  `staff_mobileno1` varchar(10) NOT NULL,
  `staff_mobileno2` varchar(10) DEFAULT NULL,
  `staff_panno` varchar(12) DEFAULT NULL,
  `staff_email` varchar(50) NOT NULL,
  `staff_designation` varchar(20) NOT NULL,
  `staff_previous_employment` varchar(150) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(50) NOT NULL,
  `edited_by` varchar(50) DEFAULT NULL,
  `last_edited` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `product_id` bigint(20) NOT NULL,
  `stock` bigint(10) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE IF NOT EXISTS `stores` (
  `store_id` bigint(6) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(30) NOT NULL,
  `store_address` varchar(60) NOT NULL,
  `store_type` varchar(15) NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `bill_cust_foriegn` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `staff_connection_login` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shipment_products`
--
ALTER TABLE `shipment_products`
  ADD CONSTRAINT `shp_products_table_shipment_id` FOREIGN KEY (`shipment_id`) REFERENCES `shipment` (`shipment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `foreign_stock_prod_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`prod_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
