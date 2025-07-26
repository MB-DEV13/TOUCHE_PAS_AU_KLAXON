<?php
// app/Controllers/AuthController.php

// Démarre la session proprement (évite les warnings si déjà active)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Models/UserModel.php';

class AuthController {
    /**
     * Affiche le formulaire de connexion.
     * Si déjà connecté, redirige vers l'accueil.
     */
    public function loginForm($error = '') {
        if (!empty($_SESSION['user'])) {
            header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");

            exit;
        }
        require __DIR__ . '/../Views/login.php';
    }

    /**
     * Gère la soumission du formulaire de connexion.
     */
    public function login() {
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
                header("Location: /TOUCHE_PAS_AU_KLAXON/public/trajets");
                exit;
            } else {
                $this->loginForm("Identifiants invalides.");
            }
        } else {
            $this->loginForm("Merci de remplir tous les champs.");
        }
    }

    /**
     * Déconnexion
     */
    public function logout() {
        session_destroy();
        header("Location: /TOUCHE_PAS_AU_KLAXON/public/");
        exit;
    }
}


