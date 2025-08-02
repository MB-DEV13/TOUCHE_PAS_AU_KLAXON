<?php
// app/Models/UserModel.php

require_once __DIR__ . '/../Core/Database.php';

class UserModel {
    /**
     * Trouver un utilisateur par email.
     */
    public static function findByEmail($email) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Important : fetch en tableau associatif
    }

    /**
     * Récupérer tous les utilisateurs (pour admin/dashboard)
     */
    public static function getAll() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT id_user, nom, prenom, email, telephone, role FROM utilisateur ORDER BY nom ASC");
        return $stmt->fetchAll();
    }
}



