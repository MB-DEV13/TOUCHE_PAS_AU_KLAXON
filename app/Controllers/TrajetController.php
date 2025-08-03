<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Models/TrajetModel.php';

/**
 * Gestion des messages flash pour les retours utilisateur (succès/erreur).
 */
if (!function_exists('set_flash_message')) {
    /**
     * Définit un message flash à afficher à l'utilisateur.
     * @param string $msg
     */
    function set_flash_message($msg) {
        $_SESSION['flash_message'] = $msg;
    }

    /**
     * Récupère puis supprime le message flash courant.
     * @return string|null
     */
    function get_flash_message() {
        if (!empty($_SESSION['flash_message'])) {
            $msg = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $msg;
        }
        return null;
    }
}

/**
 * Contrôleur Trajet
 *
 * Gère l'affichage, la création, la modification et la suppression de trajets.
 */
class TrajetController
{
    /**
     * Affiche la liste des trajets à venir pour l'utilisateur connecté.
     * Redirige vers le login si non connecté.
     */
    public function mesTrajets()
    {
        if (empty($_SESSION['user'])) {
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/login");
            exit;
        }
        $trajets = TrajetModel::getTrajetsDisponiblesAvecInfos();
        $agences = TrajetModel::getAgences();
        require __DIR__ . '/../Views/trajets.php';
    }

    /**
     * Affiche le formulaire de création d'un trajet.
     */
    public function formCreerTrajet($error = '', $old = [])
    {
        if (empty($_SESSION['user'])) {
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/login");
            exit;
        }
        $agences = TrajetModel::getAgences();
        require __DIR__ . '/../Views/trajet_creer.php';
    }

    /**
     * Traite la soumission du formulaire de création d'un trajet.
     * Effectue les contrôles de cohérence.
     */
    public function creerTrajet()
    {
        if (empty($_SESSION['user'])) {
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/login");
            exit;
        }
        $agences = TrajetModel::getAgences();

        $data = [
            'depart'        => $_POST['depart'] ?? '',
            'arrivee'       => $_POST['arrivee'] ?? '',
            'date_depart'   => $_POST['date_depart'] ?? '',
            'heure_depart'  => $_POST['heure_depart'] ?? '',
            'date_arrivee'  => $_POST['date_arrivee'] ?? '',
            'heure_arrivee' => $_POST['heure_arrivee'] ?? '',
            'places'        => $_POST['places'] ?? ''
        ];

        // Contrôles des champs
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

        // Ajout en BDD
        TrajetModel::ajouterTrajet(
            $_SESSION['user']['id'],
            $data['depart'],
            $data['arrivee'],
            $data['date_depart'] . ' ' . $data['heure_depart'],
            $data['date_arrivee'] . ' ' . $data['heure_arrivee'],
            $data['places']
        );

        set_flash_message("Le trajet a été créé avec succès.");
        header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
        exit;
    }

    /**
     * Supprime un trajet (si l'utilisateur en est le créateur).
     */
    public function deleteTrajet($id)
    {
        if (empty($_SESSION['user'])) {
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/login");
            exit;
        }
        // Vérifie que l'utilisateur est le créateur du trajet
        $trajet = TrajetModel::findById($id);
        if (!$trajet || $trajet['id_createur'] != $_SESSION['user']['id']) {
            set_flash_message("Suppression interdite.");
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
            exit;
        }
        TrajetModel::deleteTrajet($id);
        set_flash_message("Le trajet a été supprimé.");
        header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
        exit;
    }

    /**
     * Édite un trajet (si l'utilisateur en est le créateur, depuis la modale).
     * @param int $id
     * @return void
     */
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
            $depart        = $_POST['depart'] ?? '';
            $arrivee       = $_POST['arrivee'] ?? '';
            $date_depart   = $_POST['date_depart'] ?? '';
            $heure_depart  = $_POST['heure_depart'] ?? '';
            $date_arrivee  = $_POST['date_arrivee'] ?? '';
            $heure_arrivee = $_POST['heure_arrivee'] ?? '';
            $places        = $_POST['places'] ?? '';

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

