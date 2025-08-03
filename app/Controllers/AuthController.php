<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Models/UserModel.php';

/**
 * Contrôleur d'authentification (connexion/déconnexion)
 */
class AuthController
{
    /**
     * Affiche le formulaire de connexion.
     * Redirige si déjà connecté.
     *
     * @param string $error Message d'erreur éventuel à afficher
     */
    public function loginForm($error = '')
    {
        if (!empty($_SESSION['user'])) {
            if ($_SESSION['user']['role'] === 'admin') {
                header("Location: /TOUCHE_PAS_AU_KLAXON/public/admin/dashboard");
            } else {
                header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
            }
            exit;
        }
        require __DIR__ . '/../Views/login.php';
    }

    /**
     * Traite la soumission du formulaire de connexion.
     *
     */
    public function login()
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $user = UserModel::findByEmail($_POST['email']);
            if ($user && password_verify($_POST['password'], $user['password'])) {
                // Connexion réussie
                $_SESSION['user'] = [
                    'id'     => $user['id_user'],
                    'nom'    => $user['nom'],
                    'prenom' => $user['prenom'],
                    'email'  => $user['email'],
                    'role'   => $user['role']
                ];
                // Redirection selon rôle
                if ($user['role'] === 'admin') {
                    header("Location: /TOUCHE_PAS_AU_KLAXON/public/admin/dashboard");
                } else {
                    header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
                }
                exit;
            } else {
                $this->loginForm("Identifiants invalides.");
            }
        } else {
            $this->loginForm("Merci de remplir tous les champs.");
        }
    }

    /**
     * Déconnecte l'utilisateur et redirige vers l'accueil.
     *
     * @return void
     */
    public function logout()
    {
        session_destroy();
        header("Location: /TOUCHE_PAS_AU_KLAXON/public/");
        exit;
    }
}
