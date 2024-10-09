<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    private ?MarqueVehicule $marque_vehicule = null;

    #[ORM\Column(length: 255)]
    private ?string $modele_vehicule = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    private ?TypeVehicule $type_vehicule = null;

    #[ORM\Column(length: 255)]
    private ?string $immatriculation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_circulation = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_enregistrement = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $info_vehicule = null;

    /**
     * @var Collection<int, AffectationVehicule>
     */
    #[ORM\OneToMany(mappedBy: 'vehicule', targetEntity: AffectationVehicule::class)]
    private Collection $affectationVehicules;

    public function __construct()
    {
        $this->affectationVehicules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarqueVehicule(): ?MarqueVehicule
    {
        return $this->marque_vehicule;
    }

    public function setMarqueVehicule(?MarqueVehicule $marque_vehicule): static
    {
        $this->marque_vehicule = $marque_vehicule;

        return $this;
    }

    public function getModeleVehicule(): ?string
    {
        return $this->modele_vehicule;
    }

    public function setModeleVehicule(string $modele_vehicule): static
    {
        $this->modele_vehicule = $modele_vehicule;

        return $this;
    }

    public function getTypeVehicule(): ?TypeVehicule
    {
        return $this->type_vehicule;
    }

    public function setTypeVehicule(?TypeVehicule $type_vehicule): static
    {
        $this->type_vehicule = $type_vehicule;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getDateCirculation(): ?\DateTimeInterface
    {
        return $this->date_circulation;
    }

    public function setDateCirculation(\DateTimeInterface $date_circulation): static
    {
        $this->date_circulation = $date_circulation;

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeImmutable
    {
        return $this->date_enregistrement;
    }

    public function setDateEnregistrement(\DateTimeImmutable $date_enregistrement): static
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
    }

    public function getInfoVehicule(): ?string
    {
        return $this->info_vehicule;
    }

    public function setInfoVehicule(string $info_vehicule): static
    {
        $this->info_vehicule = $info_vehicule;

        return $this;
    }

    /**
     * @return Collection<int, AffectationVehicule>
     */
    public function getAffectationVehicules(): Collection
    {
        return $this->affectationVehicules;
    }

    public function addAffectationVehicule(AffectationVehicule $affectationVehicule): static
    {
        if (!$this->affectationVehicules->contains($affectationVehicule)) {
            $this->affectationVehicules->add($affectationVehicule);
            $affectationVehicule->setVehicule($this);
        }

        return $this;
    }

    public function removeAffectationVehicule(AffectationVehicule $affectationVehicule): static
    {
        if ($this->affectationVehicules->removeElement($affectationVehicule)) {
            // set the owning side to null (unless already changed)
            if ($affectationVehicule->getVehicule() === $this) {
                $affectationVehicule->setVehicule(null);
            }
        }

        return $this;
    }
}
