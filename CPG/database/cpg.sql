-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 12 jan. 2025 à 14:05
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cpg`
--

-- --------------------------------------------------------

--
-- Structure de la table `admine`
--

CREATE TABLE `admine` (
  `cin` varchar(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `fonction` varchar(100) DEFAULT NULL,
  `date_affectation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admine`
--

INSERT INTO `admine` (`cin`, `nom`, `mot_de_passe`, `mail`, `fonction`, `date_affectation`) VALUES
('A123456', 'Mohamed Ben Ali', 'hashed_password_123', 'mohamed.benali@example.com', 'Administrateur système', '2022-06-01'),
('A654321', 'Admin Test', 'admin123', 'admin.test@example.com', 'Administrateur', '2023-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `emploi_du_temps`
--

CREATE TABLE `emploi_du_temps` (
  `id` int(11) NOT NULL,
  `jour_semaine` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi') NOT NULL,
  `seance_1` time NOT NULL,
  `seance_2` time NOT NULL,
  `est_jour_ferie` tinyint(1) DEFAULT 0,
  `est_weekend` tinyint(1) DEFAULT 0,
  `jour_paiement` date DEFAULT NULL,
  `place_de_travail` varchar(100) DEFAULT NULL
) ;

--
-- Déchargement des données de la table `emploi_du_temps`
--

INSERT INTO `emploi_du_temps` (`id`, `jour_semaine`, `seance_1`, `seance_2`, `est_jour_ferie`, `est_weekend`, `jour_paiement`, `place_de_travail`) VALUES
(1, 'Lundi', '08:00:00', '13:00:00', 0, 1, '2023-10-31', 'Site principal - Gafsa'),
(2, 'Mardi', '08:00:00', '13:00:00', 0, 0, NULL, 'Site secondaire - Gafsa'),
(3, 'Mercredi', '09:00:00', '12:00:00', 0, 0, NULL, 'Site principal - Gafsa'),
(4, 'Jeudi', '10:00:00', '13:00:00', 0, 0, '2025-01-28', 'Site secondaire - Gafsa'),
(5, 'Vendredi', '08:00:00', '13:00:00', 0, 0, NULL, 'Site principal - Gafsa');

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `cin` varchar(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `poste` varchar(100) DEFAULT NULL,
  `salaire` decimal(10,2) DEFAULT NULL,
  `date_affection` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`cin`, `nom`, `mail`, `mot_de_passe`, `poste`, `salaire`, `date_affection`) VALUES
('', '', NULL, 'ali123', NULL, NULL, NULL),
('12345678', 'Ahmed Ali', 'ahmed.ali@example.com', 'ali123', 'Développeur', 5000.00, '2023-01-15'),
('178', 'azer azr', 'mohamed.ali@issetgafsa.tn', 'ali123', 'iset.com', 54782.00, '2025-01-08');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `cin` varchar(20) NOT NULL,
  `envoyeur` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `date_envoi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `cin`, `envoyeur`, `message`, `date_envoi`) VALUES
(1, '12345678', 'John Doe', 'Bonjour, ceci est un message de test.', '2025-01-10 16:56:48'),
(2, '178', 'Admin', 'dwdxgwx', '2025-01-11 20:06:49');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admine`
--
ALTER TABLE `admine`
  ADD PRIMARY KEY (`cin`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Index pour la table `emploi_du_temps`
--
ALTER TABLE `emploi_du_temps`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`cin`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cin` (`cin`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `emploi_du_temps`
--
ALTER TABLE `emploi_du_temps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`cin`) REFERENCES `employe` (`cin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
