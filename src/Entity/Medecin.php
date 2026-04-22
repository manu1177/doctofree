<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
    ],
    normalizationContext: ['groups' => ['medecin:read']],


)]

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
#[ORM\Table(name: 'medecin')]



class Medecin

{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['medecin:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['medecin:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Groups(['medecin:read'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $rpps = null;

    #[ORM\Column(length: 20)]
    #[Groups(['medecin:read'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 50)]
    #[Groups(['medecin:read'])]
    private ?string $email = null;

    /**
     * @var Collection<int, RendezVous>
     */
    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'id_medecin')]
    private Collection $rendezVous;

    /**
     * @var Collection<int, Specialite>
     */
    #[ORM\ManyToMany(targetEntity: Specialite::class, inversedBy: 'medecins')]
    #[Groups(['medecin:read'])]
    private Collection $specialites;

    /**
     * @var Collection<int, Cabinet>
     */
    #[ORM\ManyToMany(targetEntity: Cabinet::class, inversedBy: 'medecins')]
    #[Groups(['medecin:read'])]
    private Collection $cabinets;


    public function __construct()
    {
        $this->rendezVous = new ArrayCollection();
        $this->specialites = new ArrayCollection();
        $this->cabinets = new ArrayCollection();
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
     * @return Collection<int, RendezVous>
     */
    public function getRendezVous(): Collection
    {
        return $this->rendezVous;
    }

    public function addRendezVou(RendezVous $rendezVou): static
    {
        if (!$this->rendezVous->contains($rendezVou)) {
            $this->rendezVous->add($rendezVou);
            $rendezVou->setIdMedecin($this);
        }

        return $this;
    }

    public function removeRendezVou(RendezVous $rendezVou): static
    {
        if ($this->rendezVous->removeElement($rendezVou)) {
            // set the owning side to null (unless already changed)
            if ($rendezVou->getIdMedecin() === $this) {
                $rendezVou->setIdMedecin(null);
            }
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
        }

        return $this;
    }

    public function removeCabinet(Cabinet $cabinet): static
    {
        $this->cabinets->removeElement($cabinet);

        return $this;
    }
}
