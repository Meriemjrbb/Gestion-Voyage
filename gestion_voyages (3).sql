-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 19 avr. 2025 à 01:07
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_voyages`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(3, 'Relaxant'),
(2, 'Culturel'),
(1, 'Aventure'),
(4, 'Croisière'),
(5, 'Nature'),
(6, 'City Break'),
(7, 'Safari'),
(8, 'Gastronomique'),
(9, 'Luxe'),
(10, 'Expédition');

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `voyage_id` int NOT NULL,
  `date_ajout` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `voyage_id` (`voyage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `favoris`
--

INSERT INTO `favoris` (`id`, `user_id`, `voyage_id`, `date_ajout`) VALUES
(16, 26, 8, '2024-09-07 15:00:00'),
(15, 27, 5, '2024-09-05 08:15:00'),
(14, 28, 2, '2024-09-01 13:30:00'),
(17, 29, 3, '2024-09-10 10:20:00'),
(18, 30, 9, '2024-09-12 17:45:00'),
(19, 31, 11, '2024-09-13 09:30:00'),
(20, 32, 12, '2024-09-15 12:00:00'),
(21, 33, 14, '2024-09-18 07:30:00'),
(22, 34, 15, '2024-09-20 18:00:00'),
(23, 35, 16, '2024-09-22 14:10:00'),
(24, 36, 17, '2024-09-24 08:40:00'),
(25, 37, 18, '2024-09-26 13:00:00'),
(26, 38, 19, '2024-09-28 15:30:00'),
(27, 39, 20, '2024-09-30 16:50:00'),
(28, 40, 21, '2024-10-02 12:20:00'),
(29, 41, 22, '2024-10-03 18:15:00'),
(30, 17, 23, '2024-10-05 09:45:00'),
(31, 18, 24, '2024-10-07 15:00:00'),
(34, 21, 6, '2024-10-15 08:30:00'),
(35, 22, 7, '2024-10-18 10:15:00'),
(36, 23, 10, '2024-10-20 17:00:00'),
(37, 24, 4, '2024-10-22 12:50:00'),
(38, 25, 13, '2024-10-25 16:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `voyage_id` int NOT NULL,
  `pourcentage_reduction` decimal(5,2) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `voyage_id` (`voyage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `promotions`
--

INSERT INTO `promotions` (`id`, `voyage_id`, `pourcentage_reduction`, `date_debut`, `date_fin`) VALUES
(15, 6, '12.50', '2024-11-01', '2024-11-10'),
(14, 5, '25.00', '2024-10-10', '2024-10-20'),
(13, 4, '5.00', '2024-10-01', '2024-10-05'),
(12, 3, '20.00', '2024-09-10', '2024-09-20'),
(11, 2, '15.50', '2024-09-05', '2024-09-15'),
(10, 1, '10.00', '2024-09-01', '2024-09-10'),
(16, 7, '18.00', '2024-11-05', '2024-11-15'),
(17, 8, '30.00', '2024-12-01', '2025-01-23'),
(18, 9, '8.00', '2024-12-05', '2024-12-15'),
(19, 10, '22.50', '2024-12-10', '2024-12-20'),
(20, 11, '14.00', '2024-09-15', '2024-09-25'),
(21, 12, '10.50', '2024-10-15', '2024-10-25'),
(22, 13, '17.00', '2024-11-15', '2024-11-25'),
(23, 14, '5.50', '2024-11-20', '2024-11-30'),
(24, 15, '20.50', '2024-12-15', '2024-12-25'),
(25, 16, '25.50', '2024-10-05', '2024-10-15'),
(26, 17, '30.00', '2024-09-20', '2024-09-30'),
(27, 18, '15.00', '2024-10-20', '2024-10-30'),
(28, 19, '10.00', '2024-11-10', '2024-11-20'),
(29, 20, '22.00', '2024-12-20', '2024-12-31');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `voyage_id` int NOT NULL,
  `nb_places_reserv` int NOT NULL,
  `statut` enum('en attente','confirmé','annulé') DEFAULT 'en attente',
  `date_reservation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `voyage_id` (`voyage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `voyage_id`, `nb_places_reserv`, `statut`, `date_reservation`) VALUES
(75, 12, 4, 1, 'confirmé', '2024-12-17 15:51:42'),
(74, 11, 14, 2, 'en attente', '2024-12-17 15:51:42'),
(73, 10, 8, 3, 'confirmé', '2024-12-17 15:51:42'),
(95, 20, 4, 2, 'confirmé', '2024-12-19 16:12:49'),
(94, 23, 12, 2, 'confirmé', '2024-12-19 09:27:22'),
(93, 10, 7, 5, 'en attente', '2024-12-17 15:51:42'),
(92, 9, 2, 2, 'confirmé', '2024-12-17 15:51:42'),
(91, 8, 15, 4, 'annulé', '2024-12-17 15:51:42'),
(90, 7, 10, 3, 'confirmé', '2024-12-17 15:51:42'),
(89, 6, 5, 2, 'en attente', '2024-12-17 15:51:42'),
(88, 25, 25, 1, 'confirmé', '2024-12-17 15:51:42'),
(87, 24, 24, 4, 'confirmé', '2024-12-17 15:51:42'),
(86, 23, 23, 3, 'confirmé', '2024-12-17 15:51:42'),
(85, 22, 16, 2, 'confirmé', '2024-12-17 15:51:42'),
(84, 21, 21, 4, 'confirmé', '2024-12-17 15:51:42'),
(99, 20, 2, 1, 'confirmé', '2024-12-20 09:46:18'),
(82, 19, 18, 3, 'annulé', '2024-12-17 15:51:42'),
(81, 18, 13, 2, 'confirmé', '2024-12-17 15:51:42'),
(80, 17, 1, 5, 'confirmé', '2024-12-17 15:51:42'),
(79, 16, 19, 4, 'confirmé', '2024-12-17 15:51:42'),
(103, 20, 20, 3, 'confirmé', '2024-12-21 12:22:05'),
(100, 20, 2, 1, 'annulé', '2024-12-20 09:46:27'),
(102, 20, 9, 2, 'en attente', '2024-12-21 12:06:23'),
(98, 20, 4, 2, 'en attente', '2024-12-20 09:24:23'),
(101, 20, 14, 2, 'en attente', '2024-12-20 10:03:34'),
(97, 20, 14, 2, 'en attente', '2024-12-20 07:05:36'),
(78, 15, 2, 1, 'en attente', '2024-12-17 15:51:42'),
(77, 14, 17, 2, 'annulé', '2024-12-17 15:51:42'),
(72, 9, 6, 4, 'annulé', '2024-12-17 15:51:42'),
(71, 8, 20, 2, 'confirmé', '2024-12-17 15:51:42'),
(70, 7, 9, 5, 'en attente', '2024-12-17 15:51:42'),
(69, 6, 3, 1, 'confirmé', '2024-12-17 15:51:42'),
(68, 5, 12, 2, 'confirmé', '2024-12-17 15:51:42'),
(67, 4, 7, 3, 'annulé', '2024-12-17 15:51:42'),
(76, 13, 11, 3, 'confirmé', '2024-12-17 15:51:42'),
(66, 3, 15, 1, 'confirmé', '2024-12-17 15:51:42'),
(65, 2, 10, 4, 'en attente', '2024-12-17 15:51:42'),
(64, 1, 5, 2, 'confirmé', '2024-12-17 15:51:42');

-- --------------------------------------------------------

--
-- Structure de la table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `testimonials`
--

INSERT INTO `testimonials` (`id`, `message`, `created_at`, `id_user`) VALUES
(26, 'La croisière était superbe, avec des arrêts magnifiques en Méditerranée.', '2024-12-17 15:49:48', 25),
(27, 'Nous avons adoré la diversité des activités proposées. Merci encore.', '2024-12-17 15:49:48', 26),
(25, 'Expérience décevante pour le prix payé. Quelques améliorations sont nécessaires.', '2024-12-17 15:49:48', 27),
(24, 'Notre séjour à Bali restera gravé dans nos mémoires. Merci pour tout !', '2024-12-17 15:49:48', 28),
(22, 'Je recommande vivement cette agence pour son sérieux et sa disponibilité.', '2024-12-17 15:49:48', 29),
(21, 'Voyage bien organisé, hôtel confortable et excellent rapport qualité/prix.', '2024-12-17 15:49:48', 30),
(19, 'Une organisation parfaite du début à la fin. Merci pour cette belle aventure !', '2024-12-17 15:49:48', 31),
(18, 'Le voyage était incroyable, mais le transport pourrait être amélioré.', '2024-12-17 15:49:48', 32),
(16, 'Des paysages magnifiques et des activités intéressantes, une expérience inoubliable.', '2024-12-17 15:49:48', 33),
(23, 'Les excursions étaient variées et bien planifiées. Un grand merci !', '2024-12-17 15:49:48', 34),
(20, 'J’ai adoré la destination et les guides étaient très professionnels.', '2024-12-17 15:49:48', 35),
(17, 'Je suis satisfait du service client, très réactif et à l\'écoute.', '2024-12-17 15:49:48', 36),
(15, 'Un excellent séjour, tout était parfaitement organisé. Je recommande cette agence !', '2024-12-17 15:49:48', 37),
(28, 'Voyage au Maroc très agréable, découverte de paysages sublimes.', '2024-12-17 15:49:48', 38),
(29, 'Un safari magique en Afrique du Sud, je recommande les yeux fermés.', '2024-12-17 15:49:48', 39),
(30, 'Très bonne organisation, mais l’hôtel n’était pas à la hauteur de nos attentes.', '2024-12-17 15:49:48', 40),
(31, 'Merci pour ce séjour à Tokyo, une ville fascinante et pleine de surprises.', '2024-12-17 15:49:48', 17),
(32, 'Nous avons été charmés par les plages de Thaïlande. Organisation parfaite.', '2024-12-17 15:49:48', 18),
(33, 'Notre séjour à Rome a été formidable, guides très compétents.', '2024-12-17 15:49:48', 19),
(34, 'Le circuit au Vietnam était bien structuré, guides sympathiques.', '2024-12-17 15:49:48', 20),
(35, 'Séjour en Islande exceptionnel, des paysages à couper le souffle.', '2024-12-17 15:49:48', 21),
(36, 'Un week-end à Barcelone très enrichissant. Service au top !', '2024-12-17 15:49:48', 22),
(37, 'Voyage en Grèce mémorable. Les îles sont paradisiaques.', '2024-12-17 15:49:48', 23),
(38, 'Organisation impeccable lors de notre circuit en Espagne. Merci à toute l’équipe.', '2024-12-17 15:49:48', 24),
(39, 'L’expérience en Norvège a dépassé toutes mes attentes. Je recommande fortement.', '2024-12-17 15:49:48', 25),
(40, 'Une aventure incroyable en Nouvelle-Zélande, merci pour tout.', '2024-12-17 15:49:48', 3),
(41, 'Séjour à New York exceptionnel, tout était conforme à nos attentes.', '2024-12-17 15:49:48', 5),
(42, 'Nous avons adoré notre circuit en Chine, des découvertes inoubliables.', '2024-12-17 15:49:48', 7),
(43, 'Le voyage au Canada était magique, une organisation parfaite du début à la fin.', '2024-12-17 15:49:48', 9),
(44, 'Expérience formidable au Portugal, une équipe très compétente.', '2024-12-17 15:49:48', 11);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `adresse` text,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('admin','utilisateur') DEFAULT 'utilisateur',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `email`, `telephone`, `adresse`, `mot_de_passe`, `role`, `date_creation`) VALUES
(17, 'Admin Principal', 'admin@voyage.com', '012345678', '123 Rue de l\'Admin, Paris', '$2y$10$8U/AXlYJwemqgZT22w2/Eubua8sARgCY0K7BH63hCstwfKt6/y7wi', 'admin', '2024-12-17 16:47:03'),
(18, 'Meriem Jribi', 'jribi.meriem@gmail.com', '0654321987', '45 Avenue des Champs, Lyon', '$2y$10$VNXWCCXB1NghSvO9f2SMmuxj2gdlGMhRgm6QiFBbCyJ6.U9cX1asq', 'admin', '2024-12-17 16:47:03'),
(20, 'Eya Safer', 'eya.safer@gmail.com', '06345278', '20 Rue du Soleil, Tunis', '$2y$10$FmRrJUqWR12k7sb8BOKfGeUrUrAawGnhURnEYNzdbkO5duxnz46Cm', 'utilisateur', '2024-12-17 16:47:03'),
(21, 'Aya Bouzomita', 'aya.bouzomita@hotmail.com', '0623459876', '12 Rue de la Paix, Marseille', '$2y$10$Ifs3Xh8ykTo4LcihB4/a5.exhBnos3JYkkczEuPF5qte2BKLKEkt.', 'utilisateur', '2024-12-17 16:47:03'),
(22, 'Takwa Jribi', 'takwa.jribi@gmail.com', '0789456123', '56 Calle Mayor, Madrid', '$2y$10$QFapbvUY7xtBOKDdt1lw5OhZT2GHEU7TYQGBU34kM8jrDOEHR4nxW', 'utilisateur', '2024-12-17 16:47:03'),
(23, 'Wajih Lagha', 'wajih.lagha@yahoo.com', '0701234567', '789 Baker Street, Londres', '$2y$10$28pVrzIHIDHuKyU4hi.keuJ6KgQid3xYIMtirffc9l9G0NZB/OTyW', 'utilisateur', '2024-12-17 16:47:03'),
(24, 'Ahmed Marzouk', 'ahmed.marzouk@gmail.com', '0634128756', '99 Avenue du Dragon, Pékin', '$2y$10$9CKcLNF5nFcyepynP/XI7e.xVYfCA6w2y6Rbljsx/i/9ccA28n6Hm', 'utilisateur', '2024-12-17 16:47:03'),
(25, 'Rihem Neji', 'rihem.neji@gmail.com', '0612345678', '10 Rue des Palmiers, Casablanca', '$2y$10$SXPbS2puz6ewKFdcxJ9bwuACJhyxWZEoJ5k8.Uvm2C3ZBPu2Vb6vC', 'utilisateur', '2024-12-17 16:47:03'),
(26, 'Farah Jradi', 'farah.jradi@hotmail.com', '0712345678', '34 Main Street, New York', '$2y$10$LTus3AGBqsKRBSCsttIKyOcYtVClr1yrumLyBXS3m.5SGzZp1wAc.', 'utilisateur', '2024-12-17 16:47:03'),
(27, 'Sara Ksouri', 'sara.ksouri@gmail.com', '0645789123', '77 Rue du Sakura, Séoul', '$2y$10$.7T4DwFHGxlP9Lp.SbBvzuqs6ukaP.gUiUAiH3GhYLKp2bymsUhJe', 'utilisateur', '2024-12-17 16:47:03'),
(28, 'Safwen Chrif', 'safwen.chrif@gmail.com', '0798412356', 'Via Dante 23, Rome', '$2y$10$oMPwgFEGGlWZvrJ1fJ7wNuhd9M4lb1cYRAC6TUwm.fz1u42UTv.r.', 'utilisateur', '2024-12-17 16:47:03'),
(29, 'Ahmed Khan', 'ahmed.khan@yahoo.com', '0732198456', '12 Rue Al-Qamar, Le Caire', '$2y$10$xLDgQoqTSaHRBIKy/7lrteZ8Tg7pu9UV5SGJUo6yThdCLuJval1RS', 'utilisateur', '2024-12-17 16:47:03'),
(30, 'Sirine Jribi', 'sirine.jribi@gmail.com', '0678901234', 'Av. Libertador 56, Buenos Aires', '$2y$10$l10HMLsc59iVuLFvvRWcrelZMiP3t8x6f/QDZIPgioRhMDAKpOTLW', 'utilisateur', '2024-12-17 16:47:03'),
(31, 'Najwa Marghli', 'najwa.marghli@hotmail.com', '0765432189', '11 Downing Street, Sydney', '$2y$10$UYsUISisl6y4E0DobZwzf.x4LFpUSwDaa7.dhrpHzl2R1g.dCgcqC', 'utilisateur', '2024-12-17 16:47:03'),
(32, 'Nadia El Amri', 'nadia.elamri@yahoo.com', '0609876543', '45 Rue des Palmiers, Tunis', '$2y$10$nedoIpOtUYbLovKOf5ENTOx2xXJ9YcF/T/Mhw74DI0ICIhXEjRJW2', 'utilisateur', '2024-12-17 16:47:03'),
(33, 'Youssef Haddad', 'youssef.haddad@gmail.com', '0745123789', 'Boulevard Mohammed V, Rabat', '$2y$10$uqaDncZiPQNS86hOMaGjTutGR.ODhVP76auFsqMhMDFR9sq2Mo8da', 'utilisateur', '2024-12-17 16:47:03'),
(34, 'Yassmine Nasri', 'yassmine.nasri@gmail.com', '0687456123', '56 Strasse der Freiheit, Berlin', '$2y$10$aJY4rXutBXRNrtuE8skrUe8/1ttWBmaz4NgO6UQs5ZyT0ccmrvA4m', 'utilisateur', '2024-12-17 16:47:03'),
(35, 'Yassine Zahi', 'yassine.zahi@yahoo.com', '0701234897', '88 Shibuya, Tokyo', '$2y$10$CmjUn4qJdrPyiIStflraz.syR5kl9sTKm44blDJXG0Sygj7ru/Gk6', 'utilisateur', '2024-12-17 16:47:03'),
(36, 'Yosra Hertelli', 'yosra.hertelli@gmail.com', '0657891234', 'Nevsky Prospekt, Saint-Pétersbourg', '$2y$10$d35GwuN0OdU29MMh2N2r4eKPnhADA.qzaXnXyyUxrNbAZjrFuHjjC', 'utilisateur', '2024-12-17 16:47:03'),
(37, 'Aziz Zahi', 'aziz.zahi@gmail.com', '0623456789', '234 King Street, Toronto', '$2y$10$1l/i7fRwzslQNq.0tnkEZeIUUu27uLKte/XJjYig7O3bWiyEwRKpq', 'utilisateur', '2024-12-17 16:47:03'),
(38, 'Hani Ben dhaou', 'hani.bendhaou@hotmail.com', '0612789456', 'Rue Habib Bourguiba, Tunis', '$2y$10$SJS.JHJuID2D6zfggN4hlu8IPx4y8tOGJ.W/gXpQmTCd9PKe9KqUi', 'utilisateur', '2024-12-17 16:47:03'),
(39, 'Amine Chrif', 'amine.chrif@gmail.com', '0789456123', 'Rua de Lisboa 34, Lisbonne', '$2y$10$JezvIJJkY8vwTznubyCQKOUTeRiuCK/prjCO./mHmkR/mwphcHqNq', 'utilisateur', '2024-12-17 16:47:03'),
(41, 'Fatma Ben Rjeb', 'fatma.benrjeb@hotmail.com', '0634567891', 'Al Hamra Street, Dubaï', '$2y$10$1QHeIJ/wEXXaQ0PaduKYpO3S.mepdcuCfkOXzCcS/RRBHkW69cCry', 'utilisateur', '2024-12-17 16:47:03'),
(42, 'Hajer Yahia', 'hajer.yahia@isimg.tn', '84893920', 'Sfax', '$2y$10$DlNDCsumP7V3shMXKh2ftOoYll35.EZzRrQOUxhjYCgopaOQkDrMe', 'utilisateur', '2024-12-19 20:30:41');

-- --------------------------------------------------------

--
-- Structure de la table `voyages`
--

DROP TABLE IF EXISTS `voyages`;
CREATE TABLE IF NOT EXISTS `voyages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `date_depart` date NOT NULL,
  `duree` int NOT NULL,
  `places_disponibles` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `categorie_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categorie` (`categorie_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `voyages`
--

INSERT INTO `voyages` (`id`, `titre`, `description`, `prix`, `date_depart`, `duree`, `places_disponibles`, `image`, `categorie_id`) VALUES
(5, 'Croisière en Méditerranée', 'Une croisière de luxe avec plusieurs arrêts dans des villes côtières.', '3000.00', '2024-12-05', 12, 80, 'croisiere.jpg', 4),
(4, 'Aventure au Maroc', 'Partez à Marrakech et vivez une aventure dans le désert marocain.', '1000.00', '2024-08-25', 6, 74, 'maroc.jpg', 5),
(3, 'Vacances à Bali', 'Profitez des plages paradisiaques de Bali pour un séjour relaxant.', '2500.00', '2024-11-10', 10, 80, 'bali.jpg', 3),
(2, 'Séjour à Rome', 'Explorez l\'Italie antique avec des excursions culturelles et gastronomiques.', '1500.00', '2024-10-01', 5, 78, 'rome.jpg', 2),
(1, 'Voyage à Paris', 'Découvrez la ville lumière et ses monuments emblématiques.', '1200.00', '2024-09-15', 7, 80, 'paris.jpg', 2),
(6, 'Escapade à Tokyo', 'Découvrez la culture japonaise moderne et traditionnelle à Tokyo.', '2800.00', '2024-09-20', 8, 80, 'tokyo.jpg', 2),
(7, 'Séjour à New York', 'Visitez la ville qui ne dort jamais avec ses célèbres gratte-ciel.', '3200.00', '2024-10-15', 5, 80, 'newyork.jpg', 6),
(8, 'Circuit en Thaïlande', 'Explorez les temples, plages et marchés flottants de Thaïlande.', '2000.00', '2024-11-01', 9, 80, 'thailande.jpg', 5),
(9, 'Découverte de l\'Australie', 'Partez en aventure dans les grandes villes et l\'outback australien.', '3500.00', '2024-12-01', 15, 78, 'australie.jpg', 1),
(10, 'Safari en Afrique du Sud', 'Observez la faune sauvage lors d\'un safari inoubliable.', '2800.00', '2024-09-10', 10, 80, 'safari.jpg', 7),
(11, 'Voyage en Grèce', 'Découvrez Athènes et les îles grecques avec leurs paysages uniques.', '1500.00', '2024-08-12', 7, 80, 'grece.jpg', 2),
(12, 'Expédition en Islande', 'Explorez les volcans, glaciers et geysers d\'Islande.', '4000.00', '2024-10-20', 6, 78, 'islande.jpg', 10),
(13, 'Séjour en Égypte', 'Visitez les pyramides et les temples anciens.', '1800.00', '2024-09-05', 8, 80, 'egypte.jpg', 2),
(14, 'Week-end à Barcelone', 'Découvrez l\'art et l\'architecture de Barcelone.', '950.00', '2024-08-30', 4, 76, 'barcelone.jpg', 6),
(15, 'Circuit au Vietnam', 'Explorez le Vietnam du nord au sud avec ses paysages variés.', '2200.00', '2024-11-15', 12, 80, 'vietnam.jpg', 5),
(16, 'Séjour à Istanbul', 'Vivez une expérience unique entre Europe et Asie.', '1300.00', '2024-10-05', 6, 80, 'istanbul.jpg', 26),
(17, 'Visite de Londres', 'Explorez les monuments et musées de Londres.', '1400.00', '2024-09-25', 5, 80, 'londres.jpg', 6),
(18, 'Aventure au Pérou', 'Partez à la découverte du Machu Picchu et de la culture Inca.', '2900.00', '2024-11-01', 10, 80, 'perou.jpg', 1),
(19, 'Découverte du Canada', 'Explorez les villes et les grands espaces du Canada.', '3300.00', '2024-10-15', 14, 80, 'canada.jpg', 5),
(20, 'Circuit en Espagne', 'Visitez Madrid, Séville et les belles côtes espagnoles.', '1800.00', '2024-08-28', 8, 77, 'espagne.jpg', 2),
(21, 'Voyage en Suisse', 'Découvrez les montagnes et lacs suisses.', '2500.00', '2024-09-18', 7, 80, 'suisse.jpg', 5),
(22, 'Tour du Japon', 'Circuit complet des villes principales du Japon.', '3200.00', '2024-11-12', 10, 80, 'japon.jpg', 2),
(23, 'Croisière aux Caraïbes', 'Une croisière tout inclus dans les îles paradisiaques.', '4000.00', '2024-12-10', 14, 80, 'caraibes.jpg', 43),
(24, 'Séjour en Tunisie', 'Profitez des plages et des médinas de Tunisie.', '900.00', '2024-08-05', 6, 80, 'tunisie.jpg', 3),
(25, 'Visite des Pays-Bas', 'Découvrez Amsterdam et les champs de tulipes.', '1600.00', '2024-09-12', 5, 80, 'paysbas.jpg', 2),
(26, 'Escapade en Belgique', 'Explorez Bruxelles et Bruges, ses villes pittoresques.', '1200.00', '2024-10-08', 4, 80, 'belgique.jpg', NULL),
(27, 'Voyage en Irlande', 'Découvrez les paysages verdoyants et la culture irlandaise.', '2000.00', '2024-11-03', 9, 80, 'irlande.jpg', NULL),
(28, 'Aventure en Chine', 'Circuit incluant Pékin, Shanghai et la Grande Muraille.', '3100.00', '2024-10-30', 12, 80, 'chine.jpg', NULL),
(29, 'Visite du Portugal', 'Explorez Lisbonne, Porto et les côtes atlantiques.', '1700.00', '2024-09-08', 7, 80, 'portugal.jpg', NULL),
(30, 'Séjour au Mexique', 'Profitez des plages et des sites archéologiques du Mexique.', '2600.00', '2024-11-20', 10, 80, 'mexique.jpg', NULL),
(31, 'Découverte de la Russie', 'Visitez Moscou et Saint-Pétersbourg.', '2800.00', '2024-12-01', 8, 80, 'russie.jpg', NULL),
(32, 'Voyage en Corée du Sud', 'Découvrez Séoul et les traditions coréennes.', '2700.00', '2024-11-05', 9, 80, 'coree.jpg', NULL),
(34, 'Séjour en Norvège', 'Explorez les fjords et paysages naturels norvégiens.', '3500.00', '2024-12-15', 8, 80, 'norvege.jpg', NULL),
(35, 'Aventure en Nouvelle-Zélande', 'Partez à l\'exploration des deux îles.', '4000.00', '2024-11-25', 15, 80, 'nz.jpg', NULL),
(36, 'Voyage à Dubai', 'Découvrez le luxe et les attractions modernes de Dubai.', '2200.00', '2024-10-10', 5, 80, 'dubai.jpg', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
