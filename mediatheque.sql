-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 11 mai 2023 à 15:32
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mediatheque`
--

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

CREATE TABLE `adherent` (
  `Id_adherent` int(11) NOT NULL,
  `Surname` varchar(150) NOT NULL,
  `Nom` varchar(100) DEFAULT NULL,
  `Prenom` varchar(100) DEFAULT NULL,
  `Telephone` varchar(100) DEFAULT NULL,
  `CIN` varchar(50) DEFAULT NULL,
  `Date_de_naissance` date DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Mot_de_passe` varchar(150) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `Nombre_de_pénalité` int(11) DEFAULT 0,
  `admin` tinyint(1) DEFAULT 0,
  `Date_de_creation` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `adherent`
--

INSERT INTO `adherent` (`Id_adherent`, `Surname`, `Nom`, `Prenom`, `Telephone`, `CIN`, `Date_de_naissance`, `Email`, `Mot_de_passe`, `type`, `Nombre_de_pénalité`, `admin`, `Date_de_creation`) VALUES
(5, 'Outhman', 'Moumou', 'Outhman', '770228867', 'kb206550', '1999-08-17', 'tangerino790_2011@live.fr', '$2y$10$UAct8I4TgSzA9Jfqn4sCeeep5ltrr8hwlJ/IYjVbkEUc.sCAwdBVm', 'Etudiant', 0, 1, '2023-04-26'),
(6, 'Hamid', 'achaou', 'hamid', '770028832', 'KB1234498', '1991-12-27', 'hamid@gmail.com', '$2y$10$vSgLfPQvH1nb/RaGukqxFej2PD78djXVnuPWdOXyXHWAQMjsIz6j2', 'Etudiant', 3, 0, '2023-04-26'),
(7, 'Soufiane', 'el kabdani', 'soufiane', '0678764564', 'KB56768', '1997-02-17', 'soufiane@gmail.com', '$2y$10$WS7EuSnfiLVxEwMWUJqbCu2cpzN6wpI6AVd81IJdXol8QdgdJZNte', 'Etudiant', 0, 1, '2023-05-11'),
(8, 'Said', 'alaoui', 'said', '0678658787', 'KB56768', '1990-05-12', 'said@gmail.com', '$2y$10$sfTpYTskWeYs7ZLaIHlYSuiB06MUSxdsrgG2FvFb7udR2XqjV.Mxe', 'Etudiant', 0, 0, '2023-05-11');

-- --------------------------------------------------------

--
-- Structure de la table `emprunt`
--

