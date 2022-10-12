-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 12 oct. 2022 à 22:43
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
-- Structure de la table `ox_conges`
--

CREATE TABLE `ox_conges` (
  `jour` tinyint(4) NOT NULL DEFAULT -1 COMMENT 'jour de la semaine (lundi => 1, mardi => 2,...)\r\n',
  `dateConge` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'date du congé',
  `periode` int(11) NOT NULL COMMENT 'Période de fermeture (0, 1 ou 2)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Congés';

--
-- Déchargement des données de la table `ox_conges`
--

INSERT INTO `ox_conges` (`jour`, `dateConge`, `periode`) VALUES
(-1, '', 1),
(-1, '', 2),
(-1, '--', 0),
(-1, '--', 1),
(-1, '2022-09-27', 1),
(-1, '2022-09-27', 2),
(-1, '2022-10-06', 0),
(1, '', 0),
(1, '', 1),
(1, '', 2),
(4, '', 0),
(7, '', 1),
(7, '', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ox_conges`
--
ALTER TABLE `ox_conges`
  ADD PRIMARY KEY (`jour`,`dateConge`,`periode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
