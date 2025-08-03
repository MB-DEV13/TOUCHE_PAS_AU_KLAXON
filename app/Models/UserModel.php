<?php

require_once __DIR__ . '/../Core/Database.php';

/**
 * Modèle d’accès aux utilisateurs.
 *
 * Permet la récupération, la recherche, la gestion des utilisateurs de l’application.
 *
 */
class UserModel
{
    /**
     * Trouve un utilisateur par email.
     *
     * @param string $email L’adresse email de l’utilisateur recherché.
     * @return array|false  Les données de l’utilisateur (tableau associatif) ou false si non trouvé.
     */
    public static function findByEmail(string $email)
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Renvoie false si non trouvé
    }

    /**
     * Récupère tous les utilisateurs.
     *
     * @return array Tableau des utilisateurs (chaque utilisateur est un tableau associatif).
     */
    public static function getAll(): array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT id_user, nom, prenom, email, telephone, role FROM utilisateur ORDER BY nom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}




