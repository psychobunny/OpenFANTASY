-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 09, 2013 at 08:51 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `openfantasy`
--

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

# DROP TABLE IF EXISTS `analytics`;
CREATE TABLE IF NOT EXISTS `{NAMESPACE}_{NAMESPACE}_analytics` (
  `metric` varchar(255) NOT NULL,
  `handle` varchar(255) NOT NULL,
  `value` bigint(10) NOT NULL,
  `hourstamp` int(10) NOT NULL,
  PRIMARY KEY (`metric`,`handle`,`hourstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `analytics_warehouse`
--

# DROP TABLE IF EXISTS `analytics_warehouse`;
CREATE TABLE IF NOT EXISTS `{NAMESPACE}_analytics_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metric` varchar(255) NOT NULL,
  `handle` varchar(255) NOT NULL,
  `handleID` int(10) unsigned NOT NULL,
  `value` int(10) NOT NULL,
  `hourstamp` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facebook`
--

# DROP TABLE IF EXISTS `facebook`;
CREATE TABLE IF NOT EXISTS `{NAMESPACE}_facebook` (
  `userID` int(10) unsigned NOT NULL,
  `facebookID` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

# DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `{NAMESPACE}_users` (
  `userID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userlevel` int(10) NOT NULL,
  `created` int(10) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
