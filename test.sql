-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 09 mars 2018 à 16:55
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
-- Base de données :  `test`
--

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `intitule` text NOT NULL,
  `type` text NOT NULL,
  `choix1` text NOT NULL,
  `choix2` text NOT NULL,
  `choix3` text NOT NULL,
  `choix4` text NOT NULL,
  `choix5` text NOT NULL,
  `choix6` text NOT NULL,
  `choix7` text NOT NULL,
  `choix8` text NOT NULL,
  `choix9` text NOT NULL,
  `choix10` text NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `sens_min` text NOT NULL,
  `sens_max` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`intitule`, `type`, `choix1`, `choix2`, `choix3`, `choix4`, `choix5`, `choix6`, `choix7`, `choix8`, `choix9`, `choix10`, `ID`, `sens_min`, `sens_max`) VALUES
('Depuis quand êtes-vous lié à cette start-up ?', 'echelle', '', '', '', '', '', '', '', '', '', '', 6, 'Très récemment', 'Depuis ses débuts'),
('Profession', 'champ_texte', '', '', '', '', '', '', '', '', '', '', 3, '', ''),
('Position par rapport à la start-up ?', 'choix_multiple', 'CEO', 'Membre du comité de direction', 'Salarié avec parts', 'Salarié sans part', 'Consultant extérieur', 'Investisseur', 'Structure d\'accompagnement', '', '', '', 5, '', ''),
('Prénom', 'champ_texte', '', '', '', '', '', '', '', '', '', '', 2, '', ''),
('Nom', 'champ_texte', '', '', '', '', '', '', '', '', '', '', 1, '', '');

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
CREATE TABLE IF NOT EXISTS `reponses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `1_` varchar(255) DEFAULT NULL,
  `2_` varchar(255) DEFAULT NULL,
  `3_` varchar(255) DEFAULT NULL,
  `5_CEO` varchar(255) NOT NULL,
  `5_Membre_du_comité_de_direction` varchar(255) NOT NULL,
  `5_Salarié_avec_parts` varchar(255) NOT NULL,
  `5_Salarié_sans_part` varchar(255) NOT NULL,
  `5_Consultant_extérieur` varchar(255) NOT NULL,
  `5_Investisseur` varchar(255) NOT NULL,
  `5_` varchar(255) NOT NULL,
  `6_` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
