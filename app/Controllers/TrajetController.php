<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Models/TrajetModel.php';

// Gestion des flash messages
if (!function_exists('set_flash_message')) {
    function set_flash_message($msg) {
        $_SESSION['flash_message'] = $msg;
    }
    function get_flash_message() {
        if (!empty($_SESSION['flash_message'])) {
            $msg = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $msg;
        }
        return null;
    }
}

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
        $agences = TrajetModel::getAgences(); // On passe la liste pour la modale edit
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
        set_flash_message("Le trajet a été créé avec succès.");
        header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
        exit;
    }

    // Suppression d'un trajet
    public function deleteTrajet($id)
    {
        if (empty($_SESSION['user'])) {
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/login");
            exit;
        }
        // Sécurité : doit être le créateur
        $trajet = TrajetModel::findById($id);
        if (!$trajet || $trajet['id_createur'] != $_SESSION['user']['id']) {
            set_flash_message("Suppression interdite.");
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
            exit;
        }
        TrajetModel::deleteTrajet($id);
        set_flash_message("Le trajet a été supprimé");
        header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
        exit;
    }

    // Edition d'un trajet en modal (POST depuis la modale)
    public function editTrajet($id)
    {
        if (empty($_SESSION['user'])) {
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/login");
            exit;
        }
        $trajet = TrajetModel::findById($id);
        if (!$trajet || $trajet['id_createur'] != $_SESSION['user']['id']) {
            set_flash_message("Modification interdite.");
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $depart      = $_POST['depart'] ?? '';
            $arrivee     = $_POST['arrivee'] ?? '';
            $date_depart = $_POST['date_depart'] ?? '';
            $heure_depart= $_POST['heure_depart'] ?? '';
            $date_arrivee= $_POST['date_arrivee'] ?? '';
            $heure_arrivee = $_POST['heure_arrivee'] ?? '';
            $places      = $_POST['places'] ?? '';

            if (
                empty($depart) || empty($arrivee) ||
                empty($date_depart) || empty($heure_depart) ||
                empty($date_arrivee) || empty($heure_arrivee) ||
                empty($places)
            ) {
                set_flash_message("Tous les champs sont obligatoires.");
                header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
                exit;
            }

            TrajetModel::updateTrajet(
                $id,
                $depart,
                $arrivee,
                $date_depart . ' ' . $heure_depart,
                $date_arrivee . ' ' . $heure_arrivee,
                $places
            );
            set_flash_message("Le trajet a été modifié avec succès.");
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
            exit;
        }
    }
}



