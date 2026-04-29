<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\MedicamentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Get()
    ],
    normalizationContext: ['groups' => ['medicament:read']]
)]
#[ORM\Entity(repositoryClass: MedicamentRepository::class)]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['medicament:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ordonnance:readlist', 'ordonnance:readdetail', 'medicament:read', 'prescription:read', 'consultation:readdetail'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['medicament:read'])]
    private ?string $dci = null;

    #[ORM\Column(length: 255)]
    #[Groups(['medicament:read'])]
    private ?string $forme = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ordonnance:readlist', 'ordonnance:readdetail', 'medicament:read', 'prescription:read', 'consultation:readdetail'])]
    private ?string $dosage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDci(): ?string
    {
        return $this->dci;
    }

    public function setDci(string $dci): static
    {
        $this->dci = $dci;

        return $this;
    }

    public function getForme(): ?string
    {
        return $this->forme;
    }

    public function setForme(string $forme): static
    {
        $this->forme = $forme;

        return $this;
    }

    public function getDosage(): ?string
    {
        return $this->dosage;
    }

    public function setDosage(string $dosage): static
    {
        $this->dosage = $dosage;

        return $this;
    }
}
