<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\RendezvousRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['rendezvous:readlist']]
        ),
        new Get(
            normalizationContext: ['groups' => ['rendezvous:readdetail']]
        )
    ],
)]
#[ORM\Entity(repositoryClass: RendezvousRepository::class)]
class Rendezvous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['rendezvous:readlist', 'rendezvous:readdetail', 'patient:readdetail'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['rendezvous:readlist', 'rendezvous:readdetail', 'patient:readdetail'])]
    private ?\DateTime $date_heure = null;

    #[ORM\Column]
    #[Groups(['rendezvous:readlist', 'rendezvous:readdetail', 'patient:readdetail'])]
    private ?int $duree_minutes = null;

    #[ORM\Column(length: 255)]
    #[Groups(['rendezvous:readlist', 'rendezvous:readdetail', 'patient:readdetail'])]
    private ?string $statut = null;

    #[ORM\Column(length: 255)]
    #[Groups(['rendezvous:readlist', 'rendezvous:readdetail', 'patient:readdetail'])]
    private ?string $motif = null;

    #[ORM\ManyToOne(inversedBy: 'listeRendezVous')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['rendezvous:readlist', 'rendezvous:readdetail', 'consultation:readlist', 'consultation:readdetail', 'patient:readdetail'])]
    private ?Medecin $medecin = null;

    #[ORM\ManyToOne(inversedBy: 'listeRendezVous')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['rendezvous:readlist', 'rendezvous:readdetail'])]
    private ?Patient $patient = null;

    #[ORM\OneToOne(mappedBy: 'rendezVous', cascade: ['persist', 'remove'])]
    #[Groups(['rendezvous:readdetail'])]
    private ?Consultation $consultation = null;

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

    public function getDureeMinutes(): ?int
    {
        return $this->duree_minutes;
    }

    public function setDureeMinutes(int $duree_minutes): static
    {
        $this->duree_minutes = $duree_minutes;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): static
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): static
    {
        $this->consultation = $consultation;

        return $this;
    }
}
