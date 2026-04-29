<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\OrdonnanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['ordonnance:readlist']]
        ),
        new Get(
            normalizationContext: ['groups' => ['ordonnance:readdetail']]
        )
    ],
)]
#[ORM\Entity(repositoryClass: OrdonnanceRepository::class)]
class Ordonnance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['ordonnance:readlist', 'ordonnance:readdetail', 'consultation:readdetail'])]
    private ?\DateTimeImmutable $date_emission = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['ordonnance:readlist', 'ordonnance:readdetail', 'consultation:readdetail'])]
    private ?\DateTimeImmutable $date_validite = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ordonnance:readdetail'])]
    private ?string $instructions = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Consultation $consultation = null;

    /**
     * @var Collection<int, Prescription>
     */
    #[ORM\OneToMany(targetEntity: Prescription::class, mappedBy: 'ordonnance')]
    #[Groups(['ordonnance:readlist', 'ordonnance:readdetail', 'consultation:readdetail'])]
    private Collection $prescriptions;

    public function __construct()
    {
        $this->prescriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmission(): ?\DateTimeImmutable
    {
        return $this->date_emission;
    }

    public function setDateEmission(\DateTimeImmutable $date_emission): static
    {
        $this->date_emission = $date_emission;

        return $this;
    }

    public function getDateValidite(): ?\DateTimeImmutable
    {
        return $this->date_validite;
    }

    public function setDateValidite(\DateTimeImmutable $date_validite): static
    {
        $this->date_validite = $date_validite;

        return $this;
    }

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(string $instructions): static
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(Consultation $consultation): static
    {
        $this->consultation = $consultation;

        return $this;
    }

    /**
     * @return Collection<int, Prescription>
     */
    public function getPrescriptions(): Collection
    {
        return $this->prescriptions;
    }

    public function addPrescription(Prescription $prescription): static
    {
        if (!$this->prescriptions->contains($prescription)) {
            $this->prescriptions->add($prescription);
            $prescription->setOrdonnance($this);
        }

        return $this;
    }

    public function removePrescription(Prescription $prescription): static
    {
        if ($this->prescriptions->removeElement($prescription)) {
            // set the owning side to null (unless already changed)
            if ($prescription->getOrdonnance() === $this) {
                $prescription->setOrdonnance(null);
            }
        }

        return $this;
    }
}
