<?php

namespace App\Entity;

use App\Repository\MarqueMatosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueMatosRepository::class)]
class MarqueMatos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_marque_matos = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_marque_matos = null;

    #[ORM\OneToMany(mappedBy: 'marque_matos', targetEntity: Materiel::class, orphanRemoval: true)]
    private Collection $materiels;

    public function __construct()
    {
        $this->materiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMarqueMatos(): ?string
    {
        return $this->nom_marque_matos;
    }

    public function setNomMarqueMatos(string $nom_marque_matos): self
    {
        $this->nom_marque_matos = $nom_marque_matos;

        return $this;
    }

    public function getDescriptionMarqueMatos(): ?string
    {
        return $this->description_marque_matos;
    }

    public function setDescriptionMarqueMatos(string $description_marque_matos): self
    {
        $this->description_marque_matos = $description_marque_matos;

        return $this;
    }

    /**
     * @return Collection<int, Materiel>
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addMateriel(Materiel $materiel): self
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels->add($materiel);
            $materiel->setMarqueMatos($this);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): self
    {
        if ($this->materiels->removeElement($materiel)) {
            // set the owning side to null (unless already changed)
            if ($materiel->getMarqueMatos() === $this) {
                $materiel->setMarqueMatos(null);
            }
        }

        return $this;
    }
}
