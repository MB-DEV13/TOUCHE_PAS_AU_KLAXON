<?php

require_once __DIR__ . '/../Core/Database.php';

/**
 * Modèle de gestion des trajets.
 *
 * Fournit toutes les méthodes CRUD et requêtes de consultation
 * pour les trajets dans l'application.
 */
class TrajetModel
{
    /**
     * Récupère la liste des trajets à venir avec des places disponibles
     *
     * @return array Liste des trajets (tableau associatif).
     */
    public static function getTrajetsDisponibles(): array
    {
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère la liste des trajets à venir avec informations sur le créateur.
     * (Pour l'utilisateur connecté ou admin.)
     *
     * @return array Liste des trajets enrichis (tableau associatif).
     */
    public static function getTrajetsDisponiblesAvecInfos(): array
    {
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère la liste de toutes les agences.
     *
     * @return array Tableau d'agences.
     */
    public static function getAgences(): array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT id_agence, nom FROM agence ORDER BY nom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un trajet à la base de données.
     *
     * @param int $id_createur     ID de l'utilisateur créateur.
     * @param int $id_depart       ID de l'agence de départ.
     * @param int $id_arrivee      ID de l'agence d'arrivée.
     * @param string $date_depart  Date et heure de départ (format Y-m-d H:i:s).
     * @param string $date_arrivee Date et heure d'arrivée (format Y-m-d H:i:s).
     * @param int $places          Nombre de places (total et dispo, même valeur à la création).
     * @return void
     */
    public static function ajouterTrajet(int $id_createur, int $id_depart, int $id_arrivee, string $date_depart, string $date_arrivee, int $places): void
    {
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
            $id_createur,
            $id_createur,
            $id_depart,
            $id_arrivee,
            $date_depart,
            $date_arrivee,
            $places,
            $places
        ]);
    }

    /**
     * Trouve un trajet par son ID.
     *
     * @param int $id  L'identifiant du trajet.
     * @return array|false Tableau associatif du trajet ou false si non trouvé.
     */
    public static function findById(int $id)
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM trajet WHERE id_trajet = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime un trajet par son identifiant.
     *
     * @param int $id  L'identifiant du trajet à supprimer.
     * @return void
     */
    public static function deleteTrajet(int $id): void
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM trajet WHERE id_trajet = ?");
        $stmt->execute([$id]);
    }

    /**
     * Met à jour un trajet (utilisé depuis la modale d'édition).
     *
     * @param int $id              Identifiant du trajet.
     * @param int $id_depart       ID agence départ.
     * @param int $id_arrivee      ID agence arrivée.
     * @param string $date_depart  Date et heure départ (Y-m-d H:i:s).
     * @param string $date_arrivee Date et heure arrivée (Y-m-d H:i:s).
     * @param int $places          Nombre de places (total/dispo remis à ce nombre).
     * @return void
     */
    public static function updateTrajet(int $id, int $id_depart, int $id_arrivee, string $date_depart, string $date_arrivee, int $places): void
    {
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
            $id_depart,
            $id_arrivee,
            $date_depart,
            $date_arrivee,
            $places,
            $places,
            $id
        ]);
    }
}




