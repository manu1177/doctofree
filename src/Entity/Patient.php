<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['patient:readlist']]
        ),
        new Get(
            normalizationContext: ['groups' => ['patient:readdetail']]
        )
    ],
)]
#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['patient:readlist', 'patient:readdetail', 'rendezvous:readlist', 'rendezvous:readdetail'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['patient:readlist', 'patient:readdetail', 'rendezvous:readlist', 'rendezvous:readdetail'])]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['patient:readlist', 'patient:readdetail'])]
    private ?\DateTimeImmutable $date_naissance = null;

    #[ORM\Column(length: 1)]
    private ?string $sexe = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 15)]
    #[Groups(['patient:readlist'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    #[Groups(['patient:readdetail'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['patient:readdetail'])]
    private ?string $numero_secu = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['patient:readdetail'])]
    private ?\DateTimeImmutable $date_inscription = null;

    /**
     * @var Collection<int, Rendezvous>
     */
    #[ORM\OneToMany(targetEntity: Rendezvous::class, mappedBy: 'patient')]
    #[Groups(['patient:readdetail'])]
    private Collection $listeRendezVous;

    public function __construct()
    {
        $this->listeRendezVous = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeImmutable
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeImmutable $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNumeroSecu(): ?string
    {
        return $this->numero_secu;
    }

    public function setNumeroSecu(string $numero_secu): static
    {
        $this->numero_secu = $numero_secu;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeImmutable
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeImmutable $date_inscription): static
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    /**
     * @return Collection<int, Rendezvous>
     */
    public function getListeRendezVous(): Collection
    {
        return $this->listeRendezVous;
    }

    public function addListeRendezVou(Rendezvous $listeRendezVou): static
    {
        if (!$this->listeRendezVous->contains($listeRendezVou)) {
            $this->listeRendezVous->add($listeRendezVou);
            $listeRendezVou->setPatient($this);
        }

        return $this;
    }

    public function removeListeRendezVou(Rendezvous $listeRendezVou): static
    {
        if ($this->listeRendezVous->removeElement($listeRendezVou)) {
            // set the owning side to null (unless already changed)
            if ($listeRendezVou->getPatient() === $this) {
                $listeRendezVou->setPatient(null);
            }
        }

        return $this;
    }
}
