<?php
// tests/Unit/Entity/CabinetTest.php

namespace App\Tests\Unit\Entity;

use App\Entity\Cabinet;
use App\Entity\Medecin;
use App\Entity\Specialite;
use PHPUnit\Framework\TestCase;

class SpecialiteTest extends TestCase
{
    private Specialite $specialite;

    protected function setUp(): void
    {
        $this->specialite = new Specialite();
    }

    public function testNomGetterAndSetter(): void
    {
        $this->specialite->setLibelle('Cardiologie');

        $this->assertSame('Cardiologie', $this->specialite->getLibelle());
    }

    public function testDescriptionGetterAndSetter(): void
    {
        $this->specialite->setDescription('Lorem ipsum');

        $this->assertSame('Lorem ipsum', $this->specialite->getDescription());
    }



    public function testMedecinsCollectionIsEmptyOnConstruct(): void
    {
        $this->assertCount(0, $this->specialite->getMedecins());
    }

    public function testAddMedecinAddsToCollection(): void
    {
        $medecin = $this->createMock(Medecin::class);
        // On indique à PHPUnit que addCabinet() peut être appelé
        $medecin->method('addCabinet')->willReturnSelf();

        $this->specialite->addMedecin($medecin);

        $this->assertCount(1, $this->specialite->getMedecins());
        $this->assertTrue($this->specialite->getMedecins()->contains($medecin));
    }

    public function testAddMedecinDoesNotAddDuplicate(): void
    {
        $medecin = $this->createMock(Medecin::class);
        $medecin->method('addSpecialite')->willReturnSelf();

        // On ajoute deux fois le même médecin
        $this->specialite->addMedecin($medecin);
        $this->specialite->addMedecin($medecin);

        // Il ne doit apparaître qu'une seule fois
        $this->assertCount(1, $this->specialite->getMedecins());
    }

    public function testRemoveMedecinRemovesFromCollection(): void
    {
        $medecin = $this->createMock(Medecin::class);
        $medecin->method('addSpecialite')->willReturnSelf();

        $this->specialite->addMedecin($medecin);
        $this->specialite->removeMedecin($medecin);

        $this->assertCount(0, $this->specialite->getMedecins());
    }

    public function testToStringReturnsLibelle(): void
    {
        $this->specialite->setLibelle('Cardiologue');

        $this->assertSame('Cardiologue', (string) $this->specialite);
    }

    public function testIdIsNullByDefault(): void
    {
        // L'id est géré par Doctrine, il doit être null avant persistance
        $this->assertNull($this->specialite->getId());
    }
}
