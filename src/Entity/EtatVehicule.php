<?php

namespace App\Entity;

use App\Repository\EtatVehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatVehiculeRepository::class)]
class EtatVehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_etat_vehicule = null;

    /**
     * @var Collection<int, AffectationVehicule>
     */
    #[ORM\OneToMany(mappedBy: 'etat_vehicule', targetEntity: AffectationVehicule::class)]
    private Collection $affectationVehicules;

    public function __construct()
    {
        $this->affectationVehicules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEtatVehicule(): ?string
    {
        return $this->nom_etat_vehicule;
    }

    public function setNomEtatVehicule(string $nom_etat_vehicule): static
    {
        $this->nom_etat_vehicule = $nom_etat_vehicule;

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
            $affectationVehicule->setEtatVehicule($this);
        }

        return $this;
    }

    public function removeAffectationVehicule(AffectationVehicule $affectationVehicule): static
    {
        if ($this->affectationVehicules->removeElement($affectationVehicule)) {
            // set the owning side to null (unless already changed)
            if ($affectationVehicule->getEtatVehicule() === $this) {
                $affectationVehicule->setEtatVehicule(null);
            }
        }

        return $this;
    }
}
