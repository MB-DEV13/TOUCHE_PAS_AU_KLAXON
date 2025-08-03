-- Création base de données + structure complète

CREATE DATABASE IF NOT EXISTS `covoiturage` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `covoiturage`;

-- Table `agence`
CREATE TABLE `agence` (
  `id_agence` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id_agence`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table `utilisateur`
CREATE TABLE `utilisateur` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table `trajet`
CREATE TABLE `trajet` (
  `id_trajet` int(11) NOT NULL AUTO_INCREMENT,
  `id_agence_depart` int(11) NOT NULL,
  `id_agence_arrivee` int(11) NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `date_heure_arrivee` datetime NOT NULL,
  `nb_places_total` int(11) NOT NULL,
  `nb_places_dispo` int(11) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `id_createur` int(11) NOT NULL,
  PRIMARY KEY (`id_trajet`),
  KEY `id_agence_depart` (`id_agence_depart`),
  KEY `id_agence_arrivee` (`id_agence_arrivee`),
  KEY `id_contact` (`id_contact`),
  KEY `id_createur` (`id_createur`),
  CONSTRAINT `trajet_ibfk_1` FOREIGN KEY (`id_agence_depart`) REFERENCES `agence` (`id_agence`),
  CONSTRAINT `trajet_ibfk_2` FOREIGN KEY (`id_agence_arrivee`) REFERENCES `agence` (`id_agence`),
  CONSTRAINT `trajet_ibfk_3` FOREIGN KEY (`id_contact`) REFERENCES `utilisateur` (`id_user`),
  CONSTRAINT `trajet_ibfk_4` FOREIGN KEY (`id_createur`) REFERENCES `utilisateur` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

