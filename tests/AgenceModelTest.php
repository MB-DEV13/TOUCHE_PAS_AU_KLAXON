<?php
use PHPUnit\Framework\TestCase;

class AgenceModelTest extends TestCase
{
    protected function setUp(): void
    {
        $pdo = Database::getInstance();
        $pdo->exec("DELETE FROM agence");
    }

    public function testCreateAgence()
    {
        AgenceModel::create('TestVille');
        $agence = AgenceModel::findByName('TestVille');
        $this->assertNotEmpty($agence);
        $this->assertEquals('TestVille', $agence['nom']);
    }

    public function testUpdateAgence()
    {
        AgenceModel::create('AncienneVille');
        $agence = AgenceModel::findByName('AncienneVille');
        AgenceModel::update($agence['id_agence'], 'NouvelleVille');
        $updated = AgenceModel::findById($agence['id_agence']);
        $this->assertEquals('NouvelleVille', $updated['nom']);
    }

    public function testDeleteAgence()
    {
        AgenceModel::create('SupprimerVille');
        $agence = AgenceModel::findByName('SupprimerVille');
        AgenceModel::delete($agence['id_agence']);
        $deleted = AgenceModel::findById($agence['id_agence']);
        $this->assertFalse($deleted);
    }
}
