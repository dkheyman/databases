-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 29, 2016 at 06:14 PM
-- Server version: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookly`
--

-- --------------------------------------------------------

--
-- Table structure for table `Auction`
--

CREATE TABLE `Auction` (
  `auctionID` varchar(32) NOT NULL,
  `asking_price` double NOT NULL,
  `starting_price` double NOT NULL,
  `userID` varchar(32) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Bid`
--

CREATE TABLE `Bid` (
  `buyerID` varchar(32) NOT NULL,
  `auctionID` varchar(32) NOT NULL,
  `value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Book`
--

CREATE TABLE `Book` (
  `title` varchar(128) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `aLast` varchar(32) NOT NULL,
  `aFirst` varchar(32) NOT NULL,
  `imageURL` varchar(128) DEFAULT NULL,
  `book_condition` enum('New','Used:Excellent','Used:Good','Used:Fair','Used:Poor') DEFAULT NULL,
  `genre` varchar(32) DEFAULT NULL,
  `publisher` varchar(128) DEFAULT NULL,
  `language` varchar(32) DEFAULT NULL,
  `binding` enum('Hardcover','Softcover','Leather','None') DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Reviews`
--

CREATE TABLE `Reviews` (
  `reviewerID` varchar(32) NOT NULL,
  `reviewedID` varchar(32) NOT NULL,
  `review` text NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `userID` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `type` enum('buyer','seller') NOT NULL,
  `rating` float DEFAULT NULL,
  `email` varchar(32) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`userID`, `username`, `password`, `type`, `rating`, `email`, `creation_date`) VALUES
('39504', '', '', '', NULL, '', '2016-01-29 16:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `View`
--

CREATE TABLE `View` (
  `buyerID` varchar(32) NOT NULL,
  `auctionID` varchar(32) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Watch`
--

CREATE TABLE `Watch` (
  `buyerID` varchar(32) NOT NULL,
  `auctionID` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
