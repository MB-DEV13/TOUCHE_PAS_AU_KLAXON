<?php
// app/Models/TrajetModel.php

require_once __DIR__ . '/../Core/Database.php';

class TrajetModel {
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
}
