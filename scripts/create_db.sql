-- Création de la base
CREATE DATABASE IF NOT EXISTS covoiturage CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE covoiturage;

-- Table agence
CREATE TABLE agence (
    id_agence INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) UNIQUE NOT NULL
);

-- Table utilisateur
CREATE TABLE utilisateur (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Table trajet
CREATE TABLE trajet (
    id_trajet INT PRIMARY KEY AUTO_INCREMENT,
    id_agence_depart INT NOT NULL,
    id_agence_arrivee INT NOT NULL,
    date_heure_depart DATETIME NOT NULL,
    date_heure_arrivee DATETIME NOT NULL,
    nb_places_total INT NOT NULL,
    nb_places_dispo INT NOT NULL,
    id_contact INT NOT NULL,
    id_createur INT NOT NULL,
    FOREIGN KEY (id_agence_depart) REFERENCES agence(id_agence),
    FOREIGN KEY (id_agence_arrivee) REFERENCES agence(id_agence),
    FOREIGN KEY (id_contact) REFERENCES utilisateur(id_user),
    FOREIGN KEY (id_createur) REFERENCES utilisateur(id_user)
);
