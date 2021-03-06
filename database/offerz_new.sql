-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2016 at 04:18 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `offerz_new`
--
CREATE DATABASE IF NOT EXISTS `offerz_new` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `offerz_new`;

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
(1, 5, 'James Sampson Accepted a request from Pizza Hut', '', 5, '2016-02-10 07:00:34'),
(2, 6, 'Mike Angeleno Accepted a request from Lego ', '', 5, '2016-02-08 07:00:34'),
(3, 5, 'Jessica Monfredo Shared TEAM DINNER AT MONTYS from Montys', '', 5, '2016-02-10 07:02:50'),
(4, 6, 'Jason McNeil Declined Toonie Tuesday Breakfasts from Microsoft', '', 5, '2016-02-11 00:04:25'),
(5, 5, 'Jason McNeil Declined Toonie Tuesday Breakfasts from Microsoft\r\n', '', 5, '2016-02-11 00:04:25'),
(6, 0, 'Bill Micheals Shared TEAM DINNER AT MONTYS from Montys ', '', 5, '2016-02-11 00:10:22'),
(7, 5, 'Bill Micheals Shared TEAM DINNER AT MONTYS from Montys', '', 5, '2016-02-11 00:10:22'),
(8, 0, 'Bill Micheals Shared TEAM DINNER AT MONTYS from Montys', '', 5, '2016-02-11 00:11:18'),
(9, 0, 'fghfghfgh sdeffsfsf', '', 5, '2016-02-11 02:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(90) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(90) NOT NULL,
  `stripe_cust_id` varchar(90) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(90) NOT NULL,
  `password` varchar(90) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=normal clients, 2=admin userr',
  `description` text NOT NULL,
  `website` varchar(255) NOT NULL,
  `plan_start_date` varchar(90) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `oauth_token` varchar(255) NOT NULL,
  `oauth_secret_token` varchar(255) NOT NULL,
  `screen_name` varchar(255) NOT NULL,
  `twitter_id` varchar(255) NOT NULL,
  `twt_followers` varchar(50) NOT NULL,
  `twt_tweets` varchar(50) NOT NULL,
  `twt_retweets` varchar(50) NOT NULL,
  `twt_favorites` varchar(50) NOT NULL,
  `twt_pic` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active, 0=deleted',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `username`, `stripe_cust_id`, `email`, `phone`, `password`, `role`, `description`, `website`, `plan_start_date`, `plan_id`, `image_path`, `image_name`, `oauth_token`, `oauth_secret_token`, `screen_name`, `twitter_id`, `twt_followers`, `twt_tweets`, `twt_retweets`, `twt_favorites`, `twt_pic`, `status`, `created_at`) VALUES
(1, 'John', 'Doe', '', 'john@example.com', '', 'email.com@gs.com', 1, '', '', '', 0, '', 'testing.png', '', '', '', '', '', '', '', '', '', 1, '2015-10-29 12:07:34'),
(2, 'Vishal', 'vishal_betasoft', '', 'vishal@gmail.com', '', 'test', 1, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 1, '2015-10-29 12:07:34'),
(3, 'tesing', 'testst', '', 'sdf@bgmail.om', '', 'test', 1, '', '', '', 0, '', 'yatch2.jpg', '', '', '', '', '', '', '', '', '', 1, '2015-10-29 12:07:34'),
(4, 'Daren', 'darren', '', 'darren@gmail.com', '', 'test', 1, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 1, '2015-10-29 12:24:40'),
(5, 'vishal kumar jaura', 'test', '', 'test@gmail.com', '546445', 'test', 1, 'this is description here', '', '', 0, '', '6543f9e3f03ac59c99d778f501a2b16bimg_x.png', '412899549-RN2OETlVYX0GpVr8mwjJoRzFte0ONH6axyT4XTYo', 'Ep3amF53d98tO0ZKzfjlEOni1vtBdDAyg71dZfCXXCTEX', 'vkarora42', '412899549', '2', '61', '0', '3', 'http://pbs.twimg.com/profile_images/564044692711424001/VkK9l1xu_normal.jpeg', 1, '2015-10-30 10:59:18'),
(6, 'vishalj', 'vishalj', '', 'vishalj@gmail.com', '', 'test', 1, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 1, '2015-10-30 11:11:21'),
(8, 'vj', 'vishal', '', 'vishall@gmail.com', '', 'test', 1, '', '', '', 0, '', 'election.jpg', '', '', '', '', '', '', '', '', '', 1, '2015-11-02 09:24:48'),
(9, 'vishaljaura', 'vishalj', '', 'vishalj@gmail.com', '', 'mind@123', 1, 'testing is great', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 1, '2015-11-02 12:08:08'),
(10, 'vishal2', 'vishaljaura', '', 'vishaljaura@gmail.com', '', 'mind@123', 2, 'testing', '', '', 0, '', '8a8d9b461a8116097b39b04e9f005a21vishal.jpg', '412899549-RN2OETlVYX0GpVr8mwjJoRzFte0ONH6axyT4XTYo', 'Ep3amF53d98tO0ZKzfjlEOni1vtBdDAyg71dZfCXXCTEX', 'sandeepsingla90', '412899549', '31', '82', '0', '46', 'http://pbs.twimg.com/profile_images/661120954051883009/crR8zEAD_normal.jpg', 1, '2015-11-20 07:33:43'),
(11, 'sdfksdfj', 'sdkfsjdflksdjf', '', 'sdflksjdf@vmia.com', '', 'test', 1, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 1, '2015-11-20 07:54:30'),
(12, 'Testing33V', '', '', 'testV@gmail.com', '', 'testing', 1, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 1, '2015-12-22 07:49:50'),
(13, '', '', '', '', '', '', 1, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 1, '2015-12-23 09:36:04'),
(14, 'sdf', '', '', 'newww@gmail.com', '', '12345', 1, '', 'sdf', '', 0, '', '', '', '', '', '', '', '', '', '', '', 1, '2015-12-23 09:37:10'),
(15, 'testingg', '', '', 'hte@gmail.com', '', '12345', 1, '', 'test.com', '', 2, '', '', '', '', '', '', '', '', '', '', '', 1, '2015-12-23 10:37:19'),
(16, 'Testing33V', '', '', 'hestt@gmail.com', '', 'mind@123', 1, '', 'http://google.com', '2015-12-22', 2, '', '', '', '', '', '', '', '', '', '', '', 1, '2015-12-23 10:52:23'),
(17, 'testing', 'viskumar', 'cus_7cDwem3czpbNTY', 'viskumar@betasoftsystems.com', '', '12345', 1, '', 'testin.com', '2015-12-27', 2, '', '', '412899549-RN2OETlVYX0GpVr8mwjJoRzFte0ONH6axyT4XTYo', 'Ep3amF53d98tO0ZKzfjlEOni1vtBdDAyg71dZfCXXCTEX', 'vkarora42', '412899549', '2', '61', '0', '3', 'http://pbs.twimg.com/profile_images/564044692711424001/VkK9l1xu_normal.jpeg', 1, '2015-12-28 11:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `client_queries`
--

CREATE TABLE IF NOT EXISTS `client_queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_query` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `status` varchar(90) NOT NULL,
  `response_content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `client_queries`
--

INSERT INTO `client_queries` (`id`, `content_query`, `client_id`, `status`, `response_content`, `created_at`) VALUES
(1, 'Testing conetnet', 5, '', '', '2015-11-13 08:10:14'),
(2, 'tst', 5, '', '', '2015-11-13 10:45:47'),
(3, 'new', 5, '', '', '2015-11-13 10:46:06'),
(4, 'Testing suport', 5, '', '', '2015-11-16 06:10:47'),
(5, 'Testing notes here', 5, '', '', '2015-11-16 12:13:59');

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

CREATE TABLE IF NOT EXISTS `invites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `is_accepted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=Not responded, 1= Accepted, 2= declined',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `invites`
--

INSERT INTO `invites` (`id`, `email`, `client_id`, `is_accepted`, `is_deleted`, `created_at`) VALUES
(1, 'testing@gmail.com', 5, 1, 0, '2016-02-10 09:25:41'),
(2, 'testing2@gmail.com', 5, 0, 1, '2016-02-09 13:31:29'),
(3, 'rock@gmail.com', 5, 0, 1, '2016-02-09 12:18:06'),
(4, 'new1@gmail.com', 5, 0, 1, '2016-02-09 13:29:20'),
(5, 'new23@gmail.com', 5, 0, 1, '2016-02-09 11:40:20'),
(6, 'sdfsdf@gmail.com', 5, 0, 1, '2016-02-09 11:40:29'),
(7, 'testingd@gmail.com', 5, 2, 1, '2016-02-10 09:44:19'),
(8, 'testingd@gmail.com', 5, 2, 1, '2016-02-10 13:48:07'),
(9, 'testingdd@gmail.com', 5, 0, 1, '2016-02-10 13:54:02'),
(10, 'new123@gmail.com', 5, 0, 1, '2016-02-10 13:54:43'),
(11, 'testing@gmail.com', 17, 1, 0, '2016-02-10 14:30:51'),
(12, 'jdsfsafsadlhf@gmail.com', 5, 0, 0, '2016-02-11 11:10:22'),
(13, 'har@gmail.com', 5, 1, 0, '2016-02-17 14:07:11'),
(14, 'vishal.kumar@mobilyte.com', 5, 0, 0, '2016-02-12 11:53:29');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `editable_text` text NOT NULL,
  `not_editable_text` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `start_date` varchar(90) NOT NULL,
  `is_paused` varchar(90) NOT NULL DEFAULT '0' COMMENT '0= not paused, 1=paused',
  `date_send_on` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `title`, `editable_text`, `not_editable_text`, `client_id`, `image_name`, `start_date`, `is_paused`, `date_send_on`, `created_at`) VALUES
(1, 'Testing offer here', 'Testing', 'teting now', 5, 'Testing offer here', 'now', '0', '', '2016-02-18 15:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `offers_stat`
--

CREATE TABLE IF NOT EXISTS `offers_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `offer_accepted` int(11) NOT NULL,
  `offer_declined` int(11) NOT NULL,
  `total_offer_received` int(11) NOT NULL,
  `last_offer_date` varchar(90) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `offers_stat`
--

INSERT INTO `offers_stat` (`id`, `user_id`, `client_id`, `offer_accepted`, `offer_declined`, `total_offer_received`, `last_offer_date`, `created_at`) VALUES
(1, 5, 5, 0, 0, 1, '', '2016-02-18 15:12:39'),
(2, 6, 5, 0, 0, 1, '', '2016-02-18 15:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_name` varchar(90) NOT NULL,
  `plan_title` varchar(255) NOT NULL,
  `price` varchar(50) NOT NULL,
  `frequecy_plan` enum('daily','weekly','monthly','yearly') NOT NULL DEFAULT 'monthly',
  `description` text NOT NULL,
  `ambassador_limit` int(11) NOT NULL,
  `teams_limit` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Enable, 0= Disabled',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `plan_name`, `plan_title`, `price`, `frequecy_plan`, `description`, `ambassador_limit`, `teams_limit`, `status`) VALUES
(1, 'individual', 'individual ', '99', 'monthly', 'testing', 10, 1, 1),
(2, 'Studio', 'Studio', '249', 'monthly', '', 50, 5, 1),
(3, 'Enterprise', 'Enterprise', '499', 'monthly', '', -1, -1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subc_id` varchar(90) NOT NULL,
  `client_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `subc_id`, `client_id`, `status`, `created_at`) VALUES
(4, 'sub_7cxyvVKtGrkcsm', 17, 'active', '2015-12-30 11:17:33');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `is_deleted` varchar(90) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `client_id`, `is_deleted`, `created_at`) VALUES
(1, 'Team 1', 5, '1453188613', '2015-11-04 12:13:22'),
(2, 'Team 2', 5, '1453188801', '2015-11-04 12:19:41'),
(3, 'Team 3', 5, '0', '2015-11-05 07:37:34'),
(4, 'Testing Team', 5, '0', '2015-11-05 08:17:56'),
(5, 'Team Atlanta', 5, '0', '2015-11-05 11:39:43'),
(6, 'testtt', 5, '0', '2015-11-17 09:29:09'),
(7, 'sdfsdf65', 5, '0', '2015-11-17 09:31:37'),
(8, 'TestingV', 10, '0', '2015-11-20 07:45:33'),
(9, 'NewAdmind team', 10, '0', '2015-11-24 10:04:24'),
(10, 'etrterte333', 5, '0', '2015-12-17 05:23:29'),
(11, 'testfgf65464', 5, '0', '2016-01-05 05:55:57'),
(12, 'MyNewTeam', 5, '0', '2016-01-06 11:20:28'),
(13, 'My another new team', 5, '0', '2016-01-08 09:37:35'),
(14, 'TESTINGGGG', 5, '1453283321', '2016-01-20 09:27:00'),
(15, 'TESTINGGGG', 5, '1453283309', '2016-01-20 09:32:26'),
(16, 'NEW TEAM AGAIN', 5, '1453283304', '2016-01-20 09:42:33'),
(17, 'testtttte', 5, '1453283300', '2016-01-20 09:44:39'),
(18, 'testtttte', 5, '1453283295', '2016-01-20 09:44:57'),
(19, 'testtttte', 5, '1453283325', '2016-01-20 09:45:58'),
(20, 'newteam23', 5, '0', '2016-01-20 09:56:58'),
(21, 'ANOthhh', 5, '0', '2016-01-21 09:49:34'),
(22, 'VICKYYTEMA', 5, '1453460793', '2016-01-22 11:05:06'),
(23, 'VICKYYTEMA', 5, '1453460789', '2016-01-22 11:05:39'),
(24, 'VICKYYTEMA', 5, '0', '2016-01-22 11:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(90) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(90) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `oauth_token` varchar(255) NOT NULL,
  `oauth_secret_token` varchar(255) NOT NULL,
  `screen_name` varchar(255) NOT NULL,
  `twitter_id` varchar(255) NOT NULL,
  `twt_followers` varchar(90) NOT NULL,
  `twt_pic` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `description`, `image_path`, `image_name`, `oauth_token`, `oauth_secret_token`, `screen_name`, `twitter_id`, `twt_followers`, `twt_pic`, `created_at`) VALUES
(4, 'Vishal2', '', 'testing2@gmail.com', 'rereee', '', '', '', '', '', '', '', '', '', '2015-11-26 09:59:43'),
(5, 'Vishal', '', 'testing@gmail.com', '123456', '', '', '', '3005294516-iKWwf3sBavDHScNFomfi4WmWI78vpmScfQbbCGX', 'brZwTQfOidDq9qmNYfFXyAgkpdScx4PaUDXWiEsExOQ0q', 'sandeepsingla90', '3005294516', '31', 'http://pbs.twimg.com/profile_images/661120954051883009/crR8zEAD_normal.jpg', '2015-11-26 10:01:11'),
(6, 'Vishal', '', 'har@gmail.com', '123456', '', '', '', '', '', 'vkarora42', '', '2', 'http://pbs.twimg.com/profile_images/564044692711424001/VkK9l1xu_normal.jpeg', '2015-11-26 10:41:55'),
(7, 'Vishal', '', 'rock@gmail.com', '123456', '', '', '', '123456', '123456', 'vishal_betasoft', '123456', '1', 'http://abs.twimg.com/sticky/default_profile_images/default_profile_6_normal.png', '2016-02-10 09:46:02'),
(8, 'Vishal', '', 'testing333@gmail.com', '123456', '', '', '', '123456', '123456', 'sandeepsingla90', '123456', '31', 'http://pbs.twimg.com/profile_images/661120954051883009/crR8zEAD_normal.jpg', '2016-02-10 10:10:15'),
(9, 'Vishal', '', 'testing3d33@gmail.com', '123456', '', '', '', '123456', '123456', 'sandeepsingla90', '123456', '31', 'http://pbs.twimg.com/profile_images/661120954051883009/crR8zEAD_normal.jpg', '2016-02-10 10:13:13');

-- --------------------------------------------------------

--
-- Table structure for table `users_clients_relation`
--

CREATE TABLE IF NOT EXISTS `users_clients_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `request_status` tinyint(4) NOT NULL COMMENT '0=not responded, 1= accepted, 2= decliened',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users_clients_relation`
--

INSERT INTO `users_clients_relation` (`id`, `user_email`, `client_id`, `request_status`, `created_at`) VALUES
(7, 'test222@gmail.com', 5, 0, '2016-01-21 10:05:32');

-- --------------------------------------------------------

--
-- Table structure for table `users_queries`
--

CREATE TABLE IF NOT EXISTS `users_queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_query` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(90) NOT NULL,
  `response_content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users_queries`
--

INSERT INTO `users_queries` (`id`, `content_query`, `user_id`, `status`, `response_content`, `created_at`) VALUES
(1, 'This is the message here for query', 5, '', 'this is my response', '2015-12-10 06:08:08'),
(2, 'Thsi is another query', 5, '', '', '2015-12-10 06:40:09'),
(3, 'This is the message here for query', 5, '', '', '2015-12-10 06:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_offers`
--

CREATE TABLE IF NOT EXISTS `user_offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=new( Not shared), 1=shared, 2=Declined',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_offers`
--

INSERT INTO `user_offers` (`id`, `user_id`, `offer_id`, `client_id`, `status`, `created_at`) VALUES
(1, 5, 1, 5, 1, '2016-02-18 15:12:39'),
(2, 6, 1, 5, 0, '2016-02-18 15:12:39');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
