<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['consultation:readlist']]
        ),
        new Get(
            normalizationContext: ['groups' => ['consultation:readdetail']]
        )
    ],
)]
#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['consultation:readlist', 'consultation:readdetail', 'rendezvous:readdetail'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['consultation:readlist', 'consultation:readdetail', 'rendezvous:readdetail'])]
    private ?\DateTime $date_heure = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['consultation:readdetail', 'rendezvous:readdetail'])]
    private ?string $anamnese = null;

    #[ORM\Column(length: 255)]
    #[Groups(['consultation:readlist', 'consultation:readdetail', 'rendezvous:readdetail'])]
    private ?string $diagnostic = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['consultation:readdetail', 'rendezvous:readdetail'])]
    private ?string $notes = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['consultation:readlist', 'consultation:readdetail'])]
    private ?Rendezvous $rendezVous = null;

    #[ORM\OneToOne(mappedBy: 'consultation', cascade: ['persist', 'remove'])]
    #[Groups(['consultation:readdetail'])]
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

    public function getRendezVous(): ?Rendezvous
    {
        return $this->rendezVous;
    }

    public function setRendezVous(Rendezvous $rendezVous): static
    {
        $this->rendezVous = $rendezVous;

        return $this;
    }

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(?Ordonnance $ordonnance): static
    {
        $this->ordonnance = $ordonnance;

        return $this;
    }
}
