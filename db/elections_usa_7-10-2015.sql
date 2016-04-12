-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2015 at 08:07 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `elections_usa`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `passcode` varchar(45) DEFAULT NULL,
  `name` varchar(90) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `usertype` varchar(90) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `last_login` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `passcode`, `name`, `email`, `usertype`, `created_at`, `last_login`) VALUES
(1, 'admin', 'admin', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `call_reasons`
--

CREATE TABLE IF NOT EXISTS `call_reasons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `call_reason` varchar(1000) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ACL` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `call_reasons`
--

INSERT INTO `call_reasons` (`id`, `call_reason`, `created_at`, `updated_at`, `ACL`) VALUES
(1, 'Machine issue', NULL, NULL, NULL),
(2, 'Techincal problem in machine', NULL, NULL, NULL),
(3, 'machine counting incorrect votes', NULL, NULL, NULL),
(4, 'Beep sound is low', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `common_election_supplies`
--

CREATE TABLE IF NOT EXISTS `common_election_supplies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `common_supply` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ACL` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `common_election_supplies`
--

INSERT INTO `common_election_supplies` (`id`, `common_supply`, `created_at`, `updated_at`, `ACL`) VALUES
(3, 'abc', NULL, NULL, NULL),
(4, 'def', NULL, NULL, NULL),
(5, 'xyz', NULL, NULL, NULL),
(6, 'pqr', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `poll_venues`
--

CREATE TABLE IF NOT EXISTS `poll_venues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ADA_accessible` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `ACL` varchar(100) DEFAULT NULL,
  `municipality` varchar(100) DEFAULT NULL,
  `ward` varchar(100) DEFAULT NULL,
  `precinct` varchar(100) DEFAULT NULL,
  `voting_district` varchar(1000) NOT NULL,
  `name_of_location` varchar(255) DEFAULT NULL,
  `directions` varchar(255) DEFAULT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `post_office` varchar(100) DEFAULT NULL,
  `ST` varchar(100) DEFAULT NULL,
  `ZIP` varchar(20) DEFAULT NULL,
  `latitude` varchar(90) DEFAULT NULL,
  `longitude` varchar(90) DEFAULT NULL,
  `is_assigned` tinyint(4) NOT NULL DEFAULT '0',
  `assigned_to` int(11) NOT NULL COMMENT 'technician Id here if is_assign is 1ed',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `poll_venues`
--

INSERT INTO `poll_venues` (`id`, `ADA_accessible`, `created_at`, `updated_at`, `ACL`, `municipality`, `ward`, `precinct`, `voting_district`, `name_of_location`, `directions`, `address_line_1`, `address_line_2`, `post_office`, `ST`, `ZIP`, `latitude`, `longitude`, `is_assigned`, `assigned_to`) VALUES
(1, 'A', '2015-10-02 15:59:50', NULL, NULL, NULL, NULL, NULL, 'Reading2', 'Kennedy Towers', 'Main Side', '300 S. 4th St', '', 'Reading', 'PA', '19602', '40.330204', '-75.9305399', 0, 0),
(2, NULL, '2015-10-02 15:59:50', NULL, NULL, NULL, NULL, NULL, 'Reading', 'Liberty Fire Company', '', '501 S. 5th St', NULL, 'Reading', 'PA', '19602', '40.327519', '-75.927789', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_tickets`
--

CREATE TABLE IF NOT EXISTS `service_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `polling_site_id` int(11) NOT NULL,
  `technician_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `reason_call` text NOT NULL,
  `supply_needed` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0= open, 1 = Closed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `service_tickets`
--

INSERT INTO `service_tickets` (`id`, `polling_site_id`, `technician_id`, `address`, `reason_call`, `supply_needed`, `status`, `created_at`) VALUES
(3, 2, 4, 'testing addres', 'Technical issue', '5', 0, '2015-08-30 16:09:01'),
(4, 1, 1, 'Tesing address here', 'Test Readon', '4', 0, '2015-08-30 16:12:38'),
(7, 1, 1, 'test123\r\nbc22\r\nPX-143001', '3,6', '3,5', 0, '2015-09-06 07:14:23'),
(8, 2, 4, '', 'Techincal problem in machine,Beep sound is low', '4', 0, '2015-09-13 11:55:54'),
(9, 3, 4, '', 'Techincal problem in machine,Beep sound is low', '4', 0, '2015-09-13 11:55:54'),
(10, 6, 4, '', 'Techincal problem in machine,Beep sound is low', '4', 1, '2015-09-13 11:55:55'),
(11, 394, 1, '', 'machine counting incorrect votes', '3', 0, '2015-09-13 12:28:49'),
(12, 397, 1, '', 'machine counting incorrect votes', '3', 0, '2015-09-13 12:28:54'),
(13, 2, 2, '', 'machine counting incorrect votes,Other', 'xyz', 0, '2015-10-01 17:46:43'),
(14, 1, 2, '', 'Techincal problem in machine,Other,Testing here other call reason', 'abc', 0, '2015-10-02 07:04:15'),
(15, 2, 4, '', 'Techincal problem in machine,machine counting incorrect votes', 'abc', 0, '2015-10-02 07:15:34'),
(16, 2, 4, '', 'Beep sound is low,other reasno of call here', 'def', 0, '2015-10-02 07:22:54'),
(17, 1, 2, '', 'Machine issue,Techincal problem in machine,New issue here', 'abc,xyz,Pen Pencil etc', 0, '2015-10-02 08:52:47'),
(18, 1, 2, '', 'Machine issue,Techincal problem in machine,New issue here', 'abc,xyz,Pen Pencil etc', 0, '2015-10-02 08:53:41'),
(19, 1, 2, '', 'Machine issue,Techincal problem in machine,New issue here', 'abc,xyz,Pen Pencil etc', 0, '2015-10-02 08:56:20'),
(20, 1, 2, '', 'Machine issue,Techincal problem in machine,New issue here', 'abc,xyz,Pen Pencil etc', 0, '2015-10-02 08:56:53'),
(21, 1, 5, '', 'Beep sound is low,Call reason is complicated', 'def,New suply here', 0, '2015-10-02 09:01:31'),
(22, 1, 5, '', 'Beep sound is low,Call reason is complicated', 'def,New suply here', 0, '2015-10-02 09:03:20'),
(23, 1, 5, '', 'Beep sound is low,Call reason is complicated', 'def,New suply here', 0, '2015-10-02 09:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `setup_elections`
--

CREATE TABLE IF NOT EXISTS `setup_elections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_personal` varchar(255) DEFAULT NULL,
  `common_repair_call_terms` blob,
  `setup_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `technician`
--

CREATE TABLE IF NOT EXISTS `technician` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(90) NOT NULL,
  `last_name` varchar(90) NOT NULL,
  `email` varchar(90) NOT NULL,
  `username` varchar(90) NOT NULL,
  `password` varchar(90) NOT NULL,
  `phone` varchar(55) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `technician`
--

INSERT INTO `technician` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'shane', 'warne', 'shane_w@gmail.com', '', '', '9876543210', '2015-08-26 18:30:00', NULL),
(2, 'Bob2', 'woolmer', 'technician2@tbltechnerds.com', 'boby', '', '6458256363', '2015-08-26 04:47:16', NULL),
(4, 'Technician', 'wough', 'technician@tbltechnerds.com', 'testing', 'mind@123', '1234567890', '2015-08-30 10:03:54', NULL),
(5, 'te', 'tech', 'testing@gmail.com', 'testing', 'testing', '126545987', '2015-08-30 17:01:42', NULL),
(6, 'Tester', 'TesterLast', 'email@test.com', 'usernam_test', 'Pass', '', '2015-09-10 17:01:01', NULL),
(7, 'Tester', 'TesterLast', 'email@test.com', 'usernam_test', 'Pass', '', '2015-09-10 19:10:50', NULL),
(8, 'Tester', 'TesterLast', 'email@test.com', 'usernam_test', 'Pass', '', '2015-09-10 19:29:26', NULL),
(9, 'Tester', 'TesterLast', 'email@test.com', 'usernam_test', 'Pass', '', '2015-09-10 19:32:14', NULL),
(10, 'Tester', 'TesterLast', 'email@test.com', 'usernam_test', 'Pass', '', '2015-09-22 17:44:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `technician_has_poll_venues`
--

CREATE TABLE IF NOT EXISTS `technician_has_poll_venues` (
  `technician_id` int(10) unsigned NOT NULL,
  `poll_venues_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`technician_id`,`poll_venues_id`),
  KEY `fk_technician_has_poll_venues_poll_venues1_idx` (`poll_venues_id`),
  KEY `fk_technician_has_poll_venues_technician_idx` (`technician_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_data`
--

CREATE TABLE IF NOT EXISTS `ticket_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clerk_name` varchar(100) NOT NULL,
  `cellphone` varchar(90) NOT NULL,
  `homephone` varchar(90) NOT NULL,
  `inspector_dropoff_loc` varchar(255) NOT NULL,
  `num_votes_cast` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `service_ticket_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ticket_data`
--

INSERT INTO `ticket_data` (`id`, `clerk_name`, `cellphone`, `homephone`, `inspector_dropoff_loc`, `num_votes_cast`, `comments`, `service_ticket_id`, `created_at`) VALUES
(1, 'Tester', '9898989898', '1234567890', 'Carvel Building', '', 'testing comments here', 10, '2015-09-23 18:18:08');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `technician_has_poll_venues`
--
ALTER TABLE `technician_has_poll_venues`
  ADD CONSTRAINT `fk_technician_has_poll_venues_poll_venues1` FOREIGN KEY (`poll_venues_id`) REFERENCES `poll_venues` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_technician_has_poll_venues_technician` FOREIGN KEY (`technician_id`) REFERENCES `technician` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
