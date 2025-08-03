<?php

require_once __DIR__ . '/../Core/Database.php';

/**
 * Modèle de gestion des agences.
 *
 * Gère l'accès et la manipulation des agences en base.
 */
class AgenceModel
{
    /**
     * Récupère toutes les agences, triées par nom.
     *
     * @return array Liste des agences (tableau associatif).
     */
    public static function getAll(): array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM agence ORDER BY nom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trouve une agence par son identifiant.
     *
     * @param int $id Identifiant de l'agence.
     * @return array|false Tableau associatif de l'agence ou false si non trouvée.
     */
    public static function findById(int $id)
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM agence WHERE id_agence = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche une agence par nom.
     *
     * @param string $nom Nom de l'agence.
     * @return array|false Tableau associatif de l'agence ou false si non trouvée.
     */
    public static function findByName(string $nom)
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM agence WHERE LOWER(nom) = LOWER(?)");
        $stmt->execute([$nom]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée une nouvelle agence.
     *
     * @param string $nom Nom de l'agence.
     * @return void
     */
    public static function create(string $nom): void
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO agence (nom) VALUES (?)");
        $stmt->execute([$nom]);
    }

    /**
     * Met à jour une agence.
     *
     * @param int $id Identifiant de l'agence.
     * @param string $nom Nouveau nom de l'agence.
     * @return void
     */
    public static function update(int $id, string $nom): void
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE agence SET nom = ? WHERE id_agence = ?");
        $stmt->execute([$nom, $id]);
    }

    /**
     * Supprime une agence par son identifiant.
     *
     * @param int $id Identifiant de l'agence.
     * @return void
     */
    public static function delete(int $id): void
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM agence WHERE id_agence = ?");
        $stmt->execute([$id]);
    }
}

