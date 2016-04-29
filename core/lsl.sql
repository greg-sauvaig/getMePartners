-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 03 Avril 2016 à 11:09
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `lsl`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addUserEvent`(IN `p_user` INT(11), IN `p_event_id` INT(11))
    NO SQL
INSERT INTO `user_event` VALUES (p_user, p_event_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `checkLogs`(IN `p_mail` VARCHAR(255), IN `p_pass` VARCHAR(255))
    NO SQL
SELECT * FROM user 
WHERE user.mail = p_mail AND user.password = p_pass$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getEventByName`(IN `p_name` VARCHAR(255))
    NO SQL
SELECT * FROM  `event` 
WHERE  `event`.`name` = p_name$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getEventNamesByIdUser`(IN `p_id` INT(11))
    NO SQL
SELECT `name` 
FROM `event` 
INNER JOIN  `user_event` ON  `user_event`.`event_id` =  `event`.`id` 
WHERE  `user_event`.`user_id` =p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserBySession`(IN `p_session` VARCHAR(255))
    NO SQL
SELECT * FROM user 
WHERE user.session = p_session$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertEvent`(IN `p_name` VARCHAR(255), IN `p_run_date` DATE, IN `p_run_time` BIGINT, IN `p_lngStart` FLOAT, IN `p_latStart` FLOAT, IN `p_lngEnd` FLOAT(11), IN `p_latEnd` FLOAT(11), IN `p_leader` INT(11), IN `p_addr_start` VARCHAR(255), IN `p_addr_end` VARCHAR(255))
    NO SQL
INSERT INTO `event`
VALUES ('', p_name, p_run_date, p_run_time, 0, p_lngStart, p_latStart, p_lngEnd, p_latEnd, p_leader, p_addr_start, p_addr_end)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `register`(IN `p_username` VARCHAR(255), IN `p_pass` VARCHAR(255), IN `p_mail` VARCHAR(255))
    NO SQL
INSERT INTO `user`(`username`,`password`,`mail`)
VALUES (p_username, p_pass, p_mail)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sessionIsValid`(IN `p_time` BIGINT, IN `p_cookie` VARCHAR(255))
    NO SQL
