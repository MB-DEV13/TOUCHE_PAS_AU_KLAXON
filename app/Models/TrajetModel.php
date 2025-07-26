<?php
// app/Models/TrajetModel.php

require_once __DIR__ . '/../Core/Database.php';

class TrajetModel {
    /**
     * Liste des trajets à venir avec des places disponibles (pour page d'accueil publique)
     */
    public static function getTrajetsDisponibles() {
        $pdo = Database::getInstance();
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT 
                    ad.nom AS depart, 
                    t.date_heure_depart, 
                    aa.nom AS arrivee, 
                    t.date_heure_arrivee, 
                    t.nb_places_dispo
                FROM trajet t
                JOIN agence ad ON t.id_agence_depart = ad.id_agence
                JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                WHERE t.date_heure_depart > ? AND t.nb_places_dispo > 0
                ORDER BY t.date_heure_depart ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$now]);
        return $stmt->fetchAll();
    }

    /**
     * Liste des trajets à venir avec infos créateur (pour utilisateur connecté)
     */
    public static function getTrajetsDisponiblesAvecInfos() {
        $pdo = Database::getInstance();
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT 
                    t.id_trajet,
                    ad.nom AS depart, 
                    t.date_heure_depart AS date_depart,
                    aa.nom AS arrivee, 
                    t.date_heure_arrivee AS date_arrivee,
                    t.nb_places_dispo AS places_disponibles,
                    t.nb_places_total AS places_total,
                    t.id_createur,
                    u.nom AS nom_createur,
                    u.prenom AS prenom_createur,
                    u.telephone AS telephone_createur,
                    u.email AS email_createur
                FROM trajet t
                JOIN agence ad ON t.id_agence_depart = ad.id_agence
                JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                JOIN utilisateur u ON t.id_createur = u.id_user
                WHERE t.date_heure_depart > ? AND t.nb_places_dispo > 0
                ORDER BY t.date_heure_depart ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$now]);
        return $stmt->fetchAll();
    }
}

