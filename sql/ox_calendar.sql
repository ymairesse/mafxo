-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 12 oct. 2022 à 22:44
-- Version du serveur : 10.6.7-MariaDB-2ubuntu1.1
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `oxfam`
--

-- --------------------------------------------------------

--
-- Structure de la table `ox_calendar`
--

CREATE TABLE `ox_calendar` (
  `date` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode` smallint(6) NOT NULL COMMENT 'Numéro de la période',
  `acronyme` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Utilisateur inscrit pour la période',
  `multi` smallint(6) NOT NULL DEFAULT 1 COMMENT 'Nombre de périodes acceptées',
  `dateInscription` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Date / heure / min /seconde d''inscription',
  `confirme` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Permanence confirmée'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ox_calendar`
--
ALTER TABLE `ox_calendar`
  ADD PRIMARY KEY (`date`,`periode`,`acronyme`),
  ADD KEY `date` (`date`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
