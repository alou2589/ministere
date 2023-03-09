<?php

namespace App\Entity;

use App\Repository\CategorieMaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieMaterielRepository::class)]
class CategorieMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_categorie_matos = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_categorie_matos = null;

    #[ORM\OneToMany(mappedBy: 'categorie_matos', targetEntity: TypeMateriel::class, orphanRemoval: true)]
    private Collection $typeMateriels;

    public function __construct()
    {
        $this->typeMateriels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorieMatos(): ?string
    {
        return $this->nom_categorie_matos;
    }

    public function setNomCategorieMatos(string $nom_categorie_matos): self
    {
        $this->nom_categorie_matos = $nom_categorie_matos;

        return $this;
    }

    public function getDescriptionCategorieMatos(): ?string
    {
        return $this->description_categorie_matos;
    }

    public function setDescriptionCategorieMatos(string $description_categorie_matos): self
    {
        $this->description_categorie_matos = $description_categorie_matos;

        return $this;
    }

    /**
     * @return Collection<int, TypeMateriel>
     */
    public function getTypeMateriels(): Collection
    {
        return $this->typeMateriels;
    }

    public function addTypeMateriel(TypeMateriel $typeMateriel): self
    {
        if (!$this->typeMateriels->contains($typeMateriel)) {
            $this->typeMateriels->add($typeMateriel);
            $typeMateriel->setCategorieMatos($this);
        }

        return $this;
    }

    public function removeTypeMateriel(TypeMateriel $typeMateriel): self
    {
        if ($this->typeMateriels->removeElement($typeMateriel)) {
            // set the owning side to null (unless already changed)
            if ($typeMateriel->getCategorieMatos() === $this) {
                $typeMateriel->setCategorieMatos(null);
            }
        }

        return $this;
    }
}
