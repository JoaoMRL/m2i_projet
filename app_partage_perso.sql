-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 14 mars 2024 à 05:46
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `app_partage_perso`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

DROP TABLE IF EXISTS `annonces`;
CREATE TABLE IF NOT EXISTS `annonces` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `owner` int NOT NULL,
  `idObjet` int NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `OwnerId` (`owner`),
  KEY `idObjet` (`idObjet`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`id`, `name`, `type`, `msg`, `owner`, `idObjet`, `status`) VALUES
(1, 'Une bonne Perceuse', 'Outils', 'Loue une bonne perceuse qui vous sera utile si vous l utiliser', 2, 1, 'Disponible');

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

DROP TABLE IF EXISTS `emprunts`;
CREATE TABLE IF NOT EXISTS `emprunts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `msgEmprunts` varchar(255) NOT NULL,
  `idAnnonces` int NOT NULL,
  `borrower` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `borrower` (`borrower`) USING BTREE,
  KEY `idAnnonces` (`idAnnonces`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `emprunts`
--

INSERT INTO `emprunts` (`id`, `status`, `dateDebut`, `dateFin`, `msgEmprunts`, `idAnnonces`, `borrower`) VALUES
(4, 'En cours', '2024-02-26', '2024-02-26', 'Je souhaite vous emprunter votre magnifique perceuse', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `objets`
--

DROP TABLE IF EXISTS `objets`;
CREATE TABLE IF NOT EXISTS `objets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `owner` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `OwnerId` (`owner`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `objets`
--

INSERT INTO `objets` (`id`, `name`, `description`, `owner`, `image`) VALUES
(1, 'Perceuse', 'Bonne Perceuse', 2, ''),
(4, '[value-2]', '[value-3]', 2, '[value-5]');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `phoneNumber` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `firstName`, `address`, `email`, `password`, `role`, `phoneNumber`, `avatar`) VALUES
(2, 'Leite', 'Joao', 'Rue des potiers', 'joao@gmail.com', '$2y$13$bz8c/2QNN9QWkJBQuf6fYui2prcTKviHSO04nXyPUK89F54V9sYXm', 'ROLE_USER', '', ''),
(3, 'Toto', 'Test', 'Rue des potiers', 'marco@gmail.com', '$2y$13$yqFTErZXqiK8lWn6ll660e7EStzaOE3YmyWc1adSz5U6c6ZjtgGsq', 'ROLE_USER', '', ''),
(4, 'Testtt', 'ara', '3 rue des charlatant', 'test@test.ts', '$2y$13$Mg5N9qVpRIcHB0ArykzEseVedNIZ2V5gQC5Wp6eVW2rCKwZDUOPXi', 'ROLE_USER', NULL, NULL),
(5, 'Testtt', 'ara', '3 rue des charlatant', 'test@teset.ts', '$2y$13$cawj6r3Oan1gN.UP3MLBQ.i6aDR8lBcg9jHzJuXgGBKQ64KK3jy9i', 'ROLE_USER', NULL, NULL),
(6, 'Testtt', 'ara', '3 rue des charlatant', 'test@tesezzt.ts', '$2y$13$3MNs1wWnD7Jc7/MUVU04V.w7OjE2G8A2HlqNfGDeAV3utoYRiPm5G', 'ROLE_USER', NULL, NULL),
(7, 'Test', 'Test', '', 'test@teazest.test', '$2y$13$XawJJv0E3ZlGm9eVZCQ35eeUKDuQ24.wNLjPy4fUtjTFzE3zYoH1.', 'ROLE_USER', '', ''),
(8, 'Test', 'Test', '', 'test@teadzest.test', '$2y$13$j7aYNdcQxF2ZV2sNeVGD4ehDnp8zN37DZCMG0ut7pf9apIDnrbKJG', 'ROLE_USER', '', '');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD CONSTRAINT `annonces_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `annonces_ibfk_2` FOREIGN KEY (`idObjet`) REFERENCES `objets` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD CONSTRAINT `emprunts_ibfk_1` FOREIGN KEY (`borrower`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `emprunts_ibfk_3` FOREIGN KEY (`idAnnonces`) REFERENCES `annonces` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `objets`
--
ALTER TABLE `objets`
  ADD CONSTRAINT `objets_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
