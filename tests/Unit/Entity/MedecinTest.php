<?php
// tests/Unit/Entity/CabinetTest.php

namespace App\Tests\Unit\Entity;

use App\Entity\Specialite;
use App\Entity\Cabinet;
use App\Entity\Medecin;
use PHPUnit\Framework\TestCase;

class MedecinTest extends TestCase
{
    private Medecin $medecin;

    protected function setUp(): void
    {
        $this->medecin = new Medecin();
    }

    public function testNomGetterAndSetter(): void
    {
        $this->medecin->setNom('Dupont');

        $this->assertSame('Dupont', $this->medecin->getNom());
    }

    public function testPrenomGetterAndSetter(): void
    {
        $this->medecin->setPrenom('12 rue de la Paix, Paris');

        $this->assertSame('12 rue de la Paix, Paris', $this->medecin->getPrenom());
    }

    public function testTelephoneGetterAndSetter(): void
    {
        $this->medecin->setTelephone('0123456789');

        $this->assertSame('0123456789', $this->medecin->getTelephone());
    }


    public function testToStringReturnsNom(): void
    {
        $this->medecin->setNom('Dupont');

        $this->assertSame('Dupont', (string) $this->medecin);
    }

    public function testIdIsNullByDefault(): void
    {
        // L'id est géré par Doctrine, il doit être null avant persistance
        $this->assertNull($this->medecin->getId());
    }
}
