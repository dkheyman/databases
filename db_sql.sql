-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 07, 2016 at 03:44 PM
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

--
-- Dumping data for table `Auction`
--

INSERT INTO `Auction` (`auctionID`, `asking_price`, `starting_price`, `userID`, `isbn`, `start_time`, `end_time`, `description`) VALUES
('abcd', 80, 40, 'john03', '1234abcd1234a', '2016-03-05 15:28:47', '2016-03-07 00:00:00', 'Test'),
('efgh', 100, 50, 'john03', 'qwerty123456q', '2016-03-07 14:19:31', '2016-03-18 00:00:00', 'test 2');

-- --------------------------------------------------------

--
-- Table structure for table `Bid`
--

CREATE TABLE `Bid` (
  `buyerID` varchar(32) NOT NULL,
  `auctionID` varchar(32) NOT NULL,
  `value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Bid`
--

INSERT INTO `Bid` (`buyerID`, `auctionID`, `value`) VALUES
('john04', 'abcd', 50),
('john04', 'efgh', 75);

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
  `password` varchar(40) NOT NULL,
  `type` enum('buyer','seller') NOT NULL,
  `rating` float DEFAULT NULL,
  `email` varchar(32) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`userID`, `password`, `type`, `rating`, `email`, `creation_date`) VALUES
('john01', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'buyer', NULL, 'd.kheyman@gmail.com', '2016-02-29 11:26:28'),
('john02', '00e626e45329390f5f94eff55c1b5fab92f102a6', 'seller', NULL, 'd.kheyman@gmail.com', '2016-03-02 13:13:46'),
('john03', 'cd386bd7a84266cbdc7048f6c110f791a430c5bd', 'seller', NULL, 'd.kheyman@gmail.com', '2016-03-04 16:22:36'),
('john04', '4233137d1c510f2e55ba5cb220b864b11033f156', 'buyer', NULL, 'd.kheyman@gmail.com', '2016-03-04 16:23:34'),
('chad01', '4233137d1c510f2e55ba5cb220b864b11033f156', 'seller', NULL, 'd.kheyman@gmail.com', '2016-03-05 17:19:19');

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

--
-- Dumping data for table `Watch`
--

INSERT INTO `Watch` (`buyerID`, `auctionID`) VALUES
('john04', 'abcd'),
('john04', 'efgh');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
