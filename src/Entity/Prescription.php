<?php

namespace App\Entity;

use App\Repository\PrescriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrescriptionRepository::class)]
class Prescription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $posologie = null;

    #[ORM\Column]
    private ?int $duree_jours = null;

    #[ORM\Column(length: 255)]
    private ?string $frequence = null;

    #[ORM\ManyToOne(inversedBy: 'prescirptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Medicament $id_medicament = null;

    #[ORM\ManyToOne(inversedBy: 'prescriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ordonnance $id_ordonnance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosologie(): ?string
    {
        return $this->posologie;
    }

    public function setPosologie(string $posologie): static
    {
        $this->posologie = $posologie;

        return $this;
    }

    public function getDureeJours(): ?int
    {
        return $this->duree_jours;
    }

    public function setDureeJours(int $duree_jours): static
    {
        $this->duree_jours = $duree_jours;

        return $this;
    }

    public function getFrequence(): ?string
    {
        return $this->frequence;
    }

    public function setFrequence(string $frequence): static
    {
        $this->frequence = $frequence;

        return $this;
    }

    public function getIdMedicament(): ?Medicament
    {
        return $this->id_medicament;
    }

    public function setIdMedicament(?Medicament $id_medicament): static
    {
        $this->id_medicament = $id_medicament;

        return $this;
    }

    public function getIdOrdonnance(): ?Ordonnance
    {
        return $this->id_ordonnance;
    }

    public function setIdOrdonnance(?Ordonnance $id_ordonnance): static
    {
        $this->id_ordonnance = $id_ordonnance;

        return $this;
    }
}
