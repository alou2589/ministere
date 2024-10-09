<?php

namespace App\Entity;

use App\Repository\MarqueVehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueVehiculeRepository::class)]
class MarqueVehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_marque_vehicule = null;

    /**
     * @var Collection<int, Vehicule>
     */
    #[ORM\OneToMany(mappedBy: 'marque_vehicule', targetEntity: Vehicule::class)]
    private Collection $vehicules;

    public function __construct()
    {
        $this->vehicules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMarqueVehicule(): ?string
    {
        return $this->nom_marque_vehicule;
    }

    public function setNomMarqueVehicule(string $nom_marque_vehicule): static
    {
        $this->nom_marque_vehicule = $nom_marque_vehicule;

        return $this;
    }

    /**
     * @return Collection<int, Vehicule>
     */
    public function getVehicules(): Collection
    {
        return $this->vehicules;
    }

    public function addVehicule(Vehicule $vehicule): static
    {
        if (!$this->vehicules->contains($vehicule)) {
            $this->vehicules->add($vehicule);
            $vehicule->setMarqueVehicule($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): static
    {
        if ($this->vehicules->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getMarqueVehicule() === $this) {
                $vehicule->setMarqueVehicule(null);
            }
        }

        return $this;
    }
}
