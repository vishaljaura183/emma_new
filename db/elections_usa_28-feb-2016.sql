-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2016 at 10:59 AM
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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `passcode`, `name`, `email`, `usertype`, `created_at`, `last_login`) VALUES
(1, 'admin', 'admin', NULL, 'vishaljaura183@gmail.com', '1', NULL, NULL),
(2, 'RFSHOUP', 'ELCTION', NULL, 'rerjwer@gmail.com', '1', NULL, NULL),
(5, 'testing', 'mind', 'Testing22', 'testing@gmail.com', '2', '2015-12-06 11:15:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `call_reasons`
--

CREATE TABLE IF NOT EXISTS `call_reasons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `call_reason` varchar(1000) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `admin_id` int(11) NOT NULL,
  `ACL` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `call_reasons`
--

INSERT INTO `call_reasons` (`id`, `call_reason`, `created_at`, `updated_at`, `admin_id`, `ACL`) VALUES
(1, 'Machine issue', NULL, NULL, 0, NULL),
(2, 'Techincal problem in machine', NULL, NULL, 0, NULL),
(3, 'machine counting incorrect votes', NULL, NULL, 0, NULL),
(4, 'Beep sound is low', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `common_election_supplies`
--

CREATE TABLE IF NOT EXISTS `common_election_supplies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `common_supply` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `admin_id` int(11) NOT NULL,
  `ACL` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `common_election_supplies`
--

INSERT INTO `common_election_supplies` (`id`, `common_supply`, `created_at`, `updated_at`, `admin_id`, `ACL`) VALUES
(3, 'abc', NULL, NULL, 0, NULL),
(4, 'def', NULL, NULL, 0, NULL),
(5, 'xyz', NULL, NULL, 0, NULL),
(6, 'pqr', NULL, NULL, 0, NULL);

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
  `admin_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=200 ;

--
-- Dumping data for table `poll_venues`
--

INSERT INTO `poll_venues` (`id`, `ADA_accessible`, `created_at`, `updated_at`, `ACL`, `municipality`, `ward`, `precinct`, `voting_district`, `name_of_location`, `directions`, `address_line_1`, `address_line_2`, `post_office`, `ST`, `ZIP`, `latitude`, `longitude`, `is_assigned`, `assigned_to`, `admin_id`) VALUES
(1, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 1st Ward Precinct 01', 'Kennedy Towers', '', '300 S. 4th St', NULL, 'Reading', 'PA', '19602', '40.330204', '-75.9305399', 0, 0, 0),
(2, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 2nd Ward Precinct 01', 'Liberty Fire Company', '', '501 S. 5th St', NULL, 'Reading', 'PA', '19602', '40.3275105', '-75.9279559', 1, 0, 0),
(3, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 3rd Ward Precinct 01', 'Rhodes Apts.', 'Side Entrance', '815 Franklin St.', NULL, 'Reading', 'PA', '19602', '40.333953', '-75.921475', 1, 4, 0),
(4, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 3rd Ward Precinct 02', 'Southern Jr. High', '', '931 Chestnut St', NULL, 'Reading', 'PA', '19602', '40.3322738', '-75.9188907', 0, 0, 0),
(5, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 4th Ward Precinct 01', 'Franklin Towers', '', '120 S. 6th St', NULL, 'Reading', 'PA', '19602', '40.3329077', '-75.9263692', 0, 0, 0),
(6, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 5th Ward Precinct 01', 'Southwest Jr. High', '', '300 Chestnut St', NULL, 'Reading', 'PA', '19602', '40.3318103', '-75.93146', 0, 0, 0),
(7, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 6th Ward Precinct 01', 'Neversink Fire Co.', '', '15-23 N. 3rd St', NULL, 'Reading', 'PA', '19601', '40.3360889', '-75.9317515', 0, 0, 0),
(8, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 6th Ward Precinct 03', 'Lauers Park School', 'Main Entrance', '241 N. 2nd St', NULL, 'Reading', 'PA', '19601', '40.3399605', '-75.9328967', 0, 0, 0),
(9, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 7th Ward Precinct 01', 'YMCA of Reading', '', '631 Washington St', NULL, 'Reading', 'PA', '19601', '40.3370069', '-75.9245756', 0, 0, 0),
(10, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 8th Ward Precinct 01', 'Berks Encore', 'Erdman Hall', '40 N. 9th St', NULL, 'Reading', 'PA', '19601', '40.3362794', '-75.9202867', 0, 0, 0),
(11, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 9th Ward Precinct 02', 'City Hall - Penn Rm', 'Use 8th St Entrance', '815 Washington St', NULL, 'Reading', 'PA', '19601', '40.3373161', '-75.9214946', 0, 0, 0),
(12, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 9th Ward Precinct 05', 'Reading Intermediate School', 'The Citadel', '215 N. 12th St', NULL, 'Reading', 'PA', '19604', '40.3389911', '-75.9137039', 0, 0, 0),
(13, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 10th Ward Precinct 01', 'Amanda E. Stoudt School', '', '321 S. 10th St.', NULL, 'Reading', 'PA', '19602', '40.3300459', '-75.9179968', 0, 0, 0),
(14, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 11th Ward Precinct 02', '10th & Green School', '', '400 N. 10th St.', NULL, 'Reading', 'PA', '19601', '5.6816198', '-61.4005581', 0, 0, 0),
(15, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 11th Ward Precinct 03', '13th & Green School', 'GYM ', '501 N. 13th St', NULL, 'Reading', 'PA', '19604', '40.3275898', '-90.4204562', 0, 0, 0),
(16, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 12th Ward Precinct 01', 'Iglesia Christiana Nueva Esperanza', '', '820 N. 9th St', NULL, 'Reading', 'PA', '19604', '40.348066', '-75.920017', 0, 0, 0),
(17, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 12th Ward Precinct 03', 'Olivet Boys Club #4', '', '722 Mulberry St', NULL, 'Reading', 'PA', '19604', '40.355859', '-75.956752', 0, 0, 0),
(18, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 12th Ward Precinct 05', 'Reading High School', 'Geigle Complex', '801 N. 13th St', NULL, 'Reading', 'PA', '19604', '40.347703', '-75.9107549', 0, 0, 0),
(19, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 13th Ward Precinct 01', 'Marion Fire Co.', '', '9th & Marion Sts', NULL, 'Reading', 'PA', '19604', '', '', 0, 0, 0),
(20, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 13th Ward Precinct 02', 'St. Marks Church', '', '1015 Windsor St', NULL, 'Reading', 'PA', '19604', '40.3488602', '-75.9173605', 0, 0, 0),
(21, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 13th Ward Precinct 05', 'Grace Bible Fellowship Church', '', '1128 Hampden Blvd', NULL, 'Reading', 'PA', '19604', '40.352513', '-75.9107651', 0, 0, 0),
(22, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 14th Ward Precinct 01', 'Centre Park Historic District Headquarters', '', '705-707 N. 5th St', NULL, 'Reading', 'PA', '19601', '40.3460979', '-75.927556', 0, 0, 0),
(23, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 14th Ward Precinct 04', 'Holy Spirit Lutheran Church', '', '421 Windsor St', NULL, 'Reading', 'PA', '19601', '40.3492109', '-75.928875', 0, 0, 0),
(24, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 14th Ward Precinct 05', 'Berks History Center', '', '940 Centre Avenue', NULL, 'Reading', 'PA', '19601', '40.3502389', '-75.9329619', 0, 0, 0),
(25, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 14th Ward Precinct 06', 'Keffer Park Field House', '', '1701 N. 3rd St', NULL, 'Reading', 'PA', '19601', '40.3616397', '-75.9310353', 0, 0, 0),
(26, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 15th Ward Precinct 01', 'Hope Lutheran Church', 'S.S. Class Room', '601 N. Front St', NULL, 'Reading', 'PA', '19601', '40.344719', '-75.93529', 0, 0, 0),
(27, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 15th Ward Precinct 02', 'St. Marks UCC', '', '211 W. Greenwich St', NULL, 'Reading', 'PA', '19601', '40.344933', '-75.938507', 0, 0, 0),
(28, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 15th Ward Precinct 06', 'Northwest Elementary School', '', '820 Clinton Ave', NULL, 'Reading', 'PA', '19601', '40.347459', '-75.946043', 0, 0, 0),
(29, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 15th Ward Precinct 07', 'Islamic Society of Berks County ', '', '101 W. Windsor St', NULL, 'Reading', 'PA', '19601', '40.3493179', '-75.9355686', 0, 0, 0),
(30, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 16th Ward Precinct 01', 'St. Paul''s Lutheran Church', '', '1559 Perkiomen Ave', NULL, 'Reading', 'PA', '19602', '40.3297963', '-75.9065859', 0, 0, 0),
(31, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 16th Ward Precinct 02', 'Southeast Branch Public Library', '', '1426 Perkiomen Ave', NULL, 'Reading', 'PA', '19602', '40.329595', '-75.909158', 0, 0, 0),
(32, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 16th Ward Precinct 04', 'St. Matthews Methodist Church', '', '501 S. 18th St', NULL, 'Reading', 'PA', '19606', '40.3393652', '-75.8650148', 0, 0, 0),
(33, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 16th Ward Precinct 05', 'Pendora Field House', '', '18th & Forrest Sts', NULL, 'Reading', 'PA', '19606', '-37.686634', '144.991392', 0, 0, 0),
(34, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 17th Ward Precinct 01', 'Northeast Branch Public Library', '', '1348 N. 11th St', NULL, 'Reading', 'PA', '19604', '40.3558065', '-75.9159624', 0, 0, 0),
(35, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 17th Ward Precinct 02', 'Northeast Junior High', 'Gymnasium Building', '1216 N. 13th St', NULL, 'Reading', 'PA', '19604', '40.3537874', '-75.9125608', 0, 0, 0),
(36, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 17th Ward Precinct 05', '13th & Union School', 'Room 116', '1600 N. 13th St', NULL, 'Reading', 'PA', '19604', '40.3275898', '-90.4204562', 0, 0, 0),
(37, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 17th Ward Precinct 07', 'Nativity Lutheran Church', 'Fellowship Hall', '1501 N. 13th St', NULL, 'Reading', 'PA', '19604', '40.357892', '-75.9112339', 0, 0, 0),
(38, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 17th Ward Precinct 08', 'Vision Resource Ctr. Of Berks Co.', '', '2020 Hampden Blvd.', NULL, 'Reading', 'PA', '19604', '40.365473', '-75.902588', 0, 0, 0),
(39, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 18th Ward Precinct 01', 'Olivet Boys & Girls Club', '', '1161 Pershing Blvd', NULL, 'Reading', 'PA', '19611', '35.2192102', '-88.1882437', 0, 0, 0),
(40, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 18th Ward Precinct 02', 'Calvary Community Center', '', '201 Noble St', NULL, 'Reading', 'PA', '19611', '40.3265598', '-75.9434209', 0, 0, 0),
(41, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 18th Ward Precinct 03', 'Upland Center at Alvernia Univ.', '', '540 Upland Avenue', NULL, 'Reading', 'PA', '19611', '40.3265598', '-75.9434209', 0, 0, 0),
(42, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 18th Ward Precinct 04', 'Sts. Constantine & Helen Greek Orthodox Church', '', '1001 E. Wyomissing Blvd', NULL, 'Reading', 'PA', '19611', '43.4831958', '-1.550446', 0, 0, 0),
(43, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 19th Ward Precinct 01', 'Glenside School', '', '1451 Schuylkill Ave', NULL, 'Reading', 'PA', '19601', '40.3568369', '-75.9495304', 0, 0, 0),
(44, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Reading 19th Ward Precinct 02', 'Christ Lutheran Church', '', '1301 Luzerne St', NULL, 'Reading', 'PA', '19601', '40.3542407', '-75.9484378', 0, 0, 0),
(45, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Albany  Precinct 01', 'Kempton Fire Co.', '', '2461 Route 143', NULL, 'Kempton', 'PA', '19529', '40.623447', '-75.8634296', 0, 0, 0),
(46, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Alsace  Precinct 01', 'Alsace Manor Fire Co.', '', '1 Antietam Rd', NULL, 'Temple', 'PA', '19560', '40.39945', '-75.85981', 0, 0, 0),
(47, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Amity  Precinct 01', 'Monarch Fire Co.', '', '6 Pennsylvania Ave', NULL, 'Douglassville', 'PA', '19518', '40.2620821', '-75.7700644', 0, 0, 0),
(48, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Amity  Precinct 02', 'Amityville Fire Co.', '', '47 Pine Forge Rd', NULL, 'Douglassvile', 'PA', '19518', '40.2618819', '-75.7255192', 0, 0, 0),
(49, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Amity  Precinct 03', 'St. Paul''s Lutheran Church', '', '548 Old Swede Rd', NULL, 'Douglassville', 'PA', '19518', '40.275251', '-75.723894', 0, 0, 0),
(50, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Amity  Precinct 04', 'Hope United Methodist Church', '', '117 N. Monocacy Creek Rd', NULL, 'Douglassville', 'PA', '19518', '40.2618819', '-75.7255192', 0, 0, 0),
(51, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Amity  Precinct 05', 'Hearthstone at Amity', '', '139 Old Swede Road', NULL, 'Douglassville', 'PA', '19518', '40.2589697', '-75.7242594', 0, 0, 0),
(52, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Amity  Precinct 06', 'Amity Twp. Bldg', '', '2004 Weavertown Rd', NULL, 'Douglassville', 'PA', '19518', '40.298305', '-75.738629', 0, 0, 0),
(53, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Bally  Precinct 01', 'Bally Boro Hall', '', '425 Chestnut St.', NULL, 'Bally', 'PA', '19503', '40.3997849', '-75.5901499', 0, 0, 0),
(54, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Bechtelsville  Precinct 01', 'Bechtelsville Boro Hall', '', '16 Railroad St', NULL, 'Bechtelsville', 'PA', '19505', '40.3718478', '-75.6275102', 0, 0, 0),
(55, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Bern  Precinct 01', 'Bern Twp. Bldg', '', '1069 Old Bernville Rd', NULL, 'Reading', 'PA', '19605', '40.3911113', '-75.9917809', 0, 0, 0),
(56, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Bern  Precinct 02', 'Ontelaunee Grange Hall', '', 'Grange Rd & White Oak Ln', NULL, 'Leesport', 'PA', '19533', '', '', 0, 0, 0),
(57, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Bern  Precinct 03', 'Greenfields Fire Co.', 'Social Hall', '505 Boeing Ave', NULL, 'Reading', 'PA', '19601', '40.3692296', '-75.9590995', 0, 0, 0),
(58, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Bernville  Precinct 01', 'Bernville Boro Hall', '', '6602 Bernville Rd', NULL, 'Bernville', 'PA', '19506', '40.4402976', '-76.1210275', 0, 0, 0),
(59, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Bethel  Precinct 01', 'Bethel Twp. Bldg.', '', '60 Klahr Rd', NULL, 'Bethel', 'PA', '19507', '40.4771978', '-76.2929575', 0, 0, 0),
(60, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Birdsboro  Precinct 01', 'Birdsboro Boro Hall', '', '202 E. Main St', NULL, 'Birdsboro', 'PA', '19508', '40.2660026', '-75.8064472', 0, 0, 0),
(61, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Birdsboro  Precinct 02', 'St. Marks Church', '', '5 Brooke Manor', NULL, 'Birdsboro', 'PA', '19508', '40.2617066', '-75.8092274', 0, 0, 0),
(62, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Boyertown  Precinct 01', 'Keystone Fire Co. #1', '', '240 N. Walnut St.', NULL, 'Boyertown', 'PA', '19512', '39.6086136', '-105.9623469', 0, 0, 0),
(63, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Boyertown  Precinct 02', 'Boyertown Boro Hall', '', '100 S. Washington St.', NULL, 'Boyertown', 'PA', '19512', '40.3303238', '-75.6364941', 0, 0, 0),
(64, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Brecknock  Precinct 01', 'Brecknock Twp. Bldg.', '', '889 Alleghenyville Rd', NULL, 'Mohnton', 'PA', '19540', '40.2210285', '-75.9736639', 0, 0, 0),
(65, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Brecknock  Precinct 02', 'Brecknock Fire Co.', '', '1153 Kurtz Mill Rd', NULL, 'Mohnton', 'PA', '19540', '40.2374907', '-75.9840416', 0, 0, 0),
(66, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Caernarvon  Precinct 01', 'Caernarvon Twp Bldg.', 'Social Hall', '3307 Main Street', NULL, 'Morgantown', 'PA', '19543', '40.1561868', '-75.8871863', 0, 0, 0),
(67, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Caernarvon  Precinct 02', 'Twin Valley High School', 'Physical Ed. Bldg.', '4897 N. Twin Valley Rd', NULL, 'Elverson', 'PA', '19520', '40.1621761', '-75.855677', 0, 0, 0),
(68, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Centerport  Precinct 01', 'Central Berks Lions Hall', '', '2207 Main St', NULL, 'Centerport', 'PA', '19516', '40.2851664', '-75.8736936', 0, 0, 0),
(69, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Centre  Precinct 01', 'Centre Twp. Bldg.', '', '449 Bucks Hill Rd', NULL, 'Mohrsville', 'PA', '19541', '40.4697391', '-76.014494', 0, 0, 0),
(70, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Centre  Precinct 02', 'Schuylkill Valley Bible Church', '', '693 Irish Creek Rd', NULL, 'Mohrsville', 'PA', '19541', '40.482047', '-76.018676', 0, 0, 0),
(71, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Colebrookdale  Precinct 01', 'Liberty Fire Co. #1', '', '21 Henry Ave', NULL, 'New Berlinville', 'PA', '19545', '40.1044577', '-76.0818429', 0, 0, 0),
(72, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Colebrookdale  Precinct 02', 'Colebrookdale Twp. Bldg.', '', '765 W. Phila. Ave', NULL, 'Boyertown', 'PA', '19512', '40.3332883', '-75.6480374', 0, 0, 0),
(73, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Cumru  Precinct 01', 'Christ Yocum Church', '', '840 Philadelphia Ave', NULL, 'Reading', 'PA', '19607', '40.287932', '-75.9347113', 0, 0, 0),
(74, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Cumru  Precinct 02', 'Warren Recreation Center', '', '436 Church Rd', NULL, 'Mohnton', 'PA', '19540', '40.2818643', '-75.9718819', 0, 0, 0),
(75, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Cumru  Precinct 03', 'Gouglersville Fire. Co.', '', '475 Mohns Hill Rd', NULL, 'Reading', 'PA', '19608', '40.319402', '-76.0275859', 0, 0, 0),
(76, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Cumru  Precinct 04', 'The Barn at Flying Hills', '', '13 Village Center Dr', NULL, 'Reading', 'PA', '19607', '40.2801905', '-75.9220032', 0, 0, 0),
(77, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Cumru  Precinct 05', 'Grace Fellowship Church', '', '622 Old Lancaster Pike', NULL, 'Reading', 'PA', '19607', '40.297326', '-75.995794', 0, 0, 0),
(78, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Cumru  Precinct 06', 'Mifflin Court Assisted Living', '', '450 E Philadelphia Ave', NULL, 'Reading', 'PA', '19607', '40.287932', '-75.9347113', 0, 0, 0),
(79, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Cumru  Precinct 07', 'Shillington Church of Christ ', '', '475 Philadelphia Ave', NULL, 'Reading', 'PA', '19607', '40.3000259', '-75.9605188', 0, 0, 0),
(80, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'District  Precinct 01', 'District Twp. Bldg.', '', '202 Weil Rd', NULL, 'Boyertown', 'PA', '19512', '40.4111515', '-75.6599541', 0, 0, 0),
(81, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Douglass  Precinct 01', 'Mt. View Chapel', '', '68 Old Douglass Drive', NULL, 'Douglassville', 'PA', '19518', '40.2572778', '-75.7131509', 0, 0, 0),
(82, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Douglass  Precinct 02', 'Douglass Twp. Bldg.', '', '1068 Douglass Dr', NULL, 'Boyertown', 'PA', '19512', '40.302158', '-75.69009', 0, 0, 0),
(83, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Earl  Precinct 01', 'Camp Manatawny', '', '33 Camp Rd', NULL, 'Douglassville', 'PA', '19518', '40.2618819', '-75.7255192', 0, 0, 0),
(84, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Earl  Precinct 02', 'Earl Twp. Bldg.', '', '19 Schoolhouse Rd', NULL, 'Boyertown', 'PA', '19512', '40.3675995', '-75.7048014', 0, 0, 0),
(85, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Exeter  Precinct 01', 'Schwarzwald Lutheran Church', '', '250 Church Lane Rd', NULL, 'Reading', 'PA', '19606', '40.326447', '-75.848406', 0, 0, 0),
(86, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Exeter  Precinct 02', 'Exeter Bible Church', '', '926 Phila. Terrace', NULL, 'Birdsboro', 'PA', '19508', '40.285739', '-75.817239', 0, 0, 0),
(87, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Exeter  Precinct 03', 'Lorane Elementary School', '', '699 Rittenhouse Dr', NULL, 'Reading', 'PA', '19606', '40.2916839', '-75.852732', 0, 0, 0),
(88, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Exeter  Precinct 04', 'Elm Croft Retirement Home', '', '9 Colin Court', NULL, 'Reading', 'PA', '19606', '40.3393652', '-75.8650148', 0, 0, 0),
(89, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Exeter  Precinct 05', 'Antietam Valley Recreation Center', '', '905 Byram St.', NULL, 'Reading', 'PA', '19606', '40.3393652', '-75.8650148', 0, 0, 0),
(90, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Exeter  Precinct 06', 'Exeter Twp. Bldg.', '', '4975 DeMoss Rd', NULL, 'Reading', 'PA', '19606', '40.306327', '-75.8544639', 0, 0, 0),
(91, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Exeter  Precinct 07', 'Exeter Community Library', '', '4569 Prestwick Dr', NULL, 'Reading', 'PA', '19606', '40.3393652', '-75.8650148', 0, 0, 0),
(92, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Exeter  Precinct 08', 'Stonersville Fire Co.', '', '5580 Boyertown Pike', NULL, 'Birdsboro', 'PA', '19508', '40.316646', '-75.808131', 0, 0, 0),
(93, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Exeter  Precinct 09', 'St. Catharine of Sienna Roman Catholic Church', 'Social Hall', '4975 Boyertown Pike', NULL, 'Reading', 'PA', '19606', '40.3232417', '-75.8326904', 0, 0, 0),
(94, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Exeter  Precinct 10', 'Berkshire Commons', '', '5485 Perkiomen Ave', NULL, 'Reading', 'PA', '19606', '40.3393652', '-75.8650148', 0, 0, 0),
(95, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Exeter  Precinct 11', 'Dunn Farm Community Center', '', '4565 Prestwick Dr', NULL, 'Reading', 'PA', '19606', '40.3393652', '-75.8650148', 0, 0, 0),
(96, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Fleetwood  Precinct 01', 'Fleetwood Borough Hall', '', '110 W. Arch St', NULL, 'Fleetwood', 'PA', '19522', '40.456103', '-75.82062', 0, 0, 0),
(97, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Fleetwood  Precinct 02', 'Fleetwood Volunteer Fire Co.', '', '16 N. Chestnut St', NULL, 'Fleetwood', 'PA', '19522', '40.4529281', '-75.8230815', 0, 0, 0),
(98, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Greenwich  Precinct 01', 'Lenhartsville Friedens United Church ', '', '1512 Old Route 22', NULL, 'Lenhartsville', 'PA', '19534', '40.5728677', '-75.8796587', 0, 0, 0),
(99, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Greenwich  Precinct 02', 'Greenwich Twp. Bldg.', '', '775 Old Route 22', NULL, 'Lenhartsville', 'PA', '19534', '40.57828', '-75.810833', 0, 0, 0),
(100, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Hamburg  Precinct 01', 'Hamburg Boro Hall - 1st Floor', '', '61 N 3rd St', NULL, 'Hamburg', 'PA', '19526', '40.556407', '-75.9840798', 0, 0, 0),
(101, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Hamburg  Precinct 02', 'Hamburg Boro Hall - 2nd Floor', '', '61 N. 3rd St', NULL, 'Hamburg', 'PA', '19526', '40.556407', '-75.9840798', 0, 0, 0),
(102, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Heidelberg  Precinct 01', 'Heidelberg Twp. Bldg.', '', '11 Tulpehocken Forge Rd.', NULL, 'Robesonia', 'PA', '19551', '40.3570746', '-76.1469518', 0, 0, 0),
(103, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Hereford  Precinct 01', 'Huffs Church Chapel', 'Lower Level', '540 Conrad Rd', NULL, 'Alburtis', 'PA', '18011', '40.4463805', '-75.6240849', 0, 0, 0),
(104, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Hereford  Precinct 02', 'Hereford Elementary School', '', '1043 Gravel Pike', NULL, 'Hereford', 'PA', '18056', '40.4408191', '-75.5477615', 0, 0, 0),
(105, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Jefferson  Precinct 01', 'Jefferson Twp. Bldg.', '', '5 Solly Ln', NULL, 'Bernville', 'PA', '19506', '40.4402949', '-76.1211829', 0, 0, 0),
(106, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Kenhorst  Precinct 01', 'Kenhorst Community Center', 'at edge of the Park', 'Muncy Ave', NULL, 'Reading', 'PA', '19607', '40.287932', '-75.9347113', 0, 0, 0),
(107, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Kenhorst  Precinct 02', 'Kenhorst Boro Hall', '', '339 Kenhorst Blvd', NULL, 'Reading', 'PA', '19607', '40.310356', '-75.94561', 0, 0, 0),
(108, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Kutztown  Ward 01', 'Kutztown Boro Hall Train Station', '', '110 Railroad St', NULL, 'Kutztown', 'PA', '19530', '40.5207456', '-75.7752834', 0, 0, 0),
(109, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Kutztown  Ward 02', 'Kutztown Sr. High School', '', '50 Trexler Ave', NULL, 'Kutztown', 'PA', '19530', '40.5135789', '-75.7689451', 0, 0, 0),
(110, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Laureldale  Precinct 01', 'Laureldale Boro Hall', '', '3406 Kutztown Rd', NULL, 'Reading', 'PA', '19605', '40.387739', '-75.920836', 0, 0, 0),
(111, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Laureldale  Precinct 02', 'Laureldale Athletic Assn.', '', '1610 Nolan St', NULL, 'Reading', 'PA', '19605', '40.3833099', '-75.9088107', 0, 0, 0),
(112, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Leesport  Precinct 01', 'Union Fire Co #1 of Leesport', '', '11 S. Canal St', NULL, 'Leesport', 'PA', '19533', '40.5527775', '-75.9811311', 0, 0, 0),
(113, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Lenhartsville  Precinct 01', 'Lenhartsville Boro Hall', '', '19 Willow St.', NULL, 'Lenhartsville', 'PA', '19534', '40.5734139', '-75.8881981', 0, 0, 0),
(114, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Longswamp    Precinct 01', 'Topton Fire Co.', '', '600 State St', NULL, 'Topton', 'PA', '19562', '40.5031411', '-75.6868204', 0, 0, 0),
(115, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Longswamp  Precinct 02', 'Longswamp Twp. Bldg.', '', '1112 State Street', NULL, 'Mertztown', 'PA', '19539', '40.5039997', '-75.6624079', 0, 0, 0),
(116, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Lower Alsace  Precinct 01', 'Lower Alsace Ambulance Co.', '', '750 N. 25th St', NULL, 'Reading', 'PA', '19606', '40.3393652', '-75.8650148', 0, 0, 0),
(117, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Lower Alsace  Precinct 02', 'Lower Alsace Twp. Bldg.', '', '1200 Carsonia Ave', NULL, 'Reading', 'PA', '19606', '40.345954', '-75.872992', 0, 0, 0),
(118, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Lwr. Heidelberg  Precinct 01', 'St. Johns Hains Reformed Church', '', '591 N. Church Rd', NULL, 'Wernersville', 'PA', '19565', '40.3422298', '-76.0723321', 0, 0, 0),
(119, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Lwr. Heidelberg  Precinct 02', 'Lower Heidelberg Twp. Bldg.', '', '720 Brownsville Rd', NULL, 'Reading', 'PA', '19608', '40.359772', '-76.048862', 0, 0, 0),
(120, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Lwr. Heidelberg  Precinct 03', 'Community Evangelical Church', '', '51 Green Valley Rd', NULL, 'Reading', 'PA', '19608', '40.328242', '-76.037873', 0, 0, 0),
(121, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Lyons  Precinct 01', 'Lyons Boro Hall', '', 'Kemp St', NULL, 'Lyon Station', 'PA', '19536', '40.4769425', '-75.7569876', 0, 0, 0),
(122, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Maidencreek  Precinct 01', 'Blandon Fire Co.', '', '28 West Wesner Rd', NULL, 'Blandon', 'PA', '19510', '40.4382', '-75.883877', 0, 0, 0),
(123, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Maidencreek  Precinct 02', 'Maidencreek Twp. Bldg.', '', '1 Quarry Road', NULL, 'Blandon', 'PA', '19510', '40.44878', '-75.901957', 0, 0, 0),
(124, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Maidencreek  Precinct 03', 'Keystone Assisted Living', '', '501 Hoch Road', NULL, 'Blandon', 'PA', '19510', '40.4431148', '-75.8636215', 0, 0, 0),
(125, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Maidencreek  Precinct 04', 'Maidencreek Church', '', '261 Main St', NULL, 'Blandon', 'PA', '19510', '40.4418357', '-75.8873641', 0, 0, 0),
(126, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Marion  Precinct 01', 'Marion Twp. Bldg.', '', '420 Water St', NULL, 'Stouchsburg', 'PA', '19567', '40.3793657', '-76.2326333', 0, 0, 0),
(127, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Maxatawny  Precinct 01', 'Zion''s Union Church', '', '329 Church Rd', NULL, 'Kutztown', 'PA', '19530', '41.0475264', '-76.1591722', 0, 0, 0),
(128, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Maxatawny  Precinct 02', 'Hope Lutheran Church', '', '550 Fleetwood Road', NULL, 'Bowers', 'PA', '19511', '40.4818306', '-75.7482352', 0, 0, 0),
(129, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Maxatawny  Precinct 03', 'Maxatawny Twp. Bldg.', '', '127 Quarry Rd', NULL, 'Kutztown', 'PA', '19530', '40.531635', '-75.735315', 0, 0, 0),
(130, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Mohnton  Precinct 01', 'St. Johns Lutheran Church', 'Parish House', '1 Front Street', NULL, 'Mohnton', 'PA', '19540', '40.2839435', '-75.9823398', 0, 0, 0),
(131, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Mt Penn  Precinct 01', 'Mt. Penn Boro Hall', '', '200 N. 25th St', NULL, 'Reading', 'PA', '19606', '40.330412', '-75.887764', 0, 0, 0),
(132, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Muhlenberg  Precinct 01', 'Goodwill Fire Co.', '(not the Social Hall)', '115 Madison Ave', NULL, 'Reading', 'PA', '19605', '40.3752352', '-75.9221472', 0, 0, 0),
(133, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Muhlenberg  Precinct 02', 'Muhlenberg Community Library', '', '3612 Kutztown Rd', NULL, 'Reading', 'PA', '19605', '40.3921097', '-75.9211671', 0, 0, 0),
(134, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Muhlenberg  Precinct 03', 'Church of Jesus Christ of Latter Day Saints', '', '3344 Reading Crest Ave', NULL, 'Reading', 'PA', '19605', '40.390872', '-75.938798', 0, 0, 0),
(135, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Muhlenberg  Precinct 04', 'Sacred Heart Villa', '', '51 Seminary Avenue', NULL, 'Reading', 'PA', '19605', '40.403733', '-75.9405178', 0, 0, 0),
(136, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Muhlenberg  Precinct 05', 'Christ Church United, United Church of Christ', '', '4870 Kutztown Rd', NULL, 'Temple', 'PA', '19560', '40.4086218', '-75.9202646', 0, 0, 0),
(137, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Muhlenberg  Precinct 06', 'Riverview Christian Fellowship ', 'School Bldg', '3301 Stoudts Ferry Bridge Rd', NULL, 'Reading', 'PA', '19605', '40.38623', '-75.94714', 0, 0, 0),
(138, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Muhlenberg  Precinct 07', 'Laurel Commons Community Center', '', '1001 Sage Ave.', NULL, 'Reading', 'PA', '19605', '40.403733', '-75.9405178', 0, 0, 0),
(139, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Muhlenberg  Precinct 08', 'Goodwill Fire Co.', '', '800 Tuckerton Rd', NULL, 'Reading', 'PA', '19605', '40.3972913', '-75.9581351', 0, 0, 0),
(140, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Muhlenberg  Precinct 09', 'Good Shepherd Lutheran Church', '', '4201 Stoudts Ferry Bridge Rd', NULL, 'Reading', 'PA', '19605', '40.397712', '-75.956071', 0, 0, 0),
(141, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'New Morgan  Precinct 01', 'Municipal Bldg.', 'Bldg D Room 3', '75 Grace Blvd', NULL, 'Morgantown', 'PA', '19543', '40.1715133', '-75.8732782', 0, 0, 0),
(142, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'N. Heidelberg  Precinct 01', 'North Heidelberg Twp Bldg', '', '928 Charming Forge Rd', NULL, 'Robesonia', 'PA', '19551', '40.3965003', '-76.1332589', 0, 0, 0),
(143, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Oley  Precinct 01', 'Oley Twp. Bldg.', '', '1 Rose Virginia Road', NULL, 'Oley', 'PA', '19547', '40.382186', '-75.7770692', 0, 0, 0),
(144, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Oley  Precinct 02', 'Christ Lutheran Church', '', '325 Covered Bridge Rd', NULL, 'Oley', 'PA', '19547', '40.3620631', '-75.7458223', 0, 0, 0),
(145, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Ontelaunee  Precinct 01', 'Ontelaunee Twp. Bldg.', '', '35 Ontelaunee Dr', NULL, 'Reading', 'PA', '19605', '40.442714', '-75.938467', 0, 0, 0),
(146, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Penn  Precinct 01', 'Penn Twp. Bldg.', '', '840 N. Garfield Rd', NULL, 'Bernville', 'PA', '19506', '40.4296748', '-76.0939669', 0, 0, 0),
(147, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Perry  Precinct 01', 'Perry Twp. Bldg.', '', '680 Moselem Spring Rd.', NULL, 'Shoemakersville', 'PA', '19555', '40.5092231', '-75.9409656', 0, 0, 0),
(148, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Pike  Precinct 01', 'St. Paul''s Lutheran Church', '', '342 Lobachsville Rd', NULL, 'Oley', 'PA', '19547', '40.4029507', '-75.7302067', 0, 0, 0),
(149, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Richmond  Precinct 01', 'Richmond Twp. Bldg.', '', '11 Kehl Rd', NULL, 'Fleetwood', 'PA', '19522', '40.488698', '-75.840417', 0, 0, 0),
(150, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Robeson  Precinct 01', 'Geigertown Fire Hall', 'Rt 82 Geigertown', 'Hay Creek Rd', NULL, 'Birdsboro', 'PA', '19508', '40.256372', '-75.841775', 0, 0, 0),
(151, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Robeson  Precinct 02', 'Robeson Twp. Bldg.', '', '2689 Main St', NULL, 'Birdsboro', 'PA', '19508', '40.282402', '-75.858696', 0, 0, 0),
(152, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Robeson  Precinct 03', 'St. Benedict''s Church', '', '2020 Chestnut Hill Rd', NULL, 'Mohnton', 'PA', '19540', '40.2076687', '-75.9108175', 0, 0, 0),
(153, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Robeson  Precinct 04', 'Robeson Elementary School', '', '801 White Bear Rd', NULL, 'Birdsboro', 'PA', '19508', '40.246583', '-75.86952', 0, 0, 0),
(154, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Robesonia  Precinct 01', 'Robesonia Boro Hall', '', '75 S. Brooke St', NULL, 'Robesonia', 'PA', '19551', '40.3517709', '-76.1372489', 0, 0, 0),
(155, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Rockland  Precinct 01', 'Rockland Twp. Bldg.', '', '41 Deysher Road', NULL, 'Fleetwood', 'PA', '19522', '40.444672', '-75.74301', 0, 0, 0),
(156, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Rockland  Precinct 02', 'New Jerusalem UCC', '', '33 Lyons Rd', NULL, 'Fleetwood', 'PA', '19522', '40.4649645', '-75.8301537', 0, 0, 0),
(157, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Ruscombmanor  Precinct 01', 'Ruscombmanor Twp. Bldg.', '', '204 Oak Lane', NULL, 'Fleetwood', 'PA', '19522', '40.4250996', '-75.818042', 0, 0, 0),
(158, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Ruscombmanor  Precinct 02', 'Evergreen Country Club', '', '415 Hartz Rd', NULL, 'Fleetwood', 'PA', '19522', '40.4649645', '-75.8301537', 0, 0, 0),
(159, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Shillington  Precinct 01', 'Shillington Fire Co.', '', '221 Catherine St', NULL, 'Reading', 'PA', '19607', '40.304257', '-75.972949', 0, 0, 0),
(160, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Shillington  Precinct 02', 'Immanuel United Church of Christ', '', '99 S Waverly St', NULL, 'Reading', 'PA', '19607', '40.3021447', '-75.9610738', 0, 0, 0),
(161, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Shoemakersville  Precinct 01', '**Perry Elementary Center', '', '201 Fourth Street', NULL, 'Shoemakersville', 'PA', '19555', '40.4990857', '-75.9669013', 0, 0, 0),
(162, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Sinking Spring  Precinct 01', 'Liberty Fire Co. #1', '', '836 Ruth St', NULL, 'Reading', 'PA', '19608', '40.1044577', '-76.0818429', 0, 0, 0),
(163, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Sinking Spring  Precinct 02', 'Sinking Spring Boro Hall', '', '3940 Penn Ave', NULL, 'Reading', 'PA', '19608', '40.3250009', '-76.0220587', 0, 0, 0),
(164, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'S. Heidelberg  Precinct 01', 'Hillside Christian Church', '', '3322 E. Galen Hall Rd.', NULL, 'Reinholds', 'PA', '17569', '40.296695', '-76.069883', 0, 0, 0),
(165, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'S. Heidelberg  Precinct 02', 'South Heidelberg Twp. Bldg. ', 'Formerly Forino''s', '555 Mountain Home Rd', NULL, 'Reading', 'PA', '19608', '40.3137741', '-76.0522181', 0, 0, 0),
(166, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'S. Heidelberg  Precinct 03', 'Wernersville State Hosp ', 'Fire House-Bldg. 16', '160 Main St', NULL, 'Wernersville', 'PA', '19565', '40.3288091', '-76.105036', 0, 0, 0),
(167, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 01', 'Spring Twp. Fire Co.', '', '2301 Monroe Ave', NULL, 'Reading', 'PA', '19609', '40.3217257', '-75.9939959', 0, 0, 0),
(168, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 02', 'West Wyomissing Fire Co.', '', '2160 Cleveland Ave', NULL, 'Reading', 'PA', '19609', '40.325001', '-75.989845', 0, 0, 0),
(169, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 03', 'St. Peters UCC', '', '2901 Curtis Rd.', NULL, 'Reading', 'PA', '19609', '40.3279955', '-75.9956673', 0, 0, 0),
(170, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 04', 'Wilson School District Operations Center', '', '4 Cloister Court', NULL, 'Reading', 'PA', '19608', '40.319402', '-76.0275859', 0, 0, 0),
(171, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 05', 'Glad Tidings Assembly of God', '', '1110 Snyder Road', NULL, 'Reading', 'PA', '19609', '40.339724', '-76.005027', 0, 0, 0),
(172, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 06', 'Spring Twp. Bldg.', '', '2850 Windmill Road', NULL, 'Reading', 'PA', '19608', '40.318617', '-76.007253', 0, 0, 0),
(173, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 07', 'Janssen Conference Center', 'Room 2', 'Broadcasting & Tulpehocken Rds.', NULL, 'Reading', 'PA', '19610', '', '', 0, 0, 0),
(174, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 08', '**Body Zone Sports and Wellness Complex', '', '3103 Papermill Road', NULL, 'Reading', 'PA', '19610', '40.3380072', '-75.9753516', 0, 0, 0),
(175, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 09', 'West Lawn United Methodist Church', 'Community Center', '103 Woodside Ave', NULL, 'Reading', 'PA', '19609', '40.3279955', '-75.9956673', 0, 0, 0),
(176, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 10', 'Wilson Southern Jr. High School', '', '3100 Iroquois Ave', NULL, 'Reading', 'PA', '19608', '40.319402', '-76.0275859', 0, 0, 0),
(177, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 11', 'Shiloh Hills Elementary School', '', '301 Sage Dr', NULL, 'Reading', 'PA', '19608', '40.2862676', '-76.0260777', 0, 0, 0),
(178, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Spring  Precinct 12', 'Olive Leaf Union Chapel', '', '840 Fritztown Rd', NULL, 'Reading', 'PA', '19608', '40.319402', '-76.0275859', 0, 0, 0),
(179, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'St. Lawrence  Precinct 01', 'St. Lawrence Borough Hall', '', '3540 St. Lawrence Ave', NULL, 'Reading', 'PA', '19606', '40.325396', '-75.864772', 0, 0, 0),
(180, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Strausstown  Precinct 01', 'Strausstown Fire Co.', '', '44 East Avenue', NULL, 'Strausstown', 'PA', '19506', '40.4940085', '-76.1798526', 0, 0, 0),
(181, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Tilden  Precinct 01', 'Tilden Twp. Bldg.', '', '874 Hex Highway', NULL, 'Hamburg', 'PA', '19526', '40.5379456', '-76.0201444', 0, 0, 0),
(182, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Topton  Precinct 01', 'Topton Boro Hall', '', '205 S. Callowhill St.', NULL, 'Topton', 'PA', '19562', '40.5002355', '-75.7039345', 0, 0, 0),
(183, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Tulpehocken  Precinct 01', 'Tulpehocken Twp. Bldg.', '', '22 Rehrersburg Rd.', NULL, 'Rehrersburg', 'PA', '19550', '40.4602415', '-76.261474', 0, 0, 0),
(184, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Tulpehocken  Precinct 02', 'Lions Club', '', 'Tanner St', NULL, 'Mt Aetna', 'PA', '19544', '21.9054818', '95.9651437', 0, 0, 0),
(185, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Union  Precinct 01', 'Daniel Boone High School', 'East End', '501 Chestnut St', NULL, 'Birdsboro', 'PA', '19508', '40.2564452', '-75.7961018', 0, 0, 0),
(186, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Union  Precinct 02', 'St. Paul''s United Methodist Church', '', '1136 Geigertown Rd.', NULL, 'Birdsboro', 'PA', '19508', '40.2166406', '-75.8315182', 0, 0, 0),
(187, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Upper Bern  Precinct 01', 'Community Fire Co.', '', '5637 Old Route 22', NULL, 'Shartlesville', 'PA', '19554', '40.5133412', '-76.1064216', 0, 0, 0),
(188, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Upper Tulp.  Precinct 01', 'Upper Tulp. Twp. Bldg.', '', '6501 Old Route 22', NULL, 'Bernville', 'PA', '19506', '40.4997448', '-76.1713004', 0, 0, 0),
(189, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Washington  Precinct 01', 'Washington Twp. Bldg.', '', '120 Barto Road', NULL, 'Barto', 'PA', '19504', '40.3893014', '-75.6101154', 0, 0, 0),
(190, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Wernersville  Precinct 01', 'Western Berks Fire Dept.', '', '111 Stitzer Ave.', NULL, 'Wernersville', 'PA', '19565', '40.3310477', '-76.0789116', 0, 0, 0),
(191, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'West Reading  Precinct 01', 'West Reading Fire Co. #1', '', '223 Playground Drive', NULL, 'Reading', 'PA', '19611', '40.3332278', '-75.9481781', 0, 0, 0),
(192, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'West Reading  Precinct 03', 'West Reading Boro Hall', '', '500 Chestnut St', NULL, 'Reading', 'PA', '19611', '40.3332278', '-75.9481781', 0, 0, 0),
(193, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Windsor  Precinct 01', 'Windsor Twp. Supervisor''s Hall', '', '110 Haas Rd', NULL, 'Hamburg', 'PA', '19526', '40.5389593', '-75.9330442', 0, 0, 0),
(194, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Womelsdorf  Precinct 01', 'Womelsdorf Boro Hall', '', '101 W. High St', NULL, 'Womelsdorf', 'PA', '19567', '40.3634198', '-76.1847362', 0, 0, 0),
(195, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Wyomissing  Precinct 01', 'Wyomissing Library', 'Franklin St. Entrance', '9 Reading Blvd', NULL, 'Reading', 'PA', '19610', '40.3346411', '-75.9581728', 0, 0, 0),
(196, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Wyomissing  Precinct 02', 'Berkshire Heights Fire Co.', 'Apparatus Rm', '808 N. Park Rd', NULL, 'Reading', 'PA', '19610', '40.3380072', '-75.9753516', 0, 0, 0),
(197, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Wyomissing  Precinct 03', 'The Highlands', 'Berkshire Room', '2000 Cambridge Ave', NULL, 'Reading', 'PA', '19610', '40.2672095', '-75.2091531', 0, 0, 0),
(198, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Wyomissing  Precinct 04', 'Wyomissing High Field House', 'Athletic Field House', '679 Evans Ave', NULL, 'Reading', 'PA', '19610', '40.3380072', '-75.9753516', 0, 0, 0),
(199, NULL, '2015-10-13 18:42:38', NULL, NULL, NULL, NULL, NULL, 'Wyomissing  Precinct 05', 'Reform Congregation Oheb Sholom', 'Yashek Social Hall', '555 Warwick Drive', NULL, 'Reading', 'PA', '19610', '40.338124', '-75.981903', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_tickets`
--

CREATE TABLE IF NOT EXISTS `service_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `polling_site_id` int(11) NOT NULL,
  `technician_id` int(11) NOT NULL,
  `dispatcher_solve` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0= not solved by dispatch, 1=solve by dispatch',
  `address` text NOT NULL,
  `reason_call` text NOT NULL,
  `caller` varchar(255) NOT NULL,
  `contact_num` varchar(90) NOT NULL,
  `supply_needed` varchar(255) NOT NULL,
  `priority_ticket` varchar(50) NOT NULL,
  `response_acceptance` varchar(50) NOT NULL COMMENT '0=rejected, 1= accepted',
  `machine_num` varchar(90) NOT NULL,
  `notes` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0= open, 1 = Closed',
  `enroute_datetime` varchar(255) NOT NULL,
  `on_scene_datetime` varchar(255) NOT NULL,
  `cancel_reason` text NOT NULL,
  `redirect_reason` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `service_tickets`
--

INSERT INTO `service_tickets` (`id`, `polling_site_id`, `technician_id`, `dispatcher_solve`, `address`, `reason_call`, `caller`, `contact_num`, `supply_needed`, `priority_ticket`, `response_acceptance`, `machine_num`, `notes`, `status`, `enroute_datetime`, `on_scene_datetime`, `cancel_reason`, `redirect_reason`, `created_at`) VALUES
(1, 2, 1, 0, '', 'Techincal problem in machine', 'Testperson', '324569870', 'def,pqr', '2', '1', '54555', 'this iis notes', 1, '', '', '', '', '2016-02-06 13:34:44'),
(2, 2, 2, 0, '', 'Techincal problem in machine', 'Testperson', '98798989898', 'abc,xyz', '3', '1', '54555', 'noted', 2, '', '', 'new ticket test', 'kjhkj', '2016-02-06 13:42:33'),
(3, 2, 1, 0, '', 'Techincal problem in machine,Beep sound is low', 'Testperson', '98798989898', 'def,pqr', '4', '1', '5484', 'tsting', 1, '', '', '', '', '2016-02-06 13:43:35'),
(4, 2, 0, 1, '', 'Techincal problem in machine', '', '', 'def', '2', '', '', '', 0, '', '', '', '', '2016-02-20 18:23:21'),
(5, 2, 0, 1, '', 'Beep sound is low', 'ricky', '78787', 'abc,def,xyz', '4', '', '', 'Solved by dispatcher', 1, '', '', '', '', '2016-02-21 07:34:16');

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
  `admin_id` int(11) NOT NULL,
  `username` varchar(90) NOT NULL,
  `password` varchar(90) NOT NULL,
  `phone` varchar(55) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(90) NOT NULL,
  `state` varchar(90) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `officephone` varchar(50) NOT NULL,
  `new_password_to_set` varchar(30) NOT NULL,
  `push_regid` varchar(512) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `technician`
--

INSERT INTO `technician` (`id`, `first_name`, `last_name`, `email`, `admin_id`, `username`, `password`, `phone`, `latitude`, `longitude`, `created_at`, `updated_at`, `address`, `city`, `state`, `zip`, `officephone`, `new_password_to_set`, `push_regid`, `status`) VALUES
(1, 'shane', 'warne', 'shane_w@gmail.com', 0, 'shane', '', '9876543210', '40.365', '-75.699', '2015-08-26 18:30:00', NULL, '', '', '', '', '', '', '', NULL),
(2, 'Bob2', 'woolmer', 'technician2@tbltechnerds.com', 0, 'boby', '', '6458256363', '40.436569', '-75.54568', '2015-08-26 04:47:16', NULL, '', '', '', '', '', '', '', 2),
(4, 'Technician', 'wough', 'technician@tbltechnerds.com', 0, 'testing', 'mind@123', '1234567890', '40.525', '-75.610', '2015-08-30 10:03:54', NULL, '', '', '', '', '', '', '', NULL),
(5, 'te', 'tech', 'testing@gmail.com', 0, 'testing', 'test', '126545987', '40.10101', '-75.2365', '2015-08-30 17:01:42', NULL, '', '', '', '', '', '', '', 2),
(6, 'Tester', 'TesterLast', 'email@test.com', 0, 'usernam_test', 'Pass', '', '40.00256', '-75.989898', '2015-09-10 17:01:01', NULL, '', '', '', '', '', '', '', NULL);

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
-- Table structure for table `ticket_add_notes`
--

CREATE TABLE IF NOT EXISTS `ticket_add_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `author_type` varchar(255) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ticket_add_notes`
--

INSERT INTO `ticket_add_notes` (`id`, `ticket_id`, `description`, `author_type`, `author_name`, `created_at`) VALUES
(1, 5, 'ne notes', 'Admin', 'vishaljaura183@gmail.com', '2016-02-26 19:41:22'),
(2, 2, 'testin here', 'Admin', 'vishaljaura183@gmail.com', '2016-02-26 19:44:31');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_data`
--

CREATE TABLE IF NOT EXISTS `ticket_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tech_username` varchar(100) NOT NULL,
  `cellphone` varchar(90) NOT NULL,
  `homephone` varchar(90) NOT NULL,
  `inspector_dropoff_loc` varchar(255) NOT NULL,
  `num_votes_cast` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `service_ticket_id` int(11) NOT NULL,
  `clerk_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image_name` varchar(255) NOT NULL,
  `signature_image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
