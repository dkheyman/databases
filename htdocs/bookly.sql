-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2016 at 08:38 PM
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
  `description` text NOT NULL,
  `finished` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Auction`
--

INSERT INTO `Auction` (`auctionID`, `asking_price`, `starting_price`, `userID`, `isbn`, `start_time`, `end_time`, `description`, `finished`) VALUES
('ODAPFGQHQAEACQEZFQDZEWBLGVORXQNL', 10, 10, 'john02', '9780140177398', '2016-03-18 19:33:48', '2016-04-01 16:00:00', 'Lovely little book', 0),
('FKVTIHEZJRMNAZFDLVHVXLLDDBAEMOCS', 25, 25, 'john02', '9780743273565', '2016-03-18 19:42:53', '2016-03-30 06:50:00', 'I have never read anything this crazy!!!!<3<3<3', 0),
('LVJBPGPILTAJDPEBKIBDOYQBUXKQNOVY', 6.05, 5.99, 'john02', '9784103534228', '2016-03-18 19:44:21', '2016-04-05 12:00:00', 'Hated this thing.', 0),
('KFAZLQIWKJFNYKPJSQNHPDIJASAOGVNQ', 100, 100, 'john04', '9780451529060', '2016-03-18 19:50:01', '2016-03-20 16:40:00', 'Pretty crappy quality, has a few coffee stains.', 0),
('DRCHQIKYRIQXWPVSHHTUURYHXYJNQIAT', 40, 40, 'john04', '9780140177398', '2016-03-18 19:50:48', '2016-04-01 23:40:00', 'Neat little bugger.', 0),
('OOJXXMNHBBBAJVMVUXWUTDNACLUQMGSA', 45.12, 15.5, 'john04', '9780876856833', '2016-03-18 19:57:40', '2016-04-01 12:04:00', 'Have no use for this book anymore.', 0),
('HMWTCZOJZGEVRHYWEWSAAMUOTGKBLGMT', 50.4, 40.5, 'john04', '9782253098058', '2016-03-18 19:58:08', '2016-04-01 19:00:00', 'Good joke.', 0);

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
('john03', 'LVJBPGPILTAJDPEBKIBDOYQBUXKQNOVY', 6.01),
('john03', 'HMWTCZOJZGEVRHYWEWSAAMUOTGKBLGMT', 50),
('john03', 'HMWTCZOJZGEVRHYWEWSAAMUOTGKBLGMT', 50.4),
('john01', 'OOJXXMNHBBBAJVMVUXWUTDNACLUQMGSA', 45.12),
('john01', 'LVJBPGPILTAJDPEBKIBDOYQBUXKQNOVY', 6.05);

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

--
-- Dumping data for table `Book`
--

INSERT INTO `Book` (`title`, `isbn`, `aLast`, `aFirst`, `imageURL`, `book_condition`, `genre`, `publisher`, `language`, `binding`, `date`) VALUES
('The Catcher in the Rye', '979031676948', 'Salinger', 'JD', NULL, 'New', 'Fiction', 'Little, Brown and Company', 'English', 'Softcover', '0000-00-00'),
('The Great Gatsby', '9780743273565', 'Fitzgerald', 'F.Scott', NULL, 'Used:Excellent', 'Fiction', 'Scribner', 'English', 'Hardcover', '2004-09-30'),
('Of Mice and Men', '9780140177398', 'Steinbeck', 'John', NULL, 'Used:Poor', 'Fiction', 'Penguin Books', 'English', 'None', '1993-09-01'),
('You Get So Alone at Times that It Just Makes Sense', '9780876856833', 'Bukowski', 'Charles', NULL, 'Used:Good', 'Poetry', 'Black Sparrow Press', 'English', 'Softcover', '2002-05-31'),
('The Road Not Taken and Other Poems', '9780486275505', 'Swift', 'Jonathan', NULL, 'New', 'Poetry', 'Dover Publications', 'English', 'Softcover', '1993-04-19'),
('1Q84 Book 1', '9784103534228', 'Murakami', 'Haruki', NULL, 'Used:Poor', 'Fiction', 'Shinchosha', 'Japanese', 'None', '2009-05-01'),
('The Origin of Species', '9780451529060', 'Darwin', 'Charles', NULL, 'New', 'Non-fiction', 'Signet', 'English', 'Hardcover', '2003-09-02'),
('Le Compte de Monte Cristo, Tome 1', '9782253098058', 'Dumas', 'Alexandre', NULL, 'Used:Fair', 'Classics', 'Livre de Poche', 'French', 'Leather', '1998-07-01');

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

--
-- Dumping data for table `Reviews`
--

INSERT INTO `Reviews` (`reviewerID`, `reviewedID`, `review`, `rating`) VALUES
('john03', 'john02', '                            Whatever', 3),
('john03', 'john04', '                            Cool guy.', 4),
('john01', 'john02', '                            Cool again', 3);

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
('john01', '4233137d1c510f2e55ba5cb220b864b11033f156', 'buyer', NULL, 'd.kheyman@gmail.com', '2016-03-18 18:27:14'),
('john02', '4233137d1c510f2e55ba5cb220b864b11033f156', 'seller', NULL, 'chad.robert.m@gmail.com', '2016-03-18 18:32:53'),
('john03', '4233137d1c510f2e55ba5cb220b864b11033f156', 'buyer', NULL, 'd.kheyman@gmail.com', '2016-03-18 18:45:41'),
('john04', '4233137d1c510f2e55ba5cb220b864b11033f156', 'seller', NULL, 'chad.robert.m@gmail.com', '2016-03-18 18:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `View`
--

CREATE TABLE `View` (
  `buyerID` varchar(32) NOT NULL,
  `auctionID` varchar(32) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `View`
--

INSERT INTO `View` (`buyerID`, `auctionID`, `timestamp`) VALUES
('john03', 'FKVTIHEZJRMNAZFDLVHVXLLDDBAEMOCS', '2016-03-18 19:46:28'),
('john03', 'FKVTIHEZJRMNAZFDLVHVXLLDDBAEMOCS', '2016-03-18 19:46:37'),
('john03', 'LVJBPGPILTAJDPEBKIBDOYQBUXKQNOVY', '2016-03-18 19:46:46'),
('john03', 'LVJBPGPILTAJDPEBKIBDOYQBUXKQNOVY', '2016-03-18 19:47:14'),
('john03', 'LVJBPGPILTAJDPEBKIBDOYQBUXKQNOVY', '2016-03-18 19:48:00'),
('john03', 'ODAPFGQHQAEACQEZFQDZEWBLGVORXQNL', '2016-03-18 19:48:33'),
('john03', 'ODAPFGQHQAEACQEZFQDZEWBLGVORXQNL', '2016-03-18 19:48:57'),
('john04', 'FKVTIHEZJRMNAZFDLVHVXLLDDBAEMOCS', '2016-03-18 19:54:28'),
('john03', 'FKVTIHEZJRMNAZFDLVHVXLLDDBAEMOCS', '2016-03-18 20:09:21'),
('john03', 'HMWTCZOJZGEVRHYWEWSAAMUOTGKBLGMT', '2016-03-18 20:11:28'),
('john03', 'OOJXXMNHBBBAJVMVUXWUTDNACLUQMGSA', '2016-03-18 20:11:34'),
('john03', 'HMWTCZOJZGEVRHYWEWSAAMUOTGKBLGMT', '2016-03-18 20:11:36'),
('john03', 'HMWTCZOJZGEVRHYWEWSAAMUOTGKBLGMT', '2016-03-18 20:11:46'),
('john03', 'HMWTCZOJZGEVRHYWEWSAAMUOTGKBLGMT', '2016-03-18 20:11:57'),
('john03', 'HMWTCZOJZGEVRHYWEWSAAMUOTGKBLGMT', '2016-03-18 20:18:02'),
('john01', 'OOJXXMNHBBBAJVMVUXWUTDNACLUQMGSA', '2016-03-18 20:19:17'),
('john01', 'OOJXXMNHBBBAJVMVUXWUTDNACLUQMGSA', '2016-03-18 20:19:31'),
('john01', 'OOJXXMNHBBBAJVMVUXWUTDNACLUQMGSA', '2016-03-18 20:19:37'),
('john01', 'LVJBPGPILTAJDPEBKIBDOYQBUXKQNOVY', '2016-03-18 20:19:43'),
('john01', 'LVJBPGPILTAJDPEBKIBDOYQBUXKQNOVY', '2016-03-18 20:19:51'),
('john01', 'HMWTCZOJZGEVRHYWEWSAAMUOTGKBLGMT', '2016-03-18 20:22:06'),
('john01', 'HMWTCZOJZGEVRHYWEWSAAMUOTGKBLGMT', '2016-03-18 20:35:54'),
('john01', 'OOJXXMNHBBBAJVMVUXWUTDNACLUQMGSA', '2016-03-18 20:36:04'),
('john01', 'OOJXXMNHBBBAJVMVUXWUTDNACLUQMGSA', '2016-03-18 20:36:07');

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
('john03', 'FKVTIHEZJRMNAZFDLVHVXLLDDBAEMOCS'),
('john01', 'OOJXXMNHBBBAJVMVUXWUTDNACLUQMGSA');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
