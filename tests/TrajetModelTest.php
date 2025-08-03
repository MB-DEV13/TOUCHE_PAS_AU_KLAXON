<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/Models/TrajetModel.php';
require_once __DIR__ . '/../app/Models/AgenceModel.php';
require_once __DIR__ . '/../app/Core/Database.php';

class TrajetModelTest extends TestCase
{
    private $pdo;
    private $idAg1;
    private $idAg2;
    private $testUserId;

    protected function setUp(): void
    {
        $this->pdo = Database::getInstance();
        $this->pdo->beginTransaction();

        // Création utilisateur de test (clé étrangère !)
        $stmt = $this->pdo->prepare("INSERT INTO utilisateur (nom, prenom, email, telephone, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            '__Test__',
            'User',
            'test.trajet@phpunit.com',
            '0123456789',
            password_hash('phpunit', PASSWORD_DEFAULT),
            'user'
        ]);
        $this->testUserId = $this->pdo->lastInsertId();

        // Création de 2 agences fictives
        AgenceModel::create('__TestDep__');
        AgenceModel::create('__TestArr__');
        $agences = AgenceModel::getAll();
        foreach ($agences as $ag) {
            if ($ag['nom'] === '__TestDep__') $this->idAg1 = $ag['id_agence'];
            if ($ag['nom'] === '__TestArr__') $this->idAg2 = $ag['id_agence'];
        }
    }

    protected function tearDown(): void
    {
        $this->pdo->rollBack();
    }

    public function testAjouterEtSupprimerTrajet()
    {
        $places = 2;
        $now = date('Y-m-d H:i:s');
        $plus1h = date('Y-m-d H:i:s', strtotime('+1 hour'));

        TrajetModel::ajouterTrajet($this->testUserId, $this->idAg1, $this->idAg2, $now, $plus1h, $places);

        // Vérifie que le trajet existe bien
        $sql = "SELECT * FROM trajet WHERE id_createur=? AND id_agence_depart=? AND id_agence_arrivee=? AND nb_places_total=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->testUserId, $this->idAg1, $this->idAg2, $places]);
        $trajet = $stmt->fetch();

        $this->assertNotFalse($trajet, "Le trajet doit être présent dans la base");

        // Supprime le trajet
        if ($trajet) {
            $id = $trajet['id_trajet'];
            TrajetModel::deleteTrajet($id);
            $stmt = $this->pdo->prepare("SELECT * FROM trajet WHERE id_trajet=?");
            $stmt->execute([$id]);
            $this->assertFalse($stmt->fetch(), "Le trajet doit être supprimé");
        }
    }

    public function testUpdateTrajet()
    {
        $places = 2;
        $now = date('Y-m-d H:i:s');
        $plus1h = date('Y-m-d H:i:s', strtotime('+1 hour'));

        TrajetModel::ajouterTrajet($this->testUserId, $this->idAg1, $this->idAg2, $now, $plus1h, $places);

        // Récupère l'id
        $stmt = $this->pdo->prepare("SELECT * FROM trajet WHERE id_createur=? AND id_agence_depart=? AND id_agence_arrivee=? AND nb_places_total=?");
        $stmt->execute([$this->testUserId, $this->idAg1, $this->idAg2, $places]);
        $trajet = $stmt->fetch();
        $this->assertNotFalse($trajet);

        $id = $trajet['id_trajet'];

        // Modifie le nombre de places
        $newPlaces = 5;
        TrajetModel::updateTrajet($id, $this->idAg1, $this->idAg2, $now, $plus1h, $newPlaces);

        // Vérifie la mise à jour
        $stmt = $this->pdo->prepare("SELECT * FROM trajet WHERE id_trajet=?");
        $stmt->execute([$id]);
        $updated = $stmt->fetch();

        $this->assertEquals($newPlaces, $updated['nb_places_total'], "Nombre de places mis à jour");
    }
}

