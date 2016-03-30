-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 31 Mars 2016 à 01:24
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertEvent`(IN `p_name` VARCHAR(255), IN `p_run_date` DATE, IN `p_run_time` BIGINT, IN `p_lngStart` FLOAT, IN `p_latStart` FLOAT, IN `p_lngEnd` FLOAT(11), IN `p_latEnd` FLOAT(11), IN `p_leader` INT(11))
    NO SQL
INSERT INTO `event`
VALUES ('', p_name, p_run_date, p_run_time, 0, p_lngStart, p_latStart, p_lngEnd, p_latEnd, p_leader)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `register`(IN `p_username` VARCHAR(255), IN `p_pass` VARCHAR(255), IN `p_mail` VARCHAR(255))
    NO SQL
INSERT INTO `user`
VALUES ('',p_username, p_pass, p_mail, '','','','','')$$

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lead_user` (`lead_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=181 ;

--
-- Contenu de la table `event`
--

INSERT INTO `event` (`id`, `name`, `nbr_runners`, `event_time`, `statut`, `lonStart`, `latStart`, `lonEnd`, `latEnd`, `lead_user`) VALUES
(180, 'run to poutre', 1, 1456963320, 0, '2.280339', '48.897236', '2.4026819000001', '48.8583703', 10);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `mail`, `birthdate`, `session`, `time`, `profil_pic`, `addr`) VALUES
(0, 'greg', '8VLLPCA0F0', 'nosfe.ratus@laposte.net', '0000-00-00 00:00:00', '8XPBHJG9NJYBT72EK840', 1459329704, '/image/avatar/greg-greg-[000645].png', ''),
(1, 'momo', 'momopass', 'mail@momo.fr', '0000-00-00 00:00:00', '6CKYNPCX0HRYRHJH8SNB', 1459206910, '/image/avatar/momo-arborescence_app.png', ''),
(9, 'mike', 'mikepass', 'mail@mike.fr', '0000-00-00 00:00:00', '2UUNZI6OB22UGCGGPDV7', 1459194613, '', ''),
(10, 'gregoire', 'gregpass', 'mail@greg.fr', '1992-05-24 22:00:00', '4O3A3ZJ7C5UFGXDGHJY7', 1459454945, '/image/avatar/greg-49ea7c13413264aa08b2b7ee3a5696fadf7bbf6dc7cd81f8e49c7cd42651533146958962db8f4e9.jpg', '22 rue des rameaux paris'),
(12, 'clem', 'clempass', 'mail@clem.fr', '0000-00-00 00:00:00', 'LXVU89OZH5S5QJD9Y8X7', 1459185791, '', '');

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
(10, 180);

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
