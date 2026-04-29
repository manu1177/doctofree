<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CabinetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['cabinet:readlist']]
        ),
        new Get(
            normalizationContext: ['groups' => ['cabinet:readdetail']]
        )
    ],

)]
#[ORM\Entity(repositoryClass: CabinetRepository::class)]
class Cabinet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['cabinet:readlist', 'cabinet:readdetail', 'medecin:readdetail'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['cabinet:readlist', 'cabinet:readdetail', 'medecin:readdetail'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['cabinet:readlist', 'cabinet:readdetail'])]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Groups(['cabinet:readdetail'])]
    private ?string $telephone = null;

    /**
     * @var Collection<int, Medecin>
     */
    #[ORM\ManyToMany(targetEntity: Medecin::class, inversedBy: 'cabinets')]
    #[Groups(['cabinet:readdetail'])]
    private Collection $medecins;

    public function __construct()
    {
        $this->medecins = new ArrayCollection();
    }

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, Medecin>
     */
    public function getMedecins(): Collection
    {
        return $this->medecins;
    }

    // Cabinet.php
    public function addMedecin(Medecin $medecin): static
    {
        if (!$this->medecins->contains($medecin)) {
            $this->medecins->add($medecin);
            $medecin->addCabinet($this); // ← synchronisation du côté inverse
        }
        return $this;
    }

    public function removeMedecin(Medecin $medecin): static
    {
        $this->medecins->removeElement($medecin);

        return $this;
    }
}
