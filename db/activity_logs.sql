-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2016 at 08:34 AM
-- Server version: 5.6.11
-- PHP Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `offerz_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `log_client` text NOT NULL,
  `log_admin` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `log_client`, `log_admin`, `client_id`, `created_at`) VALUES
(1, 5, 'James Sampson Accepted a request from Pizza Hut', '', 5, '2016-02-10 12:30:34'),
(2, 6, 'Mike Angeleno Accepted a request from Lego ', '', 5, '2016-02-08 12:30:34'),
(3, 5, 'Jessica Monfredo Shared TEAM DINNER AT MONTYS from Montys', '', 5, '2016-02-10 12:32:50'),
(4, 6, 'Jason McNeil Declined Toonie Tuesday Breakfasts from Microsoft', '', 5, '2016-02-11 05:34:25'),
(5, 5, 'Jason McNeil Declined Toonie Tuesday Breakfasts from Microsoft\r\n', '', 5, '2016-02-11 05:34:25'),
(6, 0, 'Bill Micheals Shared TEAM DINNER AT MONTYS from Montys ', '', 5, '2016-02-11 05:40:22'),
(7, 5, 'Bill Micheals Shared TEAM DINNER AT MONTYS from Montys', '', 5, '2016-02-11 05:40:22'),
(8, 0, 'Bill Micheals Shared TEAM DINNER AT MONTYS from Montys', '', 5, '2016-02-11 05:41:18'),
(9, 0, 'fghfghfgh sdeffsfsf', '', 5, '2016-02-11 07:40:32');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
