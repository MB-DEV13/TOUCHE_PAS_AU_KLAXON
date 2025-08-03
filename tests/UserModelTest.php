<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/Models/UserModel.php';
require_once __DIR__ . '/../app/Core/Database.php';

class UserModelTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = Database::getInstance();
        $this->pdo->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->pdo->rollBack();
    }

    public function testFindByEmailEtGetAll()
    {
        // Ajoute un utilisateur fictif
        $email = '__test@exemple.com';
        $prenom = 'Unit';
        $nom = 'Test';
        $telephone = '0123456789';
        $password = password_hash('password123', PASSWORD_DEFAULT);
        $role = 'user';

        $stmt = $this->pdo->prepare("INSERT INTO utilisateur (nom, prenom, email, telephone, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $telephone, $password, $role]);

        // Teste la récupération par email
        $user = UserModel::findByEmail($email);

        $this->assertNotFalse($user, "L'utilisateur doit être trouvé par son email");
        $this->assertEquals($nom, $user['nom']);
        $this->assertEquals($prenom, $user['prenom']);
        $this->assertEquals($email, $user['email']);
        $this->assertTrue(password_verify('password123', $user['password']));

        // Teste la récupération de tous les users
        $all = UserModel::getAll();
        $found = false;
        foreach ($all as $u) {
            if ($u['email'] === $email) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, "Le user de test doit être présent dans getAll()");
    }
}
