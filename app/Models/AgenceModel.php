<?php
require_once __DIR__ . '/../Core/Database.php';

class AgenceModel {
    public static function getAll() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM agence ORDER BY nom ASC");
        return $stmt->fetchAll();
    }

    public static function findById($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM agence WHERE id_agence = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // AJOUT : Recherche par nom (insensible à la casse)
    public static function findByName($nom) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM agence WHERE LOWER(nom) = LOWER(?)");
        $stmt->execute([$nom]);
        return $stmt->fetch();
    }

    public static function create($nom) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO agence (nom) VALUES (?)");
        $stmt->execute([$nom]);
    }

    public static function update($id, $nom) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE agence SET nom = ? WHERE id_agence = ?");
        $stmt->execute([$nom, $id]);
    }

    public static function delete($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM agence WHERE id_agence = ?");
        $stmt->execute([$id]);
    }
}
