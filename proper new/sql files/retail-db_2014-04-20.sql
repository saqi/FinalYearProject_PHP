-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 20, 2014 at 09:42 PM
-- Server version: 5.5.37
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `retail`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_sales`
--

CREATE TABLE `daily_sales` (
  `Id` int(6) NOT NULL AUTO_INCREMENT,
  `amount` double NOT NULL,
  `day` varchar(2) NOT NULL,
  `month` varchar(2) NOT NULL,
  `year` varchar(4) NOT NULL,
  `date` varchar(10) NOT NULL,
  `User_ID` varchar(2) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `daily_sales`
--

INSERT INTO `daily_sales` (`Id`, `amount`, `day`, `month`, `year`, `date`, `User_ID`) VALUES
(3, 200, '20', '4', '2014', '20/4/2014', '1');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ISBN` varchar(13) NOT NULL,
  `product_name` varchar(70) NOT NULL,
  `dimensions` varchar(20) NOT NULL,
  `selling_price` float NOT NULL,
  `weight` varchar(8) NOT NULL,
  `code` int(5) NOT NULL,
  `User_ID` int(2) NOT NULL,
  PRIMARY KEY (`ISBN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ISBN`, `product_name`, `dimensions`, `selling_price`, `weight`, `code`, `User_ID`) VALUES
('5038135108358', '3.5Lt Box & lid', '32 x 20.5 x 10cm', 12.5, '315g', 10835, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_sales`
--

CREATE TABLE `product_sales` (
  `Transaction_ID` int(15) NOT NULL AUTO_INCREMENT,
  `ISBN` varchar(13) NOT NULL,
  `quantity_sold` int(4) NOT NULL DEFAULT '1',
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `date` varchar(10) NOT NULL,
  `User_ID` int(2) NOT NULL,
  PRIMARY KEY (`Transaction_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `product_sales`
--

INSERT INTO `product_sales` (`Transaction_ID`, `ISBN`, `quantity_sold`, `day`, `month`, `year`, `date`, `User_ID`) VALUES
(1, '5038135108358', 1, 19, 4, 2014, '19/04/2014', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int(2) NOT NULL AUTO_INCREMENT,
  `Username` varchar(20) CHARACTER SET latin1 NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `hashed_password` varchar(50) NOT NULL,
  PRIMARY KEY (`User_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `Username`, `email`, `hashed_password`) VALUES
(1, 'saqi', 'saqi@hotmail.com', '052ae1fb074f800f611f21aad753d5249dd760bb');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
