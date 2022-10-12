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
-- Structure de la table `ox_passwd`
--

CREATE TABLE `ox_passwd` (
  `acronyme` varchar(7) NOT NULL COMMENT 'acronyme de l''utilisateur',
  `passwd` varchar(40) NOT NULL COMMENT 'Mot de passe crypté'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `ox_passwd`
--

INSERT INTO `ox_passwd` (`acronyme`, `passwd`) VALUES
('admadm', '25d55ad283aa400af464c76d713c07ad');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ox_passwd`
--
ALTER TABLE `ox_passwd`
  ADD PRIMARY KEY (`acronyme`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
