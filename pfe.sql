-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 16 juin 2018 à 15:51
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pfe`
--

-- --------------------------------------------------------

--
-- Structure de la table `abscence`
--

DROP TABLE IF EXISTS `abscence`;
CREATE TABLE IF NOT EXISTS `abscence` (
  `codeAb` int(11) NOT NULL AUTO_INCREMENT,
  `dateDAb` date NOT NULL,
  `CodeE` int(11) NOT NULL,
  `dateFAb` date DEFAULT NULL,
  PRIMARY KEY (`codeAb`),
  KEY `FK31` (`CodeE`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `abscence`
--

INSERT INTO `abscence` (`codeAb`, `dateDAb`, `CodeE`, `dateFAb`) VALUES
(4, '2018-05-09', 1, '2018-05-23');

-- --------------------------------------------------------

--
-- Structure de la table `conge`
--

DROP TABLE IF EXISTS `conge`;
CREATE TABLE IF NOT EXISTS `conge` (
  `codeCg` int(11) NOT NULL AUTO_INCREMENT,
  `dateDeb` date NOT NULL,
  `dateFin` date NOT NULL,
  `TYPE` int(11) DEFAULT NULL,
  `CodeE` int(11) NOT NULL,
  PRIMARY KEY (`codeCg`),
  KEY `FK32` (`CodeE`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `conge`
--

INSERT INTO `conge` (`codeCg`, `dateDeb`, `dateFin`, `TYPE`, `CodeE`) VALUES
(4, '2018-05-31', '2018-05-31', 1, 1),
(3, '2018-05-09', '2018-05-10', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `idEmploye` int(11) NOT NULL AUTO_INCREMENT,
  `NomFr` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NomAr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `PrenomFr` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PrenomAr` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `DateN` date NOT NULL,
  `LieuNFR` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LieuNAR` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `FonctionFr` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FonctionAr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `GradeFr` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `GradeAr` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `AdresseFR` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AdresseAr` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NumIdProf` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NumTel` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SitFam` int(11) DEFAULT NULL,
  `sexe` int(11) DEFAULT NULL,
  `SitAdm` int(11) DEFAULT NULL,
  `Echellon` int(11) DEFAULT NULL,
  `diplome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateDE` date DEFAULT NULL,
  `DateIN` date DEFAULT NULL,
  PRIMARY KEY (`idEmploye`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`idEmploye`, `NomFr`, `NomAr`, `PrenomFr`, `PrenomAr`, `DateN`, `LieuNFR`, `LieuNAR`, `FonctionFr`, `FonctionAr`, `GradeFr`, `GradeAr`, `AdresseFR`, `AdresseAr`, `NumIdProf`, `NumTel`, `SitFam`, `sexe`, `SitAdm`, `Echellon`, `diplome`, `DateDE`, `DateIN`) VALUES
(1, 'Ouadeh', 'واضح', 'mohamed', 'محمد', '1970-12-12', 'alger', 'الجزائر العاصمة', 'prof', 'أستاذ', 'MCA', 'أستاذ', 'rue 12 vila 45 beau-lieu, alger', 'شارع 12 فيلا 45 المكان الجميل، الجزائر', '02365995', '0555191217', 2, 1, 3, 13, 'دكتوراه', '2018-05-10', '2017-02-02'),
(2, 'hidour', 'حيدور', 'bahia', 'بهية', '1966-04-18', 'kouba', 'القبة', 'enseignante', 'أستاذة', 'MCB', 'أستاذ', 'cité 999/208 log bat F45 N10 ain naadja alger', 'حي 999 /208 مسكن عمارة ف 45 رقم 10 عين النعجة، الجزائر', '8945184615', '0551310093', 2, 2, 3, 10, 'دكتوراه', '2013-02-02', '2016-01-01'),
(3, 'saih', 'إكس', 'YYY', 'واي', '1984-11-11', 'hydra', 'حيدرة', 'YYYY', 'مجهولة', 'XXXX', 'إكس', 'dx<sfdcwsf', '[value-13]', '[value-14]', '[value-15]', 1, 1, 5, 0, 'باكالوريا', '2018-05-10', '2012-12-12'),
(15, 'BOUZID', 'بوزيد', 'Rachid', 'رشيد', '1990-03-08', 'Ain nadjaa', 'عين النعجة', 'C', 'كاتب', 'CA', 'كاتب رئيسي', '16 cité elmoutaouasit ain nadjaa, alger', '16 حي المتوسط عين النعجة، الجزائر', '8945184615', '0553152645', 1, 1, 1, 3, 'باكالوريا', '2014-06-10', '2014-06-10'),
(17, 'smaili', 'سمايلي', 'sqs', 'sqsqs', '1994-07-08', 'ssqsqs', 'sqsq', 'aaa', 'aaa', 'aaa', 'aa', 'aaa', 'aaaaaa', '02365995', '0555191217', 1, 1, 1, 3, 'aaa', '2018-06-01', '2018-05-31'),
(11, 'Sahraoui', 'صحراوي', 'sadek', 'صادق', '1978-05-09', 'Telemsen', 'تلمسان', 'derigeur', 'مسير', 'cadre', 'إطار', 'iojdsfopj', 'حتليبهخلس', '320541654', '0516464', 1, 1, 6, 3, 'ماجيستير', '2018-05-02', '2001-06-02'),
(16, 'Sahraoui', 'صحراوي', 'sadek', 'صادق', '1980-07-18', 'Tlemcen', 'تلمسان', 'fonction', 'وظيفة', 'grade', 'رتبة', 'Tlemcen', 'تلمسان', '587578', '0661253254', 1, 1, 2, 1, 'باكالوريا', '2018-05-31', '2018-05-28'),
(14, 'arifi', 'عريفي', 'muslim', 'مسلم', '1985-05-08', 'alger', 'الجزائر', 'qsdqs', 'dsqdsq', 'dsqdqs', 'dsqdqsd', 'dsq', 'dsqdqs', '024104', '0452345354', 1, 1, 7, 6, 'ليسانس', '2018-02-07', '1995-11-06');

-- --------------------------------------------------------

--
-- Structure de la table `fmarie`
--

DROP TABLE IF EXISTS `fmarie`;
CREATE TABLE IF NOT EXISTS `fmarie` (
  `idEmploye` int(11) NOT NULL,
  `NomM` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `NomMA` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`idEmploye`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fmarie`
