<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['medecin:readlist']]
        ),
        new Get(
            normalizationContext: ['groups' => ['medecin:readdetail']]
        )
    ],
)]
#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['cabinet:readdetail', 'medecin:readlist', 'medecin:readdetail'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['cabinet:readdetail', 'medecin:readlist', 'medecin:readdetail', 'rendezvous:readlist', 'rendezvous:readdetail', 'consultation:readlist', 'consultation:readdetail', 'patient:readdetail'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['cabinet:readdetail', 'medecin:readlist', 'medecin:readdetail', 'rendezvous:readlist', 'rendezvous:readdetail', 'consultation:readlist', 'consultation:readdetail', 'patient:readdetail'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $rpps = null;

    #[ORM\Column(length: 15)]
    #[Groups(['medecin:readdetail'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 100)]
    #[Groups(['medecin:readdetail'])]
    private ?string $email = null;

    /**
     * @var Collection<int, Rendezvous>
     */
    #[ORM\OneToMany(targetEntity: Rendezvous::class, mappedBy: 'medecin')]
    private Collection $listeRendezVous;

    /**
     * @var Collection<int, Cabinet>
     */
    #[ORM\ManyToMany(targetEntity: Cabinet::class, mappedBy: 'medecins')]
    #[Groups(['medecin:readdetail'])]
    private Collection $cabinets;

    /**
     * @var Collection<int, Specialite>
     */
    #[ORM\ManyToMany(targetEntity: Specialite::class, inversedBy: 'medecins')]
    #[Groups(['medecin:readlist', 'medecin:readdetail'])]
    private Collection $specialites;

    public function __construct()
    {
        $this->listeRendezVous = new ArrayCollection();
        $this->cabinets = new ArrayCollection();
        $this->specialites = new ArrayCollection();
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

    public function getRpps(): ?string
    {
        return $this->rpps;
    }

    public function setRpps(string $rpps): static
    {
        $this->rpps = $rpps;

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
            $listeRendezVou->setMedecin($this);
        }

        return $this;
    }

    public function removeListeRendezVou(Rendezvous $listeRendezVou): static
    {
        if ($this->listeRendezVous->removeElement($listeRendezVou)) {
            // set the owning side to null (unless already changed)
            if ($listeRendezVou->getMedecin() === $this) {
                $listeRendezVou->setMedecin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cabinet>
     */
    public function getCabinets(): Collection
    {
        return $this->cabinets;
    }

    public function addCabinet(Cabinet $cabinet): static
    {
        if (!$this->cabinets->contains($cabinet)) {
            $this->cabinets->add($cabinet);
            $cabinet->addMedecin($this);
        }

        return $this;
    }

    public function removeCabinet(Cabinet $cabinet): static
    {
        if ($this->cabinets->removeElement($cabinet)) {
            $cabinet->removeMedecin($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Specialite>
     */
    public function getSpecialites(): Collection
    {
        return $this->specialites;
    }

    public function addSpecialite(Specialite $specialite): static
    {
        if (!$this->specialites->contains($specialite)) {
            $this->specialites->add($specialite);
        }

        return $this;
    }

    public function removeSpecialite(Specialite $specialite): static
    {
        $this->specialites->removeElement($specialite);

        return $this;
    }
}
