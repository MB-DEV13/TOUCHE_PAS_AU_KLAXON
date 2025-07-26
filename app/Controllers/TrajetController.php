<?php
// app/Controllers/TrajetController.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Models/TrajetModel.php';

class TrajetController
{
    // Page des trajets pour un utilisateur connecté
    public function mesTrajets()
    {
        if (empty($_SESSION['user'])) {
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/login");
            exit;
        }
        $trajets = TrajetModel::getTrajetsDisponiblesAvecInfos(); // Méthode à adapter côté modèle
        require __DIR__ . '/../Views/trajets.php';
    }
}

