<?php

require_once __DIR__ . '/../../config/config.php';

/**
 * Classe Database
 *
 * Singleton pour la connexion PDO à la base de données MySQL.
 */
class Database
{
    /**
     * Instance unique de la connexion.
     */
    private static $instance = null;

    /**
     * Connexion PDO.
     * @var PDO
     */
    private $pdo;

    /**
     * Constructeur privé pour empêcher l'instanciation externe.
     */
    private function __construct()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        try {
            $this->pdo = new PDO(
                $dsn,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            // Arrête le script en cas d'erreur de connexion
            die('Erreur connexion BDD: ' . $e->getMessage());
        }
    }

    /**
     * Retourne l'unique instance PDO de la connexion à la BDD.
     *
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