--

INSERT INTO `fmarie` (`idEmploye`, `NomM`, `NomMA`) VALUES
(10, 'NJNJNJNJ', 'نجنجنج'),
(2, 'Lounis', 'لونيس'),
(4, 'NGFKGDM', 'لستكلىيسلjjjjj'),
(9, 'fsdfgsgd', 'ىمكلنىبيسل'),
(6, 'TOTOTO', 'توتوتو');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

DROP TABLE IF EXISTS `historique`;
CREATE TABLE IF NOT EXISTS `historique` (
  `CodeH` int(11) NOT NULL AUTO_INCREMENT,
  `Traitement` text CHARACTER SET utf8,
  `CodeU` int(11) DEFAULT NULL,
  `CodeE` int(11) DEFAULT NULL,
  `dateH` datetime DEFAULT NULL,
  PRIMARY KEY (`CodeH`),
  KEY `FK7` (`CodeU`),
  KEY `FK8` (`CodeE`)
) ENGINE=MyISAM AUTO_INCREMENT=325 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`CodeH`, `Traitement`, `CodeU`, `CodeE`, `dateH`) VALUES
(1, 'Modification des information d\'employé', 1, 1, '2018-05-02 00:00:00'),
(2, 'Modification des information d\'employé', 1, 3, '2018-05-13 12:53:54'),
(3, 'Modification des information d\'employé', 1, 8, '2018-05-13 12:56:37'),
(4, 'Modification des information d\'employé', 1, 3, '2018-05-14 09:53:48'),
(5, 'Modification des information d\'employé', 1, 1, '2018-05-14 16:05:03'),
(6, 'Modification des information d\'employé', 1, 9, '2018-05-14 22:46:53'),
(7, 'Modification des information d\'employé', 1, 1, '2018-05-16 22:35:01'),
(8, 'Modification des information d\'employé', 1, 1, '2018-05-18 00:17:17'),
(9, 'Modification des information d\'employé', 1, 1, '2018-05-19 21:09:31'),
(10, 'Modification des information d\'employé', 1, 3, '2018-05-22 17:49:47'),
(11, 'Modification des information d\'employé', 1, 11, '2018-05-22 17:53:47'),
(12, 'Modification des information d\'employé', 1, 2, '2018-05-22 17:54:21'),
(13, 'Modification des information d\'employé', 1, 14, '2018-05-22 17:55:25'),
(14, 'Modification des information d\'employé', 1, 1, '2018-05-26 15:06:09'),
(15, 'Modification des information d\'employé', 1, 2, '2018-05-26 18:44:12'),
(16, 'Impression d\'une Fiche de Notation', 1, 1, '2018-05-27 14:07:41'),
(17, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:48:45'),
(18, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:49:44'),
(19, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:50:46'),
(20, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:50:51'),
(21, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:53:41'),
(22, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:53:53'),
(23, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:54:09'),
(24, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:54:28'),
(25, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:54:46'),
(26, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:54:51'),
(27, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:55:17'),
(28, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:55:47'),
(29, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:55:57'),
(30, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:56:20'),
(31, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:56:49'),
(32, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:57:53'),
(33, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:58:05'),
(34, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:58:35'),
(35, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:58:46'),
(36, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:59:23'),
(37, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 14:59:54'),
(38, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 15:00:14'),
(39, 'Impression d\'une Mise en demeur', 1, 1, '2018-05-27 15:00:20'),
(40, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 16:57:06'),
(41, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 17:18:52'),
(42, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:00:02'),
(43, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:00:23'),
(44, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:02:36'),
(45, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:05:05'),
(46, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:05:17'),
(47, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:07:33'),
(48, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:10:35'),
(49, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:10:51'),
(50, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:12:36'),
(51, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:14:56'),
(52, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:16:28'),
(53, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:17:03'),
(54, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:17:29'),
(55, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:18:46'),
(56, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:42:53'),
(57, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:46:20'),
(58, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:46:30'),
(59, 'Impression d\'un Titre de Congé', 1, 1, '2018-05-27 18:47:43'),
(60, 'Impression d\'une Decision de suspension de rémunération', 1, 2, '2018-05-27 18:50:52'),
(61, 'Impression d\'une Decision de suspension de rémunération', 1, 1, '2018-05-27 20:24:13'),
(62, 'Effecuation d\'une abscence', 1, 1, '2018-05-27 20:24:14'),
(63, 'Impression d\'une Decision de suspension de rémunération', 1, 1, '2018-05-27 20:25:01'),
(64, 'Effecuation d\'une abscence', 1, 1, '2018-05-27 20:25:01'),
(65, 'Impression d\'une Decision de suspension de rémunération', 1, 1, '2018-05-27 20:25:44'),
(66, 'Effecuation d\'une abscence', 1, 1, '2018-05-27 20:25:44'),
(67, 'Impression d\'une Decision de suspension de rémunération', 1, 1, '2018-05-27 20:27:57'),
(68, 'Effecuation d\'une abscence', 1, 1, '2018-05-27 20:27:57'),
(69, 'Impression d\'une Decision de suspension de rémunération', 1, 1, '2018-05-27 20:28:03'),
(70, 'Effecuation d\'une abscence', 1, 1, '2018-05-27 20:28:03'),
(71, 'Impression d\'une Decision de suspension de rémunération', 1, 1, '2018-05-27 20:29:03'),
(72, 'Effecuation d\'une abscence', 1, 1, '2018-05-27 20:29:04'),
(73, 'Impression d\'une Decision de suspension de rémunération', 1, 1, '2018-05-27 20:29:06'),
(74, 'Effecuation d\'une abscence', 1, 1, '2018-05-27 20:29:06'),
(75, 'Impression d\'une Decision de suspension de rémunération', 1, 1, '2018-05-27 20:32:13'),
(76, 'Impression d\'une Decision de suspension de rémunération', 1, 1, '2018-05-27 20:32:16'),
(77, 'Etablissement d\'un PV de Reprise', 1, NULL, '2018-05-28 13:23:02'),
(78, 'Etablissement d\'une Attestation de Fonction', 1, 1, '2018-05-28 13:23:09'),
(79, 'Etablissement d\'une Attestation de Fonction', 1, 1, '2018-05-28 13:26:48'),
(80, 'Etablissement d\'une Attestation de Fonction', 1, 1, '2018-05-28 13:29:57'),
(81, 'Etablissement d\'une Attestation de Fonction', 1, 1, '2018-05-28 13:30:04'),
(82, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:30:50'),
(83, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:33:23'),
(84, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:34:26'),
(85, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:34:56'),
(86, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:35:35'),
(87, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:35:55'),
(88, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:37:17'),
(89, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:37:46'),
(90, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:38:03'),
(91, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:46:01'),
(92, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:46:37'),
(93, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:47:04'),
(94, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:47:35'),
(95, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:48:33'),
(96, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:56:59'),
(97, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 13:59:40'),
(98, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:01:02'),
(99, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:03:14'),
(100, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:03:26'),
(101, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:03:44'),
(102, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:04:01'),
(103, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:06:24'),
(104, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:08:05'),
(105, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:10:39'),
(106, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:11:39'),
(107, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:12:24'),
(108, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:12:58'),
(109, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:14:05'),
(110, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:14:09'),
(111, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:14:37'),
(112, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:15:04'),
(113, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:15:14'),
(114, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:15:35'),
(115, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:15:45'),
(116, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:16:41'),
(117, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:17:04'),
(118, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-28 14:17:24'),
(119, 'Etablissement d\'un PV de Reprise', 1, 1, '2018-05-28 14:21:20'),
(120, 'Etablissement d\'un PV de Reprise', 1, 1, '2018-05-28 14:22:26'),
(121, 'Etablissement d\'un PV de Reprise', 1, 1, '2018-05-28 14:23:30'),
(122, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:44:43'),
(123, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:45:30'),
(124, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:48:07'),
(125, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:50:55'),
(126, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:51:23'),
(127, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:51:55'),
(128, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:52:10'),
(129, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:52:21'),
(130, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:53:16'),
(131, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:53:56'),
(132, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:54:40'),
(133, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:54:49'),
(134, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:56:37'),
(135, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:57:04'),
(136, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:57:20'),
(137, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:57:34'),
(138, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:58:13'),
(139, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:58:35'),
(140, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:59:23'),
(141, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 14:59:40'),
(142, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-28 15:00:16'),
(143, 'Etablissement d\'un PV de Reprise du personnel enseignat', 1, 1, '2018-05-28 15:01:44'),
(144, 'Modification des information d\'employé', 1, 14, '2018-05-29 15:17:21'),
(145, 'Etablissement d\'une decision de Maternité', 1, 1, '2018-05-29 20:38:51'),
(146, 'Effecuation d\'un Congé de maladie', 1, 1, '2018-05-29 20:38:51'),
(147, 'Etablissement d\'une decision de Maternité', 1, 1, '2018-05-29 20:40:50'),
(148, 'Effecuation d\'un Congé de maladie', 1, 1, '2018-05-29 20:40:50'),
(149, 'Etablissement d\'une decision de Maternité', 1, 1, '2018-05-29 20:41:17'),
(150, 'Effecuation d\'un Congé de maladie', 1, 1, '2018-05-29 20:41:17'),
(151, 'Etablissement d\'une decision de Maternité', 1, 1, '2018-05-29 20:47:31'),
(152, 'Effecuation d\'un Congé de maladie', 1, 1, '2018-05-29 20:47:31'),
(153, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 20:54:28'),
(154, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 20:54:28'),
(155, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 20:55:41'),
(156, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 20:55:41'),
(157, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 20:57:23'),
(158, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 20:57:23'),
(159, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 20:58:13'),
(160, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 20:58:13'),
(161, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 20:58:32'),
(162, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 20:58:32'),
(163, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-29 20:59:11'),
(164, 'Effectuation d\'un Congé de maladie', 1, 1, '2018-05-29 20:59:11'),
(165, 'Etablissement d\'une decision de Maternité', 1, 2, '2018-05-29 21:00:24'),
(166, 'Effecuation d\'un Congé de maladie', 1, 2, '2018-05-29 21:00:24'),
(167, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 21:00:44'),
(168, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 21:00:44'),
(169, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 21:03:36'),
(170, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 21:03:36'),
(171, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 21:04:19'),
(172, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 21:04:19'),
(173, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 21:05:17'),
(174, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 21:05:17'),
(175, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 21:06:00'),
(176, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 21:06:00'),
(177, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 21:08:20'),
(178, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 21:08:20'),
(179, 'Etablissement d\'une decision de Maladie', 1, NULL, '2018-05-29 21:09:19'),
(180, 'Effectuation d\'un Congé de maladie', 1, NULL, '2018-05-29 21:09:19'),
(181, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 21:12:11'),
(182, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 21:12:11'),
(183, 'Etablissement d\'une decision de Maternité', 1, NULL, '2018-05-29 21:12:42'),
(184, 'Effecuation d\'un Congé de maladie', 1, NULL, '2018-05-29 21:12:42'),
(185, 'Etablissement d\'une Fiche de fin de Stage', 1, NULL, '2018-05-29 22:30:20'),
(186, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-29 22:34:54'),
(187, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-29 22:36:28'),
(188, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-29 22:36:41'),
(189, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-29 22:37:34'),
(190, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-29 22:42:39'),
(191, 'Etablissement d\'un Titre de Congé', 1, 2, '2018-05-30 13:46:12'),
(192, 'Etablissement d\'un Titre de Congé', 1, 2, '2018-05-30 13:48:19'),
(193, 'Etablissement d\'un Titre de Congé', 1, 2, '2018-05-30 13:49:25'),
(194, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 13:56:00'),
(195, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 13:56:09'),
(196, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 13:57:25'),
(197, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 13:57:53'),
(198, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 14:00:02'),
(199, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 14:01:19'),
(200, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 14:01:32'),
(201, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 14:02:41'),
(202, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 14:03:03'),
(203, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 14:03:28'),
(204, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 14:03:48'),
(205, 'Etablissement d\'un PV de Sortie', 1, 1, '2018-05-30 14:04:08'),
(206, 'Etablissement d\'une Attestation de Fonction', 1, 1, '2018-05-30 14:04:47'),
(207, 'Etablissement d\'une Attestation de Fonction', 1, 1, '2018-05-30 14:05:51'),
(208, 'Etablissement d\'une Fiche de Notation', 1, 1, '2018-05-30 14:06:14'),
(209, 'Etablissement d\'une Fiche de Notation', 1, 1, '2018-05-30 14:07:16'),
(210, 'Etablissement d\'une Mise en demeur', 1, 1, '2018-05-30 14:08:24'),
(211, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:08:50'),
(212, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:09:11'),
(213, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:09:18'),
(214, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:09:26'),
(215, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:09:40'),
(216, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:10:20'),
(217, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:10:29'),
(218, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:10:46'),
(219, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:11:19'),
(220, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:11:45'),
(221, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:12:05'),
(222, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:12:20'),
(223, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:13:10'),
(224, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:13:36'),
(225, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:13:49'),
(226, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:14:59'),
(227, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:15:17'),
(228, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:15:32'),
(229, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:15:57'),
(230, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:16:24'),
(231, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:20:15'),
(232, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:21:29'),
(233, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:21:46'),
(234, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:22:05'),
(235, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:22:20'),
(236, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:22:32'),
(237, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:23:23'),
(238, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:23:49'),
(239, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-05-30 14:23:59'),
(240, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:24:46'),
(241, 'Effectuation d\'un Congé de maladie', 1, 1, '2018-05-30 14:24:46'),
(242, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:26:52'),
(243, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:27:27'),
(244, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:27:33'),
(245, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:27:39'),
(246, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:27:48'),
(247, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:27:56'),
(248, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:28:06'),
(249, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:28:15'),
(250, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:28:28'),
(251, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:28:50'),
(252, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:29:06'),
(253, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:29:13'),
(254, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:29:26'),
(255, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:29:41'),
(256, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:29:47'),
(257, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:30:21'),
(258, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:30:26'),
(259, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:30:32'),
(260, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:30:38'),
(261, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:30:47'),
(262, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:31:07'),
(263, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:31:23'),
(264, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:32:09'),
(265, 'Etablissement d\'une decision de Maladie', 1, 1, '2018-05-30 14:33:03'),
(266, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-05-30 14:43:25'),
(267, 'Etablissement d\'une Decision de suspension de rémunération', 1, 1, '2018-05-30 17:07:11'),
(268, 'Etablissement d\'une Decision de suspension de rémunération', 1, 1, '2018-05-30 17:08:29'),
(269, 'Etablissement d\'une Decision de suspension de rémunération', 1, 1, '2018-05-30 17:09:08'),
(270, 'Etablissement d\'une Decision de suspension de rémunération', 1, 1, '2018-05-30 17:09:12'),
(271, 'Etablissement d\'une Decision de suspension de rémunération', 1, 1, '2018-05-30 17:09:16'),
(272, 'Etablissement d\'une Decision de suspension de rémunération', 1, 1, '2018-05-30 17:10:28'),
(273, 'Etablissement d\'un PV de Reprise', 1, 1, '2018-05-30 17:13:35'),
(274, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-05-30 17:16:01'),
(275, 'Modification des information d\'employé', 1, 1, '2018-05-30 17:49:33'),
(276, 'Modification des information d\'employé', 1, 1, '2018-05-30 17:50:59'),
(277, 'Etablissement d\'un PV de Sortie', 1, 3, '2018-05-30 17:59:09'),
(278, 'Etablissement d\'une Fiche de Notation', 1, 2, '2018-05-30 18:02:22'),
(279, 'Etablissement d\'une Fiche de Notation', 1, 1, '2018-05-30 18:02:33'),
(280, 'Modification des information d\'employé', 1, 1, '2018-05-30 18:05:47'),
(281, 'Modification des information d\'employé', 1, 11, '2018-05-30 18:06:23'),
(282, 'Modification des information d\'employé', 1, 14, '2018-05-30 18:06:35'),
(283, 'Modification du lieu de naissance d\'employé de الجزائر العاصمة à الجزائر العاصمة، الجزائر', 1, 1, '2018-06-02 16:02:39'),
(284, 'Modification de l\'addresse d\'employé de  à حي 999 /208 مسكن عمارة ف 45 رقم 10 عين النعجة، الجزائر', 1, 2, '2018-06-02 16:34:42'),
(285, 'Modification du diplome échelon d\'employé de  à دكتوراه', 1, 2, '2018-06-02 16:34:42'),
(286, 'Modification du nombre d\'enfants de  à دكتوراه', 1, 2, '2018-06-02 16:34:42'),
(287, 'Modification de l\'addresse d\'employé de  à حي 999 /208 مسكن عمارة ف 45 رقم 10 عين النعجة، الجزائر', 1, 2, '2018-06-02 16:35:22'),
(288, 'Modification du diplome d\'employé de  à دكتوراه', 1, 2, '2018-06-02 16:35:22'),
(289, 'Modification du nombre d\'enfants de  à دكتوراه', 1, 2, '2018-06-02 16:35:22'),
(290, 'Modification du nombre d\'enfants de دكتوراه à دكتوراه', 1, 2, '2018-06-02 16:38:36'),
(291, 'Modification du nombre d\'enfants de 8 à 7', 1, 1, '2018-06-02 18:18:04'),
(292, 'Modification de la situation administrative d\'employé de  à متعاقد', 1, 1, '2018-06-02 18:35:05'),
(293, 'Modification de la situation administrative d\'employé de متعاقد à مرسم', 1, 1, '2018-06-02 18:35:35'),
(294, 'Etablissement d\'une Attestation de Fonction', 1, 1, '2018-06-02 18:52:27'),
(295, 'Etablissement d\'une Fiche de fin de Stage', 1, 1, '2018-06-02 18:54:57'),
(296, 'Etablissement d\'une decision de Maladie', 1, NULL, '2018-06-04 01:30:09'),
(297, 'Effectuation d\'un Congé de maladie', 1, NULL, '2018-06-04 01:30:10'),
(298, 'Etablissement d\'une decision de Maladie', 1, NULL, '2018-06-04 01:30:27'),
(299, 'Effectuation d\'un Congé de maladie', 1, NULL, '2018-06-04 01:30:27'),
(300, 'Etablissement d\'une Attestation de Fonction', 1, 1, '2018-06-04 03:44:10'),
(301, 'Etablissement d\'une decision de Maladie', 1, NULL, '2018-06-04 03:47:07'),
(302, 'Effectuation d\'un Congé de maladie', 1, NULL, '2018-06-04 03:47:07'),
(303, 'Etablissement d\'une Fiche de Notation', 1, 1, '2018-06-04 03:47:33'),
(304, 'Etablissement d\'une Fiche de Notation', 1, 1, '2018-06-04 03:54:18'),
(305, 'Etablissement d\'une Fiche de fin de Stage', 1, 2, '2018-06-04 03:54:33'),
(306, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-06-04 03:54:56'),
(307, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-06-04 03:55:10'),
(308, 'Etablissement d\'un PV de Reprise du personnel enseignat', 1, 1, '2018-06-04 03:55:25'),
(309, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-06-04 03:55:33'),
(310, 'Etablissement d\'un PV d\'installation', 1, 1, '2018-06-04 03:55:39'),
(311, 'Etablissement d\'un PV d\'installation du personnel enseignat', 1, 1, '2018-06-04 03:56:46'),
(312, 'Modification du nom d\'employé de واضح à صحراوي', 1, 16, '2018-06-04 11:42:43'),
(313, 'Modification du prenom d\'employé de sihem à sadek', 1, 16, '2018-06-04 11:42:43'),
(314, 'Modification de la date de naissance d\'employé de 1997-07-18 à 1980-07-18', 1, 16, '2018-06-04 11:42:43'),
(315, 'Modification du lieu de naissance d\'employé de gdssoi à Tlemcen', 1, 16, '2018-06-04 11:42:43'),
(316, 'Modification du grade d\'employé de fsqdf à grade', 1, 16, '2018-06-04 11:42:43'),
(317, 'Modification du grade d\'employé de sfdfsd à رتبة', 1, 16, '2018-06-04 11:42:43'),
(318, 'Modification e l\'addresse d\'employé de fsgdhfg à Tlemcen', 1, 16, '2018-06-04 11:42:43'),
(319, 'Modification de l\'addresse d\'employé de gdsf à تلمسان', 1, 16, '2018-06-04 11:42:43'),
(320, 'Modification du N° de téléphone d\'employé de 58720875 à 0661253254', 1, 16, '2018-06-04 11:42:43'),
(321, 'Modification du nom d\'employé de szsq à سمايلي', 1, 17, '2018-06-04 14:04:51'),
(322, 'Etablissement d\'un Titre de Congé', 1, 1, '2018-06-04 14:05:20'),
(323, 'Etablissement d\'une decision de Maladie', 1, NULL, '2018-06-04 14:05:42'),
(324, 'Effectuation d\'un Congé de maladie', 1, NULL, '2018-06-04 14:05:42');

-- --------------------------------------------------------

--
-- Structure de la table `infos`
--

DROP TABLE IF EXISTS `infos`;
CREATE TABLE IF NOT EXISTS `infos` (
  `dateI` date NOT NULL,
  `info` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`dateI`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `infos`
--

INSERT INTO `infos` (`dateI`, `info`) VALUES
('2018-06-13', 'azertyuio');

-- --------------------------------------------------------

--
-- Structure de la table `marie`
--

DROP TABLE IF EXISTS `marie`;
CREATE TABLE IF NOT EXISTS `marie` (
  `idEmploye` int(11) NOT NULL,
  `nbrEnf` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEmploye`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `marie`
--

INSERT INTO `marie` (`idEmploye`, `nbrEnf`) VALUES
(10, 4),
(1, 7),
(2, 6),
(4, 1),
(8, 2),
(9, 3),
(6, 3),
(13, 3);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `codeU` int(11) NOT NULL AUTO_INCREMENT,
  `NomU` varchar(50) CHARACTER SET utf8 NOT NULL,
  `MotDePasse` varchar(100) CHARACTER SET utf8 NOT NULL,
  `Permission` int(11) NOT NULL,
  `Email` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`codeU`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`codeU`, `NomU`, `MotDePasse`, `Permission`, `Email`) VALUES
(1, 'admin', '$2y$10$4kNlHPc935z2WnUNdKoM9u3afLcLift7Z1.BiwcjiglmfAJvJavW.', 1, 'ous.1433@gmail.com'),
(2, 'user1', 'pw', 2, 'ous.1438@gmail.com'),
(8, 'e7c18a05ad707140167a798330e0e8a8', '$2y$10$ntwSmIEqyOnYWO2fN0LGn.n/xxVeTyekz9c3R5ETsNFlJ5IV1m5wO', 3, 'AAA@BBB.CCC'),
(9, 'Rbf66eed7655621b0493cf6a8979a054', '$2y$10$DwwPd9VwO1N/geFqneXdAeB6/qAXxJ2S7Kear2YEiSkoIvLize4xe', 3, 'zert@uuu.com'),
(10, 'i3e32a313bfa52cd3bd589935b375682', '$2y$10$WCMfMfTK3H9sWeEqrZwUzeWxJ8fPJSGTMNJG7gYLeWrUyj.PmZO2u', 3, 'A@B.c');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
