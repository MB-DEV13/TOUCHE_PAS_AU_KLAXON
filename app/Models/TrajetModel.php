<?php
require_once __DIR__ . '/../Core/Database.php';

class TrajetModel {
    // Liste des trajets à venir avec des places disponibles (pour page d'accueil publique)
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

    // Liste des trajets à venir avec infos créateur (pour utilisateur connecté)
    public static function getTrajetsDisponiblesAvecInfos() {
        $pdo = Database::getInstance();
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT 
                    t.id_trajet,
                    ad.id_agence AS id_agence_depart,
                    ad.nom AS depart, 
                    t.date_heure_depart AS date_depart,
                    aa.id_agence AS id_agence_arrivee,
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

    // Liste des agences
    public static function getAgences() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT id_agence, nom FROM agence ORDER BY nom ASC");
        return $stmt->fetchAll();
    }

    // Ajouter un trajet en BDD
    public static function ajouterTrajet($id_createur, $id_depart, $id_arrivee, $date_depart, $date_arrivee, $places) {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO trajet (
                    id_createur, 
                    id_contact, 
                    id_agence_depart, 
                    id_agence_arrivee, 
                    date_heure_depart, 
                    date_heure_arrivee, 
                    nb_places_total, 
                    nb_places_dispo
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $id_createur,   // id_createur
            $id_createur,   // id_contact (même valeur que créateur)
            $id_depart,
            $id_arrivee,
            $date_depart,
            $date_arrivee,
            $places, // total
            $places  // dispo
        ]);
    }

    // Trouver un trajet par ID
    public static function findById($id)
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM trajet WHERE id_trajet = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Supprimer un trajet
    public static function deleteTrajet($id)
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM trajet WHERE id_trajet = ?");
        $stmt->execute([$id]);
    }

    // Mettre à jour un trajet (pour la modale édition)
    public static function updateTrajet($id, $id_depart, $id_arrivee, $date_depart, $date_arrivee, $places) {
        $pdo = Database::getInstance();
        $sql = "UPDATE trajet SET 
                id_agence_depart = ?, 
                id_agence_arrivee = ?, 
                date_heure_depart = ?, 
                date_heure_arrivee = ?, 
                nb_places_total = ?, 
                nb_places_dispo = ?
            WHERE id_trajet = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $id_depart,   // id_agence_depart
            $id_arrivee,  // id_agence_arrivee
            $date_depart,
            $date_arrivee,
            $places,
            $places, // reset places dispo = total
            $id
        ]);
    }
}