CREATE TABLE `emprunt` (
  `Id_emprunt` int(11) NOT NULL,
  `date_d_emprunt` timestamp NULL DEFAULT current_timestamp(),
  `date_de_retour` timestamp NULL DEFAULT NULL,
  `Id_ouvrage` int(11) NOT NULL,
  `Id_adherent` int(11) NOT NULL,
  `Id_reservation` int(11) NOT NULL,
  `Status` varchar(20) DEFAULT 'emprunté'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `emprunt`
--

INSERT INTO `emprunt` (`Id_emprunt`, `date_d_emprunt`, `date_de_retour`, `Id_ouvrage`, `Id_adherent`, `Id_reservation`, `Status`) VALUES
(18, '2023-04-02 06:39:20', '2023-05-09 15:59:58', 7, 6, 33, 'retourné'),
(19, '2023-04-03 07:00:48', '2023-05-09 16:01:20', 2, 6, 34, 'retourné'),
(20, '2023-04-09 07:00:49', '2023-05-09 16:01:19', 5, 6, 35, 'retourné');

-- --------------------------------------------------------

--
-- Structure de la table `ouvrage`
--

CREATE TABLE `ouvrage` (
  `Id_ouvrage` int(11) NOT NULL,
  `Titre` varchar(50) DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `Nom_d_auteur` varchar(100) DEFAULT NULL,
  `Image_de_couverture` varchar(100) DEFAULT NULL,
  `Etat` varchar(100) DEFAULT NULL,
  `Nombre_des_pages` int(11) NOT NULL,
  `Date_d_edition` date DEFAULT NULL,
  `Date_d_achat` date DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `ouvrage`
--

INSERT INTO `ouvrage` (`Id_ouvrage`, `Titre`, `Type`, `Nom_d_auteur`, `Image_de_couverture`, `Etat`, `Nombre_des_pages`, `Date_d_edition`, `Date_d_achat`, `Status`) VALUES
(1, 'The Nuclear Effect ', 'Livre', 'Scott Oldford', 'The Nuclear Effect.jpg', 'Neuf', 278, '2020-07-20', '2021-02-02', 'Disponible'),
(2, 'How to Start a Vending Machine Business', 'Livre', 'Walter Grant ', 'How to Start a Vending.jpg', 'Neuf', 162, '2022-06-27', '2022-07-28', 'Disponible'),
(3, 'How to Sell on Amazon for Beginners', 'Livre', 'Money Maker Publishing ', 'How to Sell on Amazon for Beginners.jpg', 'Neuf', 128, '2020-08-19', '2020-09-20', 'Disponible'),
(4, 'Rich Dad Poor Dad', 'Livre', ' Robert T. Kiyosaki ', 'Rich Dad Poor Dad.jpg', 'Neuf', 336, '2022-04-05', '2022-05-03', 'Disponible'),
(5, 'Physician Wealth Management Made Easy', 'Livre', 'Michael Zhuang', 'Physician Wealth Management Made Easy.jpg', 'Neuf', 216, '2017-11-06', '2018-01-01', 'Disponible'),
(6, 'Top 10 Ways to Avoid Taxes', 'Livre', 'Mark J Quann', 'Top 10 Ways to Avoid Taxes.jpg', 'Neuf', 150, '2018-10-20', '2018-11-01', 'Disponible'),
(7, 'Financial Freedom with Real Estate Investing', 'Livre', 'Michael Blank ', 'Financial Freedom with Real Estate Investing.jpg', 'Neuf', 257, '2018-07-16', '2018-08-19', 'Disponible'),
(8, 'YouTube for Real Estate Agents', 'Livre', 'Karin Carr', 'YouTube for Real Estate Agents.jpg', 'Neuf', 92, '2019-08-24', '2019-09-22', 'Disponible'),
(9, 'Sales Secrets', 'Livre', 'Brandon Bornancin', 'Sales Secrets.jpg', 'Neuf', 632, '2020-11-09', '2020-12-09', 'Disponible'),
(10, 'Seven Figure Social Selling', 'Livre', 'Brandon Bornancin ', 'Seven Figure Social Selling.jpg', 'Neuf', 502, '2020-04-17', '2020-05-18', 'Disponible');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `Id_reservation` int(11) NOT NULL,
  `date_de_reservation` timestamp NULL DEFAULT current_timestamp(),
  `date_d_expiration` timestamp NULL DEFAULT NULL,
  `Id_ouvrage` int(11) NOT NULL,
  `Id_adherent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`Id_reservation`, `date_de_reservation`, `date_d_expiration`, `Id_ouvrage`, `Id_adherent`) VALUES
(33, '2023-05-09 06:38:09', '2023-05-10 15:38:09', 7, 6),
(34, '2023-05-09 06:38:12', '2023-05-10 15:38:12', 2, 6),
(35, '2023-05-09 06:38:16', '2023-05-10 15:38:16', 5, 6);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adherent`
--
ALTER TABLE `adherent`
  ADD PRIMARY KEY (`Id_adherent`),
  ADD UNIQUE KEY `Surname` (`Surname`);

--
-- Index pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD PRIMARY KEY (`Id_emprunt`),
  ADD UNIQUE KEY `Id_reservation` (`Id_reservation`),
  ADD KEY `Id_ouvrage` (`Id_ouvrage`),
  ADD KEY `Id_adherent` (`Id_adherent`);

--
-- Index pour la table `ouvrage`
--
ALTER TABLE `ouvrage`
  ADD PRIMARY KEY (`Id_ouvrage`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`Id_reservation`),
  ADD KEY `Id_ouvrage` (`Id_ouvrage`),
  ADD KEY `Id_adherent` (`Id_adherent`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adherent`
--
ALTER TABLE `adherent`
  MODIFY `Id_adherent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `emprunt`
--
ALTER TABLE `emprunt`
  MODIFY `Id_emprunt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `ouvrage`
--
ALTER TABLE `ouvrage`
  MODIFY `Id_ouvrage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `Id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `emprunt_ibfk_1` FOREIGN KEY (`Id_ouvrage`) REFERENCES `ouvrage` (`Id_ouvrage`),
  ADD CONSTRAINT `emprunt_ibfk_2` FOREIGN KEY (`Id_adherent`) REFERENCES `adherent` (`Id_adherent`),
  ADD CONSTRAINT `emprunt_ibfk_3` FOREIGN KEY (`Id_reservation`) REFERENCES `reservation` (`Id_reservation`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`Id_ouvrage`) REFERENCES `ouvrage` (`Id_ouvrage`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`Id_adherent`) REFERENCES `adherent` (`Id_adherent`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
