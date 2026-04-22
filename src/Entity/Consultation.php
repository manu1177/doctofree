<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $date_heure = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $anamnese = null;

    #[ORM\Column(length: 255)]
    private ?string $diagnostic = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $notes = null;

    #[ORM\OneToOne(inversedBy: 'consultation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?RendezVous $id_rendez_vous = null;

    #[ORM\OneToOne(mappedBy: 'id_consultation', cascade: ['persist', 'remove'])]
    private ?Ordonnance $ordonnance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeure(): ?\DateTime
    {
        return $this->date_heure;
    }

    public function setDateHeure(\DateTime $date_heure): static
    {
        $this->date_heure = $date_heure;

        return $this;
    }

    public function getAnamnese(): ?string
    {
        return $this->anamnese;
    }

    public function setAnamnese(?string $anamnese): static
    {
        $this->anamnese = $anamnese;

        return $this;
    }

    public function getDiagnostic(): ?string
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(string $diagnostic): static
    {
        $this->diagnostic = $diagnostic;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function getIdRendezVous(): ?RendezVous
    {
        return $this->id_rendez_vous;
    }

    public function setIdRendezVous(RendezVous $id_rendez_vous): static
    {
        $this->id_rendez_vous = $id_rendez_vous;

        return $this;
    }

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(Ordonnance $ordonnance): static
    {
        // set the owning side of the relation if necessary
        if ($ordonnance->getIdConsultation() !== $this) {
            $ordonnance->setIdConsultation($this);
        }

        $this->ordonnance = $ordonnance;

        return $this;
    }
}