SELECT `id` from `user` where `session` = `p_cookie` and `time` > `p_time`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateSession`(IN `p_code` VARCHAR(255), IN `p_time` BIGINT(55), IN `p_mail` VARCHAR(255))
    NO SQL
UPDATE `user` SET `session`= p_code,`time`= p_time
WHERE `user`.`mail` = p_mail$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nbr_runners` int(11) DEFAULT '1',
  `event_time` bigint(20) NOT NULL,
  `statut` int(11) NOT NULL,
  `lonStart` varchar(255) NOT NULL,
  `latStart` varchar(255) NOT NULL,
  `lonEnd` varchar(255) DEFAULT NULL,
  `latEnd` varchar(255) DEFAULT NULL,
  `lead_user` int(11) NOT NULL,
  `addr_start` varchar(255) DEFAULT NULL,
  `addr_end` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lead_user` (`lead_user`),
  KEY `name_2` (`name`),
  KEY `event_time` (`event_time`),
  KEY `statut` (`statut`),
  KEY `lead_user_2` (`lead_user`),
  KEY `lonStart` (`lonStart`),
  KEY `latStart` (`latStart`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=190 ;

--
-- Contenu de la table `event`
--

INSERT INTO `event` (`id`, `name`, `nbr_runners`, `event_time`, `statut`, `lonStart`, `latStart`, `lonEnd`, `latEnd`, `lead_user`, `addr_start`, `addr_end`) VALUES
(180, 'run to poutre', 10, 1456963320, 0, '2.280339', '48.897236', '2.4026819000001', '48.8583703', 10, 'Paris, France', NULL),
(181, 'm to p', 10, 1456970520, 0, '5.36978', '43.296482', '0', '0', 10, NULL, NULL),
(182, 'lol', 1, 1491091260, 0, '-80.782127', '8.537981', '-75.015152', '-9.189967', 10, NULL, NULL),
(183, 'test', 1, 1425434580, 10, '7.4246158', '43.7384176', '2.319287', '48.891986', 10, NULL, NULL),
(184, 'm&m', 1, 1459728180, 0, '2.2713699999999', '48.730756', '2.23847', '48.812995', 10, NULL, NULL),
(185, 'm to n', 1, 1456876980, 11, '2.619156', '48.98543', '2.55261', '48.848579', 10, NULL, NULL),
(186, 'coursera', 1, 1462489260, 0, '2.40963', '48.894533', '2.3409635', '48.8607149', 10, NULL, NULL),
(187, 'paris mars', 1, 1459724520, 1, '2.3522219', '48.856614', '3.013609', '47.067507', 10, 'Paris, France', NULL),
(188, 'coursera ou pas', 1, 1428030180, 11, '2.4066412', '48.8599825', '2.319287', '48.891986', 15, 'Paris, France', NULL),
(189, 'paris la glace', 1, 1428019320, 10, '2.3522219', '48.856614', '37.6173', '55.755826', 10, 'Paris, France', 'Moscou, Russie');

-- --------------------------------------------------------

--
-- Structure de la table `event_msg`
--

CREATE TABLE IF NOT EXISTS `event_msg` (
  `msg_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  KEY `msg_id` (`msg_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `msg`
--

CREATE TABLE IF NOT EXISTS `msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `msg_insertts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `mail`, `birthdate`, `session`, `time`, `profil_pic`, `addr`) VALUES
(0, 'greg', '8VLLPCA0F0', 'nosfe.ratus@laposte.net', '0000-00-00 00:00:00', '8XPBHJG9NJYBT72EK840', 1459329704, '/image/avatar/greg-greg-[000645].png', ''),
(1, 'momo', 'momopass', 'mail@momo.fr', '0000-00-00 00:00:00', '6CKYNPCX0HRYRHJH8SNB', 1459206910, '/image/avatar/momo-arborescence_app.png', ''),
(9, 'mike', 'mikepass', 'mail@mike.fr', '0000-00-00 00:00:00', '2UUNZI6OB22UGCGGPDV7', 1459194613, '', ''),
(10, 'gregoire', 'gregpass', 'mail@greg.fr', '1992-05-24 22:00:00', 'HWX83EN6QHQ1X8EQMBCK', 1459754905, '/image/avatar/gregoire-200.gif', '22 Rue Soleillet, Paris, France'),
(12, 'clem', 'clempass', 'mail@clem.fr', '0000-00-00 00:00:00', 'LXVU89OZH5S5QJD9Y8X7', 1459185791, '', ''),
(15, 'papa', '123456789', 'patrick.billard@sippar.fr', NULL, 'CSO3HAQR3TYI0CZ2KCWM', 1459521032, '/image/avatar/papa-momo-ninja2.jpg', NULL),
(16, 'Ononosfe', '123456789', 'greg.sauvaigo@gmail.com', NULL, 'LYZ120SP4LQHQ9JPE4E8', 1459618539, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_event`
--

CREATE TABLE IF NOT EXISTS `user_event` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`,`event_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user_event`
--

INSERT INTO `user_event` (`user_id`, `event_id`) VALUES
(10, 180),
(10, 181),
(10, 182),
(10, 183),
(10, 184),
(10, 185),
(10, 186),
(10, 187),
(10, 189),
(15, 188);

-- --------------------------------------------------------

--
-- Structure de la table `user_msg`
--

CREATE TABLE IF NOT EXISTS `user_msg` (
  `user_id` int(11) NOT NULL,
  `msg_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `msg_id` (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `event_msg`
--
ALTER TABLE `event_msg`
  ADD CONSTRAINT `event_msg_ibfk_1` FOREIGN KEY (`msg_id`) REFERENCES `msg` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_msg_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_event`
--
ALTER TABLE `user_event`
  ADD CONSTRAINT `user_event_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_event_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_msg`
--
ALTER TABLE `user_msg`
  ADD CONSTRAINT `user_msg_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_msg_ibfk_2` FOREIGN KEY (`msg_id`) REFERENCES `msg` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
