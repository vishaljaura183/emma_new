
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `call_reasons`
--

INSERT INTO `call_reasons` (`id`, `call_reason`, `created_at`, `updated_at`, `ACL`) VALUES
(3, 'Machine issue', NULL, NULL, NULL),
(4, 'Techincal problem in machine', NULL, NULL, NULL),
(5, 'machine counting incorrect votes', NULL, NULL, NULL),
(6, 'Beep sound is low', NULL, NULL, NULL);

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
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ACL` varchar(100) DEFAULT NULL,
  `municipality` varchar(100) DEFAULT NULL,
  `ward` varchar(100) DEFAULT NULL,
  `precinct` varchar(100) DEFAULT NULL,
  `name_of_location` varchar(255) DEFAULT NULL,
  `directions` varchar(255) DEFAULT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `post_office` varchar(100) DEFAULT NULL,
  `ST` varchar(100) DEFAULT NULL,
  `ZIP` varchar(20) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `poll_venues`
--

INSERT INTO `poll_venues` (`id`, `ADA_accessible`, `created_at`, `updated_at`, `ACL`, `municipality`, `ward`, `precinct`, `name_of_location`, `directions`, `address_line_1`, `address_line_2`, `post_office`, `ST`, `ZIP`, `latitude`, `longitude`) VALUES
(1, 'A', NULL, NULL, NULL, 'Reading', '1st Ward', 'Precinct 01', 'Kennedy Towers', '', '300 S. 4th St', '', 'Reading', 'PA', '19602', '40', '-76'),
(2, 'A', NULL, NULL, NULL, 'Reading', '2nd Ward', 'Precinct 01', 'Liberty Fire Company', '', '501 S. 5th St', '5th & Laurel Streets', 'Reading', 'PA', '19602', '43', '-88');

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `service_tickets`
--

INSERT INTO `service_tickets` (`id`, `polling_site_id`, `technician_id`, `address`, `reason_call`, `supply_needed`, `created_at`) VALUES
(3, 2, 4, 'testing addres', 'Technical issue', '5', '2015-08-30 16:09:01'),
(4, 1, 1, 'Tesing address here', 'Test Readon', '4', '2015-08-30 16:12:38'),
(5, 1, 2, '', 'thh', '3,4,5', '2015-09-02 16:13:29'),
(6, 1, 2, 'test', '4,6', '4,6', '2015-09-05 07:37:39'),
(7, 1, 1, 'test123\r\nbc22\r\nPX-143001', '3,6', '3,5', '2015-09-06 07:14:23');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `technician`
--

INSERT INTO `technician` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'shane', 'warne', 'shane_w@gmail.com', '', '', '9898989898', '2015-08-26 18:30:00', NULL),
(2, 'Bob', 'woolmer', 'bobwool@gmail.com', '', '', '7878788787', '2015-08-26 04:47:16', NULL),
(4, 'vishal2', 'jaura', 'vishaljaura.it@gmail.com', 'testing', 'mind@123', '9898989898', '2015-08-30 10:03:54', NULL),
(5, 'te', 'jaura', 'tstind@gmail.com', 'testing', 'testing', '9898989898', '2015-08-30 17:01:42', NULL);

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

--
-- Constraints for dumped tables
--

--
-- Constraints for table `technician_has_poll_venues`
--
ALTER TABLE `technician_has_poll_venues`
  ADD CONSTRAINT `fk_technician_has_poll_venues_poll_venues1` FOREIGN KEY (`poll_venues_id`) REFERENCES `poll_venues` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_technician_has_poll_venues_technician` FOREIGN KEY (`technician_id`) REFERENCES `technician` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
