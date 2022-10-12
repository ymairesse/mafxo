-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 12 oct. 2022 à 22:41
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
-- Structure de la table `ox_periodes`
--

CREATE TABLE `ox_periodes` (
  `id` tinyint(4) NOT NULL COMMENT 'Identifiant du shift',
  `debut` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Début du shift',
  `fin` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Fin du shift'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ox_periodes`
--

INSERT INTO `ox_periodes` (`id`, `debut`, `fin`) VALUES
(0, '10h00', '12h30'),
(1, '12h30', '15h00'),
(2, '15h00', '18h00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ox_periodes`
--
ALTER TABLE `ox_periodes`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
