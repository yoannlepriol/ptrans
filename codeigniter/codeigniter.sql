-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 17 avr. 2018 à 18:04
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `codeigniter`
--

-- --------------------------------------------------------

--
-- Structure de la table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `q_questionnaire1`
--

DROP TABLE IF EXISTS `q_questionnaire1`;
CREATE TABLE IF NOT EXISTS `q_questionnaire1` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `intitule` varchar(120) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `choix1` varchar(60) DEFAULT NULL,
  `choix2` varchar(60) DEFAULT NULL,
  `choix3` varchar(60) DEFAULT NULL,
  `choix4` varchar(60) DEFAULT NULL,
  `choix5` varchar(60) DEFAULT NULL,
  `choix6` varchar(60) DEFAULT NULL,
  `choix7` varchar(60) DEFAULT NULL,
  `choix8` varchar(60) DEFAULT NULL,
  `choix9` varchar(60) DEFAULT NULL,
  `choix10` varchar(60) DEFAULT NULL,
  `sens_min` varchar(120) DEFAULT NULL,
  `sens_max` varchar(120) DEFAULT NULL,
  `position` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `q_questionnaire1`
--

INSERT INTO `q_questionnaire1` (`id`, `intitule`, `type`, `choix1`, `choix2`, `choix3`, `choix4`, `choix5`, `choix6`, `choix7`, `choix8`, `choix9`, `choix10`, `sens_min`, `sens_max`, `position`) VALUES
(1, 'Quel est votre nom ?', 'champ_texte', '', '', '', '', '', '', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `r_questionnaire1`
--

DROP TABLE IF EXISTS `r_questionnaire1`;
CREATE TABLE IF NOT EXISTS `r_questionnaire1` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `1_` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `r_questionnaire1`
--

INSERT INTO `r_questionnaire1` (`id`, `1_`) VALUES
(2, 'eegzeg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(120) NOT NULL,
  `privilege` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `password`, `privilege`) VALUES
(1, 'password1', 'admin'),
(2, 'password2', 'user');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
