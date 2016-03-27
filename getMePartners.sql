-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2016 at 04:20 PM
-- Server version: 5.6.28-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `momo`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addUserEvent`(IN `p_user` INT(11), IN `p_event_id` INT(11))
    NO SQL
INSERT INTO `user_event` VALUES (p_user, p_event_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `checkLogs`(IN `p_mail` VARCHAR(255), IN `p_pass` VARCHAR(255))
    NO SQL
SELECT * FROM user 
WHERE user.mail = p_mail AND user.password = p_pass$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserBySession`(IN `p_session` VARCHAR(255))
    NO SQL
SELECT * FROM user 
WHERE user.session = p_session$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertEvent`(IN `p_name` VARCHAR(255), IN `p_run_date` DATE, IN `p_run_time` BIGINT, IN `p_lngStart` FLOAT, IN `p_latStart` FLOAT, IN `p_leader` INT(11), OUT `p_id_event` INT(11))
    NO SQL
INSERT INTO `event`
VALUES ('', p_name, p_run_date, p_run_time, 0, p_lngStart, p_latStart, p_leader)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `register`(IN `p_username` VARCHAR(255), IN `p_pass` VARCHAR(255), IN `p_mail` VARCHAR(255))
    NO SQL
INSERT INTO `user`
VALUES ('',p_username, p_pass, p_mail, '','','','')$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateSession`(IN `p_code` VARCHAR(255), IN `p_time` BIGINT(55), IN `p_mail` VARCHAR(255))
    NO SQL
UPDATE `user` SET `session`= p_code,`time`= p_time
WHERE `user`.`mail` = p_mail$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `event_date` date DEFAULT NULL,
  `event_insertts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `statut` int(11) NOT NULL,
  `lon` varchar(255) NOT NULL,
  `latt` varchar(255) NOT NULL,
  `lead_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lead_user` (`lead_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_msg`
--

CREATE TABLE IF NOT EXISTS `event_msg` (
  `msg_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  KEY `msg_id` (`msg_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `msg`
--

CREATE TABLE IF NOT EXISTS `msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `msg_insertts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `birthdate` timestamp NULL DEFAULT NULL,
  `session` varchar(20) DEFAULT NULL,
  `time` bigint(55) DEFAULT NULL,
  `profil_pic` varchar(255) DEFAULT NULL,
  `addr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_event`
--

CREATE TABLE IF NOT EXISTS `user_event` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`,`event_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_msg`
--

CREATE TABLE IF NOT EXISTS `user_msg` (
  `user_id` int(11) NOT NULL,
  `msg_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `msg_id` (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_msg`
--
ALTER TABLE `event_msg`
  ADD CONSTRAINT `event_msg_ibfk_1` FOREIGN KEY (`msg_id`) REFERENCES `msg` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_msg_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_event`
--
ALTER TABLE `user_event`
  ADD CONSTRAINT `user_event_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_event_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_msg`
--
ALTER TABLE `user_msg`
  ADD CONSTRAINT `user_msg_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_msg_ibfk_2` FOREIGN KEY (`msg_id`) REFERENCES `msg` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
