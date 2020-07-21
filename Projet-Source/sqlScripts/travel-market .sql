-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 03 juil. 2020 à 17:05
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `travel-market`
--

-- --------------------------------------------------------

--
-- Structure de la table `activites`
--

DROP TABLE IF EXISTS `activites`;
CREATE TABLE IF NOT EXISTS `activites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agences_id` int(11) NOT NULL,
  `activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_766B5EB59917E4AB` (`agences_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `agences`
--

DROP TABLE IF EXISTS `agences`;
CREATE TABLE IF NOT EXISTS `agences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pays_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `nom_agence` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` date NOT NULL,
  `nombre_employes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_directeur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_directeur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_directeur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville_id` int(11) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B46015DDFB88E14F` (`utilisateur_id`),
  KEY `IDX_B46015DDA6E44244` (`pays_id`),
  KEY `IDX_B46015DDA73F0036` (`ville_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `agences`
--

INSERT INTO `agences` (`id`, `pays_id`, `utilisateur_id`, `nom_agence`, `adresse`, `code_postal`, `telephone`, `email`, `fax`, `logo`, `date_creation`, `nombre_employes`, `nom_directeur`, `telephone_directeur`, `email_directeur`, `ville_id`, `etat`) VALUES
(10, 1, 27, 'Salma Agency', 'Oujda Maroc', '60000', '0612346578', 'salma@agency.com', '123456', '96af9876274ea89125bb63c3e19c25a4.tmp', '2020-07-02', '8', 'Laayouni salma', '0613246578', 'salma@gmail.com', 1, 1),
(11, 2, 26, 'Badr Agency', 'Paris,France', '100000', '1213246578', 'badr@agency.com', '123654', '02997f645fec4326703a5f8b0661915f.tmp', '2020-06-30', '6', 'Tannouch Badr', '0612346578', 'badr@gmail.com', 2, 1),
(12, 1, 28, 'Yazid Agency', 'Berkane,Maroc', '60300', '0612346578', 'yazid@agency', '123456', 'e5cc6b719c08bd10f451229ca7c1e219.tmp', '2020-06-30', '10', 'Amara Yazid', '06123465798', 'yazid@gmail.com', 3, 1),
(16, 1, 25, '-5eff0a0a3e69a.tmp', '-5eff0a0a3e69a.tmp', '123456', '06123465', '-5eff0a0a3e69a@gma.tmp', '1324', '8abc1aa81721bb8827da8981711ec994.tmp', '2018-02-03', '5', 'tstttt', '0613245687', 'tstttt@gmail.com', 1, 1),
(17, 1, 24, 'testImage', 'maroc', '12346578', '0612345678', 'test@image.com', '654321', '6b298cf0f58576933e75b8380326df0b.tmp', '2020-07-01', '5', 'test', '0612346578', 'tes@gmaiimage.com', 1, 0),
(18, 1, 9, 'test images test test', 'web/uploads/logo/172c2dada6fba3a2b58414de85f9dffc.tmp', '12345', '1234567891', 'test@gmail.com', '12345', 'c73d2aa95b878a7b18834fb72de34ef7.tmp', '2020-06-30', '3', 'merieml', '123456', 'mero@g.cm', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D95DB16B98260155` (`region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_fr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `callsign` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200618183442', '2020-06-18 18:34:55', 250),
('DoctrineMigrations\\Version20200618185808', '2020-06-18 18:58:16', 85),
('DoctrineMigrations\\Version20200618202527', '2020-06-18 20:25:33', 75),
('DoctrineMigrations\\Version20200619085352', '2020-06-19 08:53:59', 194),
('DoctrineMigrations\\Version20200619085812', '2020-06-19 08:58:19', 48),
('DoctrineMigrations\\Version20200623133948', '2020-06-23 13:39:58', 147),
('DoctrineMigrations\\Version20200624170249', '2020-06-24 17:03:02', 290),
('DoctrineMigrations\\Version20200625093301', '2020-06-25 09:33:09', 410),
('DoctrineMigrations\\Version20200626122012', '2020-06-26 12:24:47', 82),
('DoctrineMigrations\\Version20200626155421', '2020-06-26 15:55:53', 88),
('DoctrineMigrations\\Version20200626160859', '2020-06-26 16:09:08', 95);

-- --------------------------------------------------------

--
-- Structure de la table `email`
--

DROP TABLE IF EXISTS `email`;
CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `email`
--

INSERT INTO `email` (`id`, `type`, `main`, `user`) VALUES
(1, 'test', 'testtest', 'Administrateur'),
(2, 'testEdit', 'editedit', 'Editeur'),
(3, 'test', 'test', 'Administrateur'),
(4, 'Confirmation', 'Bonjour ,\r\nMerci de confirmer votre inscription!', 'Editeur');

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `login`
--

INSERT INTO `login` (`id`, `username`, `ip`, `timestamp`, `success`) VALUES
(1, 'meriem@gmail.com', '127.0.0.1', '2020-06-30 17:30:48', 1),
(2, 'test@gmail.com', '127.0.0.1', '2020-06-30 17:36:07', 1),
(3, 'meriem@gmail.com', '127.0.0.1', '2020-07-01 08:34:31', 1),
(4, 'meriem@gmail.com', '127.0.0.1', '2020-07-01 11:01:14', 1),
(5, 'meriem@gmail.com', '127.0.0.1', '2020-07-01 11:03:30', 1),
(6, 'meriem@gmail.com', '127.0.0.1', '2020-07-01 11:08:06', 1),
(7, 'edit@gmail.com', '127.0.0.1', '2020-07-01 11:20:20', 1),
(8, 'meriem@gmail.com', '127.0.0.1', '2020-07-01 11:22:03', 1),
(9, 'meriem@gmail.com', '127.0.0.1', '2020-07-01 12:53:56', 1),
(10, 'edit@gmail.com', '127.0.0.1', '2020-07-01 12:54:10', 1),
(11, 'meriem@gmail.com', '127.0.0.1', '2020-07-01 12:59:54', 1),
(12, 'meriem@gmail.com', '127.0.0.1', '2020-07-01 17:05:23', 1),
(13, 'edit@gmail.com', '127.0.0.1', '2020-07-02 08:25:20', 1),
(14, 'meriem@gmail.com', '127.0.0.1', '2020-07-02 08:25:57', 1),
(15, 'meriem@gmail.com', '127.0.0.1', '2020-07-02 08:56:23', 1),
(16, 'meriem@gmail.com', '127.0.0.1', '2020-07-02 14:04:00', 1),
(17, 'yazid@gmail.com', '127.0.0.1', '2020-07-02 14:50:22', 0),
(18, 'yazid@gmail.com', '127.0.0.1', '2020-07-02 14:50:40', 1),
(19, 'meriem@gmail.com', '127.0.0.1', '2020-07-02 14:58:03', 1),
(20, 'meriem@gmail.com', '127.0.0.1', '2020-07-02 16:42:05', 1),
(21, 'meriem@gmail.com', '127.0.0.1', '2020-07-03 08:42:10', 1),
(22, NULL, '127.0.0.1', '2020-07-03 16:42:43', 1),
(23, 'miloud@gmail.com', '127.0.0.1', '2020-07-03 16:43:49', 1),
(24, NULL, '127.0.0.1', '2020-07-03 16:44:25', 1),
(25, 'meriem@gmail.com', '127.0.0.1', '2020-07-03 16:44:41', 1);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id`, `nom_pays`) VALUES
(1, 'Maroc'),
(2, 'France');

-- --------------------------------------------------------

--
-- Structure de la table `regions`
--

DROP TABLE IF EXISTS `regions`;
CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A26779F3F92F3E70` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sent`
--

DROP TABLE IF EXISTS `sent`;
CREATE TABLE IF NOT EXISTS `sent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_email_id` int(11) NOT NULL,
  `id_user_id` int(11) NOT NULL,
  `date_envoie` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BAC42AA9F8E92D5C` (`id_email_id`),
  KEY `IDX_BAC42AA979F37AE5` (`id_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sent`
--

INSERT INTO `sent` (`id`, `id_email_id`, `id_user_id`, `date_envoie`) VALUES
(2, 1, 9, '2020-07-02 11:11:01'),
(7, 1, 9, '2020-07-02 11:36:46'),
(14, 4, 27, '2020-07-02 15:53:25'),
(15, 4, 26, '2020-07-02 15:53:25'),
(16, 4, 26, '2020-07-03 16:48:54'),
(17, 4, 27, '2020-07-03 16:48:54'),
(18, 4, 28, '2020-07-03 16:48:54');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_maintenance` tinyint(1) NOT NULL,
  `nom_site` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inscription` tinyint(1) NOT NULL,
  `duree_sessions` int(11) NOT NULL,
  `duree_inactivite` int(11) NOT NULL,
  `fuseau_horaire_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E545A0C598DBDF9B` (`fuseau_horaire_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `mode_maintenance`, `nom_site`, `favicon`, `logo`, `inscription`, `duree_sessions`, `duree_inactivite`, `fuseau_horaire_id`) VALUES
(1, 0, 'Travel', '275e12d40793939afcda9f38ed595c98.tmp', '763e340299de8a61304e3be16656b20e.tmp', 1, 15, 20, 491);

-- --------------------------------------------------------

--
-- Structure de la table `timezones`
--

DROP TABLE IF EXISTS `timezones`;
CREATE TABLE IF NOT EXISTS `timezones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timezone_groupe_fr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone_groupe_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone_detail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=576 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `timezones`
--

INSERT INTO `timezones` (`id`, `timezone_groupe_fr`, `timezone_groupe_en`, `timezone_detail`) VALUES
(1, 'Afrique', 'Africa', 'Africa/Abidjan'),
(2, 'Afrique', 'Africa', 'Africa/Accra'),
(3, 'Afrique', 'Africa', 'Africa/Addis_Ababa'),
(4, 'Afrique', 'Africa', 'Africa/Algiers'),
(5, 'Afrique', 'Africa', 'Africa/Asmara'),
(6, 'Afrique', 'Africa', 'Africa/Asmera'),
(7, 'Afrique', 'Africa', 'Africa/Bamako'),
(8, 'Afrique', 'Africa', 'Africa/Bangui'),
(9, 'Afrique', 'Africa', 'Africa/Banjul'),
(10, 'Afrique', 'Africa', 'Africa/Bissau'),
(11, 'Afrique', 'Africa', 'Africa/Blantyre'),
(12, 'Afrique', 'Africa', 'Africa/Brazzaville'),
(13, 'Afrique', 'Africa', 'Africa/Bujumbura'),
(14, 'Afrique', 'Africa', 'Africa/Cairo'),
(15, 'Afrique', 'Africa', 'Africa/Casablanca'),
(16, 'Afrique', 'Africa', 'Africa/Ceuta'),
(17, 'Afrique', 'Africa', 'Africa/Conakry'),
(18, 'Afrique', 'Africa', 'Africa/Dakar'),
(19, 'Afrique', 'Africa', 'Africa/Dar_es_Salaam'),
(20, 'Afrique', 'Africa', 'Africa/Djibouti'),
(21, 'Afrique', 'Africa', 'Africa/Douala'),
(22, 'Afrique', 'Africa', 'Africa/El_Aaiun'),
(23, 'Afrique', 'Africa', 'Africa/Freetown'),
(24, 'Afrique', 'Africa', 'Africa/Gaborone'),
(25, 'Afrique', 'Africa', 'Africa/Harare'),
(26, 'Afrique', 'Africa', 'Africa/Johannesburg'),
(27, 'Afrique', 'Africa', 'Africa/Juba'),
(28, 'Afrique', 'Africa', 'Africa/Kampala'),
(29, 'Afrique', 'Africa', 'Africa/Khartoum'),
(30, 'Afrique', 'Africa', 'Africa/Kigali'),
(31, 'Afrique', 'Africa', 'Africa/Kinshasa'),
(32, 'Afrique', 'Africa', 'Africa/Lagos'),
(33, 'Afrique', 'Africa', 'Africa/Libreville'),
(34, 'Afrique', 'Africa', 'Africa/Lome'),
(35, 'Afrique', 'Africa', 'Africa/Luanda'),
(36, 'Afrique', 'Africa', 'Africa/Lubumbashi'),
(37, 'Afrique', 'Africa', 'Africa/Lusaka'),
(38, 'Afrique', 'Africa', 'Africa/Malabo'),
(39, 'Afrique', 'Africa', 'Africa/Maputo'),
(40, 'Afrique', 'Africa', 'Africa/Maseru'),
(41, 'Afrique', 'Africa', 'Africa/Mbabane'),
(42, 'Afrique', 'Africa', 'Africa/Mogadishu'),
(43, 'Afrique', 'Africa', 'Africa/Monrovia'),
(44, 'Afrique', 'Africa', 'Africa/Nairobi'),
(45, 'Afrique', 'Africa', 'Africa/Ndjamena'),
(46, 'Afrique', 'Africa', 'Africa/Niamey'),
(47, 'Afrique', 'Africa', 'Africa/Nouakchott'),
(48, 'Afrique', 'Africa', 'Africa/Ouagadougou'),
(49, 'Afrique', 'Africa', 'Africa/Porto-Novo'),
(50, 'Afrique', 'Africa', 'Africa/Sao_Tome'),
(51, 'Afrique', 'Africa', 'Africa/Timbuktu'),
(52, 'Afrique', 'Africa', 'Africa/Tripoli'),
(53, 'Afrique', 'Africa', 'Africa/Tunis'),
(54, 'Afrique', 'Africa', 'Africa/Windhoek'),
(55, 'Amérique', 'America', 'America/Adak'),
(56, 'Amérique', 'America', 'America/Anchorage'),
(57, 'Amérique', 'America', 'America/Anguilla'),
(58, 'Amérique', 'America', 'America/Antigua'),
(59, 'Amérique', 'America', 'America/Araguaina'),
(60, 'Amérique', 'America', 'America/Argentina/Buenos_Aires'),
(61, 'Amérique', 'America', 'America/Argentina/Catamarca'),
(62, 'Amérique', 'America', 'America/Argentina/ComodRivadavia'),
(63, 'Amérique', 'America', 'America/Argentina/Cordoba'),
(64, 'Amérique', 'America', 'America/Argentina/Jujuy'),
(65, 'Amérique', 'America', 'America/Argentina/La_Rioja'),
(66, 'Amérique', 'America', 'America/Argentina/Mendoza'),
(67, 'Amérique', 'America', 'America/Argentina/Rio_Gallegos'),
(68, 'Amérique', 'America', 'America/Argentina/Salta'),
(69, 'Amérique', 'America', 'America/Argentina/San_Juan'),
(70, 'Amérique', 'America', 'America/Argentina/San_Luis'),
(71, 'Amérique', 'America', 'America/Argentina/Tucuman'),
(72, 'Amérique', 'America', 'America/Argentina/Ushuaia'),
(73, 'Amérique', 'America', 'America/Aruba'),
(74, 'Amérique', 'America', 'America/Asuncion'),
(75, 'Amérique', 'America', 'America/Atikokan'),
(76, 'Amérique', 'America', 'America/Atka'),
(77, 'Amérique', 'America', 'America/Bahia'),
(78, 'Amérique', 'America', 'America/Bahia_Banderas'),
(79, 'Amérique', 'America', 'America/Barbados'),
(80, 'Amérique', 'America', 'America/Belem'),
(81, 'Amérique', 'America', 'America/Belize'),
(82, 'Amérique', 'America', 'America/Blanc-Sablon'),
(83, 'Amérique', 'America', 'America/Boa_Vista'),
(84, 'Amérique', 'America', 'America/Bogota'),
(85, 'Amérique', 'America', 'America/Boise'),
(86, 'Amérique', 'America', 'America/Buenos_Aires'),
(87, 'Amérique', 'America', 'America/Cambridge_Bay'),
(88, 'Amérique', 'America', 'America/Campo_Grande'),
(89, 'Amérique', 'America', 'America/Cancun'),
(90, 'Amérique', 'America', 'America/Caracas'),
(91, 'Amérique', 'America', 'America/Catamarca'),
(92, 'Amérique', 'America', 'America/Cayenne'),
(93, 'Amérique', 'America', 'America/Cayman'),
(94, 'Amérique', 'America', 'America/Chicago'),
(95, 'Amérique', 'America', 'America/Chihuahua'),
(96, 'Amérique', 'America', 'America/Coral_Harbour'),
(97, 'Amérique', 'America', 'America/Cordoba'),
(98, 'Amérique', 'America', 'America/Costa_Rica'),
(99, 'Amérique', 'America', 'America/Creston'),
(100, 'Amérique', 'America', 'America/Cuiaba'),
(101, 'Amérique', 'America', 'America/Curacao'),
(102, 'Amérique', 'America', 'America/Danmarkshavn'),
(103, 'Amérique', 'America', 'America/Dawson'),
(104, 'Amérique', 'America', 'America/Dawson_Creek'),
(105, 'Amérique', 'America', 'America/Denver'),
(106, 'Amérique', 'America', 'America/Detroit'),
(107, 'Amérique', 'America', 'America/Dominica'),
(108, 'Amérique', 'America', 'America/Edmonton'),
(109, 'Amérique', 'America', 'America/Eirunepe'),
(110, 'Amérique', 'America', 'America/El_Salvador'),
(111, 'Amérique', 'America', 'America/Ensenada'),
(112, 'Amérique', 'America', 'America/Fort_Wayne'),
(113, 'Amérique', 'America', 'America/Fortaleza'),
(114, 'Amérique', 'America', 'America/Glace_Bay'),
(115, 'Amérique', 'America', 'America/Godthab'),
(116, 'Amérique', 'America', 'America/Goose_Bay'),
(117, 'Amérique', 'America', 'America/Grand_Turk'),
(118, 'Amérique', 'America', 'America/Grenada'),
(119, 'Amérique', 'America', 'America/Guadeloupe'),
(120, 'Amérique', 'America', 'America/Guatemala'),
(121, 'Amérique', 'America', 'America/Guayaquil'),
(122, 'Amérique', 'America', 'America/Guyana'),
(123, 'Amérique', 'America', 'America/Halifax'),
(124, 'Amérique', 'America', 'America/Havana'),
(125, 'Amérique', 'America', 'America/Hermosillo'),
(126, 'Amérique', 'America', 'America/Indiana/Indianapolis'),
(127, 'Amérique', 'America', 'America/Indiana/Knox'),
(128, 'Amérique', 'America', 'America/Indiana/Marengo'),
(129, 'Amérique', 'America', 'America/Indiana/Petersburg'),
(130, 'Amérique', 'America', 'America/Indiana/Tell_City'),
(131, 'Amérique', 'America', 'America/Indiana/Vevay'),
(132, 'Amérique', 'America', 'America/Indiana/Vincennes'),
(133, 'Amérique', 'America', 'America/Indiana/Winamac'),
(134, 'Amérique', 'America', 'America/Indianapolis'),
(135, 'Amérique', 'America', 'America/Inuvik'),
(136, 'Amérique', 'America', 'America/Iqaluit'),
(137, 'Amérique', 'America', 'America/Jamaica'),
(138, 'Amérique', 'America', 'America/Jujuy'),
(139, 'Amérique', 'America', 'America/Juneau'),
(140, 'Amérique', 'America', 'America/Kentucky/Louisville'),
(141, 'Amérique', 'America', 'America/Kentucky/Monticello'),
(142, 'Amérique', 'America', 'America/Knox_IN'),
(143, 'Amérique', 'America', 'America/Kralendijk'),
(144, 'Amérique', 'America', 'America/La_Paz'),
(145, 'Amérique', 'America', 'America/Lima'),
(146, 'Amérique', 'America', 'America/Los_Angeles'),
(147, 'Amérique', 'America', 'America/Louisville'),
(148, 'Amérique', 'America', 'America/Lower_Princes'),
(149, 'Amérique', 'America', 'America/Maceio'),
(150, 'Amérique', 'America', 'America/Managua'),
(151, 'Amérique', 'America', 'America/Manaus'),
(152, 'Amérique', 'America', 'America/Marigot'),
(153, 'Amérique', 'America', 'America/Martinique'),
(154, 'Amérique', 'America', 'America/Matamoros'),
(155, 'Amérique', 'America', 'America/Mazatlan'),
(156, 'Amérique', 'America', 'America/Mendoza'),
(157, 'Amérique', 'America', 'America/Menominee'),
(158, 'Amérique', 'America', 'America/Merida'),
(159, 'Amérique', 'America', 'America/Metlakatla'),
(160, 'Amérique', 'America', 'America/Mexico_City'),
(161, 'Amérique', 'America', 'America/Miquelon'),
(162, 'Amérique', 'America', 'America/Moncton'),
(163, 'Amérique', 'America', 'America/Monterrey'),
(164, 'Amérique', 'America', 'America/Montevideo'),
(165, 'Amérique', 'America', 'America/Montreal'),
(166, 'Amérique', 'America', 'America/Montserrat'),
(167, 'Amérique', 'America', 'America/Nassau'),
(168, 'Amérique', 'America', 'America/New_York'),
(169, 'Amérique', 'America', 'America/Nipigon'),
(170, 'Amérique', 'America', 'America/Nome'),
(171, 'Amérique', 'America', 'America/Noronha'),
(172, 'Amérique', 'America', 'America/North_Dakota/Beulah'),
(173, 'Amérique', 'America', 'America/North_Dakota/Center'),
(174, 'Amérique', 'America', 'America/North_Dakota/New_Salem'),
(175, 'Amérique', 'America', 'America/Ojinaga'),
(176, 'Amérique', 'America', 'America/Panama'),
(177, 'Amérique', 'America', 'America/Pangnirtung'),
(178, 'Amérique', 'America', 'America/Paramaribo'),
(179, 'Amérique', 'America', 'America/Phoenix'),
(180, 'Amérique', 'America', 'America/Port-au-Prince'),
(181, 'Amérique', 'America', 'America/Port_of_Spain'),
(182, 'Amérique', 'America', 'America/Porto_Acre'),
(183, 'Amérique', 'America', 'America/Porto_Velho'),
(184, 'Amérique', 'America', 'America/Puerto_Rico'),
(185, 'Amérique', 'America', 'America/Rainy_River'),
(186, 'Amérique', 'America', 'America/Rankin_Inlet'),
(187, 'Amérique', 'America', 'America/Recife'),
(188, 'Amérique', 'America', 'America/Regina'),
(189, 'Amérique', 'America', 'America/Resolute'),
(190, 'Amérique', 'America', 'America/Rio_Branco'),
(191, 'Amérique', 'America', 'America/Rosario'),
(192, 'Amérique', 'America', 'America/Santa_Isabel'),
(193, 'Amérique', 'America', 'America/Santarem'),
(194, 'Amérique', 'America', 'America/Santiago'),
(195, 'Amérique', 'America', 'America/Santo_Domingo'),
(196, 'Amérique', 'America', 'America/Sao_Paulo'),
(197, 'Amérique', 'America', 'America/Scoresbysund'),
(198, 'Amérique', 'America', 'America/Shiprock'),
(199, 'Amérique', 'America', 'America/Sitka'),
(200, 'Amérique', 'America', 'America/St_Barthelemy'),
(201, 'Amérique', 'America', 'America/St_Johns'),
(202, 'Amérique', 'America', 'America/St_Kitts'),
(203, 'Amérique', 'America', 'America/St_Lucia'),
(204, 'Amérique', 'America', 'America/St_Thomas'),
(205, 'Amérique', 'America', 'America/St_Vincent'),
(206, 'Amérique', 'America', 'America/Swift_Current'),
(207, 'Amérique', 'America', 'America/Tegucigalpa'),
(208, 'Amérique', 'America', 'America/Thule'),
(209, 'Amérique', 'America', 'America/Thunder_Bay'),
(210, 'Amérique', 'America', 'America/Tijuana'),
(211, 'Amérique', 'America', 'America/Toronto'),
(212, 'Amérique', 'America', 'America/Tortola'),
(213, 'Amérique', 'America', 'America/Vancouver'),
(214, 'Amérique', 'America', 'America/Virgin'),
(215, 'Amérique', 'America', 'America/Whitehorse'),
(216, 'Amérique', 'America', 'America/Winnipeg'),
(217, 'Amérique', 'America', 'America/Yakutat'),
(218, 'Amérique', 'America', 'America/Yellowknife'),
(219, 'Antarctique', 'Antarctica', 'Antarctica/Casey'),
(220, 'Antarctique', 'Antarctica', 'Antarctica/Davis'),
(221, 'Antarctique', 'Antarctica', 'Antarctica/DumontDUrville'),
(222, 'Antarctique', 'Antarctica', 'Antarctica/Macquarie'),
(223, 'Antarctique', 'Antarctica', 'Antarctica/Mawson'),
(224, 'Antarctique', 'Antarctica', 'Antarctica/McMurdo'),
(225, 'Antarctique', 'Antarctica', 'Antarctica/Palmer'),
(226, 'Antarctique', 'Antarctica', 'Antarctica/Rothera'),
(227, 'Antarctique', 'Antarctica', 'Antarctica/South_Pole'),
(228, 'Antarctique', 'Antarctica', 'Antarctica/Syowa'),
(229, 'Antarctique', 'Antarctica', 'Antarctica/Vostok'),
(230, 'Arctique', 'Arctic', 'Arctic/Longyearbyen'),
(231, 'Asie', 'Asia', 'Asia/Aden'),
(232, 'Asie', 'Asia', 'Asia/Almaty'),
(233, 'Asie', 'Asia', 'Asia/Amman'),
(234, 'Asie', 'Asia', 'Asia/Anadyr'),
(235, 'Asie', 'Asia', 'Asia/Aqtau'),
(236, 'Asie', 'Asia', 'Asia/Aqtobe'),
(237, 'Asie', 'Asia', 'Asia/Ashgabat'),
(238, 'Asie', 'Asia', 'Asia/Ashkhabad'),
(239, 'Asie', 'Asia', 'Asia/Baghdad'),
(240, 'Asie', 'Asia', 'Asia/Bahrain'),
(241, 'Asie', 'Asia', 'Asia/Baku'),
(242, 'Asie', 'Asia', 'Asia/Bangkok'),
(243, 'Asie', 'Asia', 'Asia/Beirut'),
(244, 'Asie', 'Asia', 'Asia/Bishkek'),
(245, 'Asie', 'Asia', 'Asia/Brunei'),
(246, 'Asie', 'Asia', 'Asia/Calcutta'),
(247, 'Asie', 'Asia', 'Asia/Choibalsan'),
(248, 'Asie', 'Asia', 'Asia/Chongqing'),
(249, 'Asie', 'Asia', 'Asia/Chungking'),
(250, 'Asie', 'Asia', 'Asia/Colombo'),
(251, 'Asie', 'Asia', 'Asia/Dacca'),
(252, 'Asie', 'Asia', 'Asia/Damascus'),
(253, 'Asie', 'Asia', 'Asia/Dhaka'),
(254, 'Asie', 'Asia', 'Asia/Dili'),
(255, 'Asie', 'Asia', 'Asia/Dubai'),
(256, 'Asie', 'Asia', 'Asia/Dushanbe'),
(257, 'Asie', 'Asia', 'Asia/Gaza'),
(258, 'Asie', 'Asia', 'Asia/Harbin'),
(259, 'Asie', 'Asia', 'Asia/Hebron'),
(260, 'Asie', 'Asia', 'Asia/Ho_Chi_Minh'),
(261, 'Asie', 'Asia', 'Asia/Hong_Kong'),
(262, 'Asie', 'Asia', 'Asia/Hovd'),
(263, 'Asie', 'Asia', 'Asia/Irkutsk'),
(264, 'Asie', 'Asia', 'Asia/Istanbul'),
(265, 'Asie', 'Asia', 'Asia/Jakarta'),
(266, 'Asie', 'Asia', 'Asia/Jayapura'),
(267, 'Asie', 'Asia', 'Asia/Jerusalem'),
(268, 'Asie', 'Asia', 'Asia/Kabul'),
(269, 'Asie', 'Asia', 'Asia/Kamchatka'),
(270, 'Asie', 'Asia', 'Asia/Karachi'),
(271, 'Asie', 'Asia', 'Asia/Kashgar'),
(272, 'Asie', 'Asia', 'Asia/Kathmandu'),
(273, 'Asie', 'Asia', 'Asia/Katmandu'),
(274, 'Asie', 'Asia', 'Asia/Kolkata'),
(275, 'Asie', 'Asia', 'Asia/Krasnoyarsk'),
(276, 'Asie', 'Asia', 'Asia/Kuala_Lumpur'),
(277, 'Asie', 'Asia', 'Asia/Kuching'),
(278, 'Asie', 'Asia', 'Asia/Kuwait'),
(279, 'Asie', 'Asia', 'Asia/Macao'),
(280, 'Asie', 'Asia', 'Asia/Macau'),
(281, 'Asie', 'Asia', 'Asia/Magadan'),
(282, 'Asie', 'Asia', 'Asia/Makassar'),
(283, 'Asie', 'Asia', 'Asia/Manila'),
(284, 'Asie', 'Asia', 'Asia/Muscat'),
(285, 'Asie', 'Asia', 'Asia/Nicosia'),
(286, 'Asie', 'Asia', 'Asia/Novokuznetsk'),
(287, 'Asie', 'Asia', 'Asia/Novosibirsk'),
(288, 'Asie', 'Asia', 'Asia/Omsk'),
(289, 'Asie', 'Asia', 'Asia/Oral'),
(290, 'Asie', 'Asia', 'Asia/Phnom_Penh'),
(291, 'Asie', 'Asia', 'Asia/Pontianak'),
(292, 'Asie', 'Asia', 'Asia/Pyongyang'),
(293, 'Asie', 'Asia', 'Asia/Qatar'),
(294, 'Asie', 'Asia', 'Asia/Qyzylorda'),
(295, 'Asie', 'Asia', 'Asia/Rangoon'),
(296, 'Asie', 'Asia', 'Asia/Riyadh'),
(297, 'Asie', 'Asia', 'Asia/Saigon'),
(298, 'Asie', 'Asia', 'Asia/Sakhalin'),
(299, 'Asie', 'Asia', 'Asia/Samarkand'),
(300, 'Asie', 'Asia', 'Asia/Seoul'),
(301, 'Asie', 'Asia', 'Asia/Shanghai'),
(302, 'Asie', 'Asia', 'Asia/Singapore'),
(303, 'Asie', 'Asia', 'Asia/Taipei'),
(304, 'Asie', 'Asia', 'Asia/Tashkent'),
(305, 'Asie', 'Asia', 'Asia/Tbilisi'),
(306, 'Asie', 'Asia', 'Asia/Tehran'),
(307, 'Asie', 'Asia', 'Asia/Tel_Aviv'),
(308, 'Asie', 'Asia', 'Asia/Thimbu'),
(309, 'Asie', 'Asia', 'Asia/Thimphu'),
(310, 'Asie', 'Asia', 'Asia/Tokyo'),
(311, 'Asie', 'Asia', 'Asia/Ujung_Pandang'),
(312, 'Asie', 'Asia', 'Asia/Ulaanbaatar'),
(313, 'Asie', 'Asia', 'Asia/Ulan_Bator'),
(314, 'Asie', 'Asia', 'Asia/Urumqi'),
(315, 'Asie', 'Asia', 'Asia/Vientiane'),
(316, 'Asie', 'Asia', 'Asia/Vladivostok'),
(317, 'Asie', 'Asia', 'Asia/Yakutsk'),
(318, 'Asie', 'Asia', 'Asia/Yekaterinburg'),
(319, 'Asie', 'Asia', 'Asia/Yerevan'),
(320, 'Atlantique', 'Atlantic', 'Atlantic/Azores'),
(321, 'Atlantique', 'Atlantic', 'Atlantic/Bermuda'),
(322, 'Atlantique', 'Atlantic', 'Atlantic/Canary'),
(323, 'Atlantique', 'Atlantic', 'Atlantic/Cape_Verde'),
(324, 'Atlantique', 'Atlantic', 'Atlantic/Faeroe'),
(325, 'Atlantique', 'Atlantic', 'Atlantic/Faroe'),
(326, 'Atlantique', 'Atlantic', 'Atlantic/Jan_Mayen'),
(327, 'Atlantique', 'Atlantic', 'Atlantic/Madeira'),
(328, 'Atlantique', 'Atlantic', 'Atlantic/Reykjavik'),
(329, 'Atlantique', 'Atlantic', 'Atlantic/South_Georgia'),
(330, 'Atlantique', 'Atlantic', 'Atlantic/St_Helena'),
(331, 'Atlantique', 'Atlantic', 'Atlantic/Stanley'),
(332, 'Australie', 'Australia', 'Australia/ACT'),
(333, 'Australie', 'Australia', 'Australia/Adelaide'),
(334, 'Australie', 'Australia', 'Australia/Brisbane'),
(335, 'Australie', 'Australia', 'Australia/Broken_Hill'),
(336, 'Australie', 'Australia', 'Australia/Canberra'),
(337, 'Australie', 'Australia', 'Australia/Currie'),
(338, 'Australie', 'Australia', 'Australia/Darwin'),
(339, 'Australie', 'Australia', 'Australia/Eucla'),
(340, 'Australie', 'Australia', 'Australia/Hobart'),
(341, 'Australie', 'Australia', 'Australia/LHI'),
(342, 'Australie', 'Australia', 'Australia/Lindeman'),
(343, 'Australie', 'Australia', 'Australia/Lord_Howe'),
(344, 'Australie', 'Australia', 'Australia/Melbourne'),
(345, 'Australie', 'Australia', 'Australia/NSW'),
(346, 'Australie', 'Australia', 'Australia/North'),
(347, 'Australie', 'Australia', 'Australia/Perth'),
(348, 'Australie', 'Australia', 'Australia/Queensland'),
(349, 'Australie', 'Australia', 'Australia/South'),
(350, 'Australie', 'Australia', 'Australia/Sydney'),
(351, 'Australie', 'Australia', 'Australia/Tasmania'),
(352, 'Australie', 'Australia', 'Australia/Victoria'),
(353, 'Australie', 'Australia', 'Australia/West'),
(354, 'Australie', 'Australia', 'Australia/Yancowinna'),
(355, 'Europe', 'Europe', 'Europe/Amsterdam'),
(356, 'Europe', 'Europe', 'Europe/Andorra'),
(357, 'Europe', 'Europe', 'Europe/Athens'),
(358, 'Europe', 'Europe', 'Europe/Belfast'),
(359, 'Europe', 'Europe', 'Europe/Belgrade'),
(360, 'Europe', 'Europe', 'Europe/Berlin'),
(361, 'Europe', 'Europe', 'Europe/Bratislava'),
(362, 'Europe', 'Europe', 'Europe/Brussels'),
(363, 'Europe', 'Europe', 'Europe/Bucharest'),
(364, 'Europe', 'Europe', 'Europe/Budapest'),
(365, 'Europe', 'Europe', 'Europe/Chisinau'),
(366, 'Europe', 'Europe', 'Europe/Copenhagen'),
(367, 'Europe', 'Europe', 'Europe/Dublin'),
(368, 'Europe', 'Europe', 'Europe/Gibraltar'),
(369, 'Europe', 'Europe', 'Europe/Guernsey'),
(370, 'Europe', 'Europe', 'Europe/Helsinki'),
(371, 'Europe', 'Europe', 'Europe/Isle_of_Man'),
(372, 'Europe', 'Europe', 'Europe/Istanbul'),
(373, 'Europe', 'Europe', 'Europe/Jersey'),
(374, 'Europe', 'Europe', 'Europe/Kaliningrad'),
(375, 'Europe', 'Europe', 'Europe/Kiev'),
(376, 'Europe', 'Europe', 'Europe/Lisbon'),
(377, 'Europe', 'Europe', 'Europe/Ljubljana'),
(378, 'Europe', 'Europe', 'Europe/London'),
(379, 'Europe', 'Europe', 'Europe/Luxembourg'),
(380, 'Europe', 'Europe', 'Europe/Madrid'),
(381, 'Europe', 'Europe', 'Europe/Malta'),
(382, 'Europe', 'Europe', 'Europe/Mariehamn'),
(383, 'Europe', 'Europe', 'Europe/Minsk'),
(384, 'Europe', 'Europe', 'Europe/Monaco'),
(385, 'Europe', 'Europe', 'Europe/Moscow'),
(386, 'Europe', 'Europe', 'Europe/Nicosia'),
(387, 'Europe', 'Europe', 'Europe/Oslo'),
(388, 'Europe', 'Europe', 'Europe/Paris'),
(389, 'Europe', 'Europe', 'Europe/Podgorica'),
(390, 'Europe', 'Europe', 'Europe/Prague'),
(391, 'Europe', 'Europe', 'Europe/Riga'),
(392, 'Europe', 'Europe', 'Europe/Rome'),
(393, 'Europe', 'Europe', 'Europe/Samara'),
(394, 'Europe', 'Europe', 'Europe/San_Marino'),
(395, 'Europe', 'Europe', 'Europe/Sarajevo'),
(396, 'Europe', 'Europe', 'Europe/Simferopol'),
(397, 'Europe', 'Europe', 'Europe/Skopje'),
(398, 'Europe', 'Europe', 'Europe/Sofia'),
(399, 'Europe', 'Europe', 'Europe/Stockholm'),
(400, 'Europe', 'Europe', 'Europe/Tallinn'),
(401, 'Europe', 'Europe', 'Europe/Tirane'),
(402, 'Europe', 'Europe', 'Europe/Tiraspol'),
(403, 'Europe', 'Europe', 'Europe/Uzhgorod'),
(404, 'Europe', 'Europe', 'Europe/Vaduz'),
(405, 'Europe', 'Europe', 'Europe/Vatican'),
(406, 'Europe', 'Europe', 'Europe/Vienna'),
(407, 'Europe', 'Europe', 'Europe/Vilnius'),
(408, 'Europe', 'Europe', 'Europe/Volgograd'),
(409, 'Europe', 'Europe', 'Europe/Warsaw'),
(410, 'Europe', 'Europe', 'Europe/Zagreb'),
(411, 'Europe', 'Europe', 'Europe/Zaporozhye'),
(412, 'Europe', 'Europe', 'Europe/Zurich'),
(413, 'Indien', 'Indian', 'Indian/Antananarivo'),
(414, 'Indien', 'Indian', 'Indian/Chagos'),
(415, 'Indien', 'Indian', 'Indian/Christmas'),
(416, 'Indien', 'Indian', 'Indian/Cocos'),
(417, 'Indien', 'Indian', 'Indian/Comoro'),
(418, 'Indien', 'Indian', 'Indian/Kerguelen'),
(419, 'Indien', 'Indian', 'Indian/Mahe'),
(420, 'Indien', 'Indian', 'Indian/Maldives'),
(421, 'Indien', 'Indian', 'Indian/Mauritius'),
(422, 'Indien', 'Indian', 'Indian/Mayotte'),
(423, 'Indien', 'Indian', 'Indian/Reunion'),
(424, 'Pacifique', 'Pacific', 'Pacific/Apia'),
(425, 'Pacifique', 'Pacific', 'Pacific/Auckland'),
(426, 'Pacifique', 'Pacific', 'Pacific/Chatham'),
(427, 'Pacifique', 'Pacific', 'Pacific/Chuuk'),
(428, 'Pacifique', 'Pacific', 'Pacific/Easter'),
(429, 'Pacifique', 'Pacific', 'Pacific/Efate'),
(430, 'Pacifique', 'Pacific', 'Pacific/Enderbury'),
(431, 'Pacifique', 'Pacific', 'Pacific/Fakaofo'),
(432, 'Pacifique', 'Pacific', 'Pacific/Fiji'),
(433, 'Pacifique', 'Pacific', 'Pacific/Funafuti'),
(434, 'Pacifique', 'Pacific', 'Pacific/Galapagos'),
(435, 'Pacifique', 'Pacific', 'Pacific/Gambier'),
(436, 'Pacifique', 'Pacific', 'Pacific/Guadalcanal'),
(437, 'Pacifique', 'Pacific', 'Pacific/Guam'),
(438, 'Pacifique', 'Pacific', 'Pacific/Honolulu'),
(439, 'Pacifique', 'Pacific', 'Pacific/Johnston'),
(440, 'Pacifique', 'Pacific', 'Pacific/Kiritimati'),
(441, 'Pacifique', 'Pacific', 'Pacific/Kosrae'),
(442, 'Pacifique', 'Pacific', 'Pacific/Kwajalein'),
(443, 'Pacifique', 'Pacific', 'Pacific/Majuro'),
(444, 'Pacifique', 'Pacific', 'Pacific/Marquesas'),
(445, 'Pacifique', 'Pacific', 'Pacific/Midway'),
(446, 'Pacifique', 'Pacific', 'Pacific/Nauru'),
(447, 'Pacifique', 'Pacific', 'Pacific/Niue'),
(448, 'Pacifique', 'Pacific', 'Pacific/Norfolk'),
(449, 'Pacifique', 'Pacific', 'Pacific/Noumea'),
(450, 'Pacifique', 'Pacific', 'Pacific/Pago_Pago'),
(451, 'Pacifique', 'Pacific', 'Pacific/Palau'),
(452, 'Pacifique', 'Pacific', 'Pacific/Pitcairn'),
(453, 'Pacifique', 'Pacific', 'Pacific/Pohnpei'),
(454, 'Pacifique', 'Pacific', 'Pacific/Ponape'),
(455, 'Pacifique', 'Pacific', 'Pacific/Port_Moresby'),
(456, 'Pacifique', 'Pacific', 'Pacific/Rarotonga'),
(457, 'Pacifique', 'Pacific', 'Pacific/Saipan'),
(458, 'Pacifique', 'Pacific', 'Pacific/Samoa'),
(459, 'Pacifique', 'Pacific', 'Pacific/Tahiti'),
(460, 'Pacifique', 'Pacific', 'Pacific/Tarawa'),
(461, 'Pacifique', 'Pacific', 'Pacific/Tongatapu'),
(462, 'Pacifique', 'Pacific', 'Pacific/Truk'),
(463, 'Pacifique', 'Pacific', 'Pacific/Wake'),
(464, 'Pacifique', 'Pacific', 'Pacific/Wallis'),
(465, 'Pacifique', 'Pacific', 'Pacific/Yap'),
(466, 'Autres', 'Other', 'Brazil/Acre'),
(467, 'Autres', 'Other', 'Brazil/DeNoronha'),
(468, 'Autres', 'Other', 'Brazil/East'),
(469, 'Autres', 'Other', 'Brazil/West'),
(470, 'Autres', 'Other', 'CET'),
(471, 'Autres', 'Other', 'CST6CDT'),
(472, 'Autres', 'Other', 'Canada/Atlantic'),
(473, 'Autres', 'Other', 'Canada/Central'),
(474, 'Autres', 'Other', 'Canada/East-Saskatchewan'),
(475, 'Autres', 'Other', 'Canada/Eastern'),
(476, 'Autres', 'Other', 'Canada/Mountain'),
(477, 'Autres', 'Other', 'Canada/Newfoundland'),
(478, 'Autres', 'Other', 'Canada/Pacific'),
(479, 'Autres', 'Other', 'Canada/Saskatchewan'),
(480, 'Autres', 'Other', 'Canada/Yukon'),
(481, 'Autres', 'Other', 'Chile/Continental'),
(482, 'Autres', 'Other', 'Chile/EasterIsland'),
(483, 'Autres', 'Other', 'Cuba'),
(484, 'Autres', 'Other', 'EET'),
(485, 'Autres', 'Other', 'EST'),
(486, 'Autres', 'Other', 'EST5EDT'),
(487, 'Autres', 'Other', 'Egypt'),
(488, 'Autres', 'Other', 'Eire'),
(489, 'Autres', 'Other', 'Etc/GMT'),
(490, 'Autres', 'Other', 'Etc/GMT+0'),
(491, 'Autres', 'Other', 'Etc/GMT+1'),
(492, 'Autres', 'Other', 'Etc/GMT+10'),
(493, 'Autres', 'Other', 'Etc/GMT+11'),
(494, 'Autres', 'Other', 'Etc/GMT+12'),
(495, 'Autres', 'Other', 'Etc/GMT+2'),
(496, 'Autres', 'Other', 'Etc/GMT+3'),
(497, 'Autres', 'Other', 'Etc/GMT+4'),
(498, 'Autres', 'Other', 'Etc/GMT+5'),
(499, 'Autres', 'Other', 'Etc/GMT+6'),
(500, 'Autres', 'Other', 'Etc/GMT+7'),
(501, 'Autres', 'Other', 'Etc/GMT+8'),
(502, 'Autres', 'Other', 'Etc/GMT+9'),
(503, 'Autres', 'Other', 'Etc/GMT-0'),
(504, 'Autres', 'Other', 'Etc/GMT-1'),
(505, 'Autres', 'Other', 'Etc/GMT-10'),
(506, 'Autres', 'Other', 'Etc/GMT-11'),
(507, 'Autres', 'Other', 'Etc/GMT-12'),
(508, 'Autres', 'Other', 'Etc/GMT-13'),
(509, 'Autres', 'Other', 'Etc/GMT-14'),
(510, 'Autres', 'Other', 'Etc/GMT-2'),
(511, 'Autres', 'Other', 'Etc/GMT-3'),
(512, 'Autres', 'Other', 'Etc/GMT-4'),
(513, 'Autres', 'Other', 'Etc/GMT-5'),
(514, 'Autres', 'Other', 'Etc/GMT-6'),
(515, 'Autres', 'Other', 'Etc/GMT-7'),
(516, 'Autres', 'Other', 'Etc/GMT-8'),
(517, 'Autres', 'Other', 'Etc/GMT-9'),
(518, 'Autres', 'Other', 'Etc/GMT0'),
(519, 'Autres', 'Other', 'Etc/Greenwich'),
(520, 'Autres', 'Other', 'Etc/UCT'),
(521, 'Autres', 'Other', 'Etc/UTC'),
(522, 'Autres', 'Other', 'Etc/Universal'),
(523, 'Autres', 'Other', 'Etc/Zulu'),
(524, 'Autres', 'Other', 'GB'),
(525, 'Autres', 'Other', 'GB-Eire'),
(526, 'Autres', 'Other', 'GMT'),
(527, 'Autres', 'Other', 'GMT+0'),
(528, 'Autres', 'Other', 'GMT-0'),
(529, 'Autres', 'Other', 'GMT0'),
(530, 'Autres', 'Other', 'Greenwich'),
(531, 'Autres', 'Other', 'HST'),
(532, 'Autres', 'Other', 'Hongkong'),
(533, 'Autres', 'Other', 'Iceland'),
(534, 'Autres', 'Other', 'Iran'),
(535, 'Autres', 'Other', 'Israel'),
(536, 'Autres', 'Other', 'Jamaica'),
(537, 'Autres', 'Other', 'Japan'),
(538, 'Autres', 'Other', 'Kwajalein'),
(539, 'Autres', 'Other', 'Libya'),
(540, 'Autres', 'Other', 'MET'),
(541, 'Autres', 'Other', 'MST'),
(542, 'Autres', 'Other', 'MST7MDT'),
(543, 'Autres', 'Other', 'Mexico/BajaNorte'),
(544, 'Autres', 'Other', 'Mexico/BajaSur'),
(545, 'Autres', 'Other', 'Mexico/General'),
(546, 'Autres', 'Other', 'NZ'),
(547, 'Autres', 'Other', 'NZ-CHAT'),
(548, 'Autres', 'Other', 'Navajo'),
(549, 'Autres', 'Other', 'PRC'),
(550, 'Autres', 'Other', 'PST8PDT'),
(551, 'Autres', 'Other', 'Poland'),
(552, 'Autres', 'Other', 'Portugal'),
(553, 'Autres', 'Other', 'ROC'),
(554, 'Autres', 'Other', 'ROK'),
(555, 'Autres', 'Other', 'Singapore'),
(556, 'Autres', 'Other', 'Turkey'),
(557, 'Autres', 'Other', 'UCT'),
(558, 'Autres', 'Other', 'US/Alaska'),
(559, 'Autres', 'Other', 'US/Aleutian'),
(560, 'Autres', 'Other', 'US/Arizona'),
(561, 'Autres', 'Other', 'US/Central'),
(562, 'Autres', 'Other', 'US/East-Indiana'),
(563, 'Autres', 'Other', 'US/Eastern'),
(564, 'Autres', 'Other', 'US/Hawaii'),
(565, 'Autres', 'Other', 'US/Indiana-Starke'),
(566, 'Autres', 'Other', 'US/Michigan'),
(567, 'Autres', 'Other', 'US/Mountain'),
(568, 'Autres', 'Other', 'US/Pacific'),
(569, 'Autres', 'Other', 'US/Pacific-New'),
(570, 'Autres', 'Other', 'US/Samoa'),
(571, 'Autres', 'Other', 'UTC'),
(572, 'Autres', 'Other', 'Universal'),
(573, 'Autres', 'Other', 'W-SU'),
(574, 'Autres', 'Other', 'WET'),
(575, 'Autres', 'Other', 'Zulu');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `poste` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat` tinyint(1) NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `inscription` date NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forgotten_pass_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forgotten_pass_expiration` datetime DEFAULT NULL,
  `activation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loged_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nom`, `prenom`, `telephone`, `date_naissance`, `poste`, `etat`, `roles`, `inscription`, `role`, `forgotten_pass_token`, `forgotten_pass_expiration`, `activation_token`, `loged_at`, `status`) VALUES
(9, 'meriem@gmail.com', 'BVCdhQnST5y17DTS9XA4gx9phk8=', 'Laayouni', 'Meriem', '0612346578', '2020-06-12', 'test', 1, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', '2020-06-26', 'Administrateur', NULL, NULL, NULL, '2020-07-03 16:44:41', 1),
(24, 'haytham@gmail.com', 'jfu/BvRvZMl6SAMHJhya2fT3FjI=', 'Tannouch', 'Haytham', '0612346578', '2020-06-29', 'Devloppeur', 1, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', '2020-07-02', 'Administrateur', NULL, NULL, NULL, NULL, 1),
(25, 'wail@gmail.com', 'UNfpDZUJwd4A9afJAAyqz9cHMk4=', 'Amara', 'Wail', '0612346578', '2020-06-30', 'Devloppeur', 1, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', '2020-07-02', 'Administrateur', NULL, NULL, NULL, NULL, 1),
(26, 'badr@gmail.com', 'u/QhoHMECI38AylTaFnWGLhGuvs=', 'Tannouch', 'Badr', '0612346578', '2020-06-29', 'Directeur d\'Agence', 1, 'a:1:{i:0;s:9:\"ROLE_USER\";}', '2020-07-02', 'Editeur', NULL, NULL, NULL, NULL, 0),
(27, 'salma@gmail.com', 's7HyE5YwDOaGJ+Fv+HKpbw+6rF0=', 'Laayouni', 'Salma', '0612346578', '1996-02-01', 'Directeur d\'Agence', 1, 'a:1:{i:0;s:9:\"ROLE_USER\";}', '2020-07-02', 'Editeur', NULL, NULL, NULL, NULL, 1),
(28, 'Yazid@gmail.com', 'yKZDMo/0QRM5LXzo4njZ1Z7FC2g=', 'Amara', 'Yazid', '0613246578', '2020-06-30', 'Directeur d\'Agence', 1, 'a:1:{i:0;s:9:\"ROLE_USER\";}', '2020-07-02', 'Editeur', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

DROP TABLE IF EXISTS `villes`;
CREATE TABLE IF NOT EXISTS `villes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pays_id` int(11) NOT NULL,
  `nom_ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_19209FD8A6E44244` (`pays_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`id`, `pays_id`, `nom_ville`) VALUES
