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
        $trajets = TrajetModel::getTrajetsDisponiblesAvecInfos();
        require __DIR__ . '/../Views/trajets.php';
    }

    // Affiche le formulaire de création de trajet
    public function formCreerTrajet($error = '', $old = [])
    {
        if (empty($_SESSION['user'])) {
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/login");
            exit;
        }
        $agences = TrajetModel::getAgences();
        require __DIR__ . '/../Views/trajet_creer.php';
    }

    // Traite le formulaire de création
    public function creerTrajet()
    {
        if (empty($_SESSION['user'])) {
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/login");
            exit;
        }
        $agences = TrajetModel::getAgences();

        $data = [
            'depart'      => $_POST['depart'] ?? '',
            'arrivee'     => $_POST['arrivee'] ?? '',
            'date_depart' => $_POST['date_depart'] ?? '',
            'heure_depart'=> $_POST['heure_depart'] ?? '',
            'date_arrivee'=> $_POST['date_arrivee'] ?? '',
            'heure_arrivee'=> $_POST['heure_arrivee'] ?? '',
            'places'      => $_POST['places'] ?? ''
        ];

        $error = '';
        if (
            empty($data['depart']) || empty($data['arrivee']) ||
            empty($data['date_depart']) || empty($data['heure_depart']) ||
            empty($data['date_arrivee']) || empty($data['heure_arrivee']) ||
            empty($data['places'])
        ) {
            $error = "Tous les champs sont obligatoires.";
        } elseif ($data['depart'] === $data['arrivee']) {
            $error = "L'agence de départ et d'arrivée doivent être différentes.";
        } elseif (strtotime($data['date_arrivee'] . ' ' . $data['heure_arrivee']) <= strtotime($data['date_depart'] . ' ' . $data['heure_depart'])) {
            $error = "L'arrivée doit être après le départ.";
        } elseif ($data['places'] < 1 || $data['places'] > 50) {
            $error = "Le nombre de places doit être entre 1 et 50.";
        }

        if ($error) {
            $this->formCreerTrajet($error, $data);
            return;
        }

        // Ajoute en base
        TrajetModel::ajouterTrajet(
            $_SESSION['user']['id'],
            $data['depart'],
            $data['arrivee'],
            $data['date_depart'] . ' ' . $data['heure_depart'],
            $data['date_arrivee'] . ' ' . $data['heure_arrivee'],
            $data['places']
        );

        // Redirige vers trajets
        header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
        exit;
    }
}
