<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicamentRepository::class)]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $dci = null;

    #[ORM\Column(length: 255)]
    private ?string $forme = null;

    #[ORM\Column(length: 255)]
    private ?string $dosage = null;

    /**
     * @var Collection<int, Prescription>
     */
    #[ORM\OneToMany(targetEntity: Prescription::class, mappedBy: 'id_medicament')]
    private Collection $prescirptions;

    public function __construct()
    {
        $this->prescirptions = new ArrayCollection();
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

    /**
     * @return Collection<int, Prescription>
     */
    public function getPrescirptions(): Collection
    {
        return $this->prescirptions;
    }

    public function addPrescirption(Prescription $prescirption): static
    {
        if (!$this->prescirptions->contains($prescirption)) {
            $this->prescirptions->add($prescirption);
            $prescirption->setIdMedicament($this);
        }

        return $this;
    }

    public function removePrescirption(Prescription $prescirption): static
    {
        if ($this->prescirptions->removeElement($prescirption)) {
            // set the owning side to null (unless already changed)
            if ($prescirption->getIdMedicament() === $this) {
                $prescirption->setIdMedicament(null);
            }
        }

        return $this;
    }
}
