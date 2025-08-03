<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Models/TrajetModel.php';

/**
 * Contrôleur de la page d'accueil (publique)
 */
class HomeController
{
    /**
     * Affiche la page d'accueil avec la liste des trajets disponibles.
     */
    public function index()
    {
        $trajets = TrajetModel::getTrajetsDisponibles();
        require __DIR__ . '/../Views/home.php';
    }
}