(1, 1, 'Oujda'),
(2, 2, 'Paris'),
(3, 1, 'berkane');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activites`
--
ALTER TABLE `activites`
  ADD CONSTRAINT `FK_766B5EB59917E4AB` FOREIGN KEY (`agences_id`) REFERENCES `agences` (`id`);

--
-- Contraintes pour la table `agences`
--
ALTER TABLE `agences`
  ADD CONSTRAINT `FK_B46015DDA6E44244` FOREIGN KEY (`pays_id`) REFERENCES `pays` (`id`),
  ADD CONSTRAINT `FK_B46015DDA73F0036` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`),
  ADD CONSTRAINT `FK_B46015DDFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `FK_D95DB16B98260155` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`);

--
-- Contraintes pour la table `regions`
--
ALTER TABLE `regions`
  ADD CONSTRAINT `FK_A26779F3F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Contraintes pour la table `sent`
--
ALTER TABLE `sent`
  ADD CONSTRAINT `FK_BAC42AA979F37AE5` FOREIGN KEY (`id_user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_BAC42AA9F8E92D5C` FOREIGN KEY (`id_email_id`) REFERENCES `email` (`id`);

--
-- Contraintes pour la table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `FK_E545A0C598DBDF9B` FOREIGN KEY (`fuseau_horaire_id`) REFERENCES `timezones` (`id`);

--
-- Contraintes pour la table `villes`
--
ALTER TABLE `villes`
  ADD CONSTRAINT `FK_19209FD8A6E44244` FOREIGN KEY (`pays_id`) REFERENCES `pays` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
