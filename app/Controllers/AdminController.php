<?php

if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/AgenceModel.php';
require_once __DIR__ . '/../Models/TrajetModel.php';

// --- Gestion des flash messages ---
if (!function_exists('set_flash_message')) {
    /**
     * Définit un message flash.
     */
    function set_flash_message($msg) {
        $_SESSION['flash_message'] = $msg;
    }
    /**
     * Récupère le message flash (et le supprime).
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
 * Contrôleur administrateur - gère dashboard, agences, trajets
 */
class AdminController
{
    /**
     * Vérifie que l'utilisateur est admin, sinon redirige.
     */
    private function checkAdmin() {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/login");
            exit;
        }
    }

    /**
     * Affiche le tableau de bord admin
     */
    public function dashboard() {
        $this->checkAdmin();
        $users = UserModel::getAll();
        $agences = AgenceModel::getAll();
        $trajets = TrajetModel::getTrajetsDisponiblesAvecInfos();
        require __DIR__ . '/../Views/admin_dashboard.php';
    }

    /**
     * Crée une agence (POST)
     */
    public function createAgence() {
        $this->checkAdmin();
        $nom = trim($_POST['nom'] ?? '');
        if ($nom) {
            // Vérifie si la ville existe déjà
            $agences = AgenceModel::getAll();
            foreach ($agences as $agence) {
                if (strtolower($agence['nom']) === strtolower($nom)) {
                    set_flash_message("Erreur : cette agence existe déjà !");
                    header('Location: /TOUCHE_PAS_AU_KLAXON/public/admin/dashboard');
                    exit;
                }
            }
            AgenceModel::create($nom);
            set_flash_message("Agence créée !");
        }
        header('Location: /TOUCHE_PAS_AU_KLAXON/public/admin/dashboard');
        exit;
    }

    /**
     * Modifie une agence (POST)
     */
    public function updateAgence($id) {
        $this->checkAdmin();
        $nom = trim($_POST['nom'] ?? '');
        if ($id && $nom) {
            AgenceModel::update($id, $nom);
            set_flash_message("Agence modifiée !");
        }
        header('Location: /TOUCHE_PAS_AU_KLAXON/public/admin/dashboard');
        exit;
    }

    /**
     * Supprime une agence
     */
    public function deleteAgence($id) {
        $this->checkAdmin();
        if ($id) {
            $pdo = Database::getInstance();
            // Vérifie si cette agence est utilisée dans des trajets (départ ou arrivée)
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM trajet WHERE id_agence_depart = ? OR id_agence_arrivee = ?");
            $stmt->execute([$id, $id]);
            $nb = $stmt->fetchColumn();
            if ($nb > 0) {
                set_flash_message("Erreur : impossible de supprimer cette agence car elle est utilisée dans des trajets.");
            } else {
                AgenceModel::delete($id);
                set_flash_message("Agence supprimée !");
            }
        }
        header('Location: /TOUCHE_PAS_AU_KLAXON/public/admin/dashboard');
        exit;
    }

    /**
     * Supprime un trajet
     */
    public function deleteTrajet($id) {
        $this->checkAdmin();
        if ($id) {
            TrajetModel::deleteTrajet($id);
            set_flash_message("Trajet supprimé !");
        }
        header('Location: /TOUCHE_PAS_AU_KLAXON/public/admin/dashboard');
        exit;
    }

    /**
     * Modifie un trajet (POST depuis modale)
     */
    public function editTrajet($id) {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_depart = $_POST['depart'] ?? '';
            $id_arrivee = $_POST['arrivee'] ?? '';
            $date_depart = $_POST['date_depart'] ?? '';
            $heure_depart = $_POST['heure_depart'] ?? '';
            $date_arrivee = $_POST['date_arrivee'] ?? '';
            $heure_arrivee = $_POST['heure_arrivee'] ?? '';
            $places = $_POST['places'] ?? '';

            if (!$id_depart || !$id_arrivee || !$date_depart || !$heure_depart || !$date_arrivee || !$heure_arrivee || !$places) {
                set_flash_message("Tous les champs sont obligatoires.");
                header("Location: /TOUCHE_PAS_AU_KLAXON/public/admin/dashboard");
                exit;
            }

            TrajetModel::updateTrajet(
                $id,
                $id_depart,
                $id_arrivee,
                $date_depart . ' ' . $heure_depart,
                $date_arrivee . ' ' . $heure_arrivee,
                $places
            );
            set_flash_message("Le trajet a été modifié !");
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/admin/dashboard");
            exit;
        }
    }
}

