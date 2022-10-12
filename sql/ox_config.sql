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
-- Structure de la table `ox_config`
--

CREATE TABLE `ox_config` (
  `ordre` tinyint(4) DEFAULT NULL,
  `parametre` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `label` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Label',
  `size` smallint(6) DEFAULT NULL,
  `valeur` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `signification` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `domaine` enum('admin','bulletin','bullTQ') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `ox_config`
--

INSERT INTO `ox_config` (`ordre`, `parametre`, `label`, `size`, `valeur`, `signification`, `domaine`) VALUES
(2, 'NOMNOREPLY', 'Nom adresse No Reply', 30, 'Merci de ne pas \"répondre\"', 'Nom de l\'adresse pour la diffusion de mails \"no reply\"', NULL),
(1, 'NOREPLY', 'Ne pas répondre', 40, 'ne_pas_repondre@noMail.com', 'Adresse pour la diffusion de mails \"no reply\"', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ox_config`
--
ALTER TABLE `ox_config`
  ADD PRIMARY KEY (`parametre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
