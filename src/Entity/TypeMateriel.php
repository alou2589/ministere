<?php

namespace App\Entity;

use App\Repository\TypeMaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeMaterielRepository::class)]
class TypeMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_type_matos = null;

    #[ORM\ManyToOne(inversedBy: 'typeMateriels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieMateriel $categorie_matos = null;

    #[ORM\OneToMany(mappedBy: 'type_matos', targetEntity: Materiel::class, orphanRemoval: true)]
    private Collection $materiels;

    public function __construct()
    {
        $this->materiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeMatos(): ?string
    {
        return $this->nom_type_matos;
    }

    public function setNomTypeMatos(string $nom_type_matos): self
    {
        $this->nom_type_matos = $nom_type_matos;

        return $this;
    }

    public function getCategorieMatos(): ?CategorieMateriel
    {
        return $this->categorie_matos;
    }

    public function setCategorieMatos(?CategorieMateriel $categorie_matos): self
    {
        $this->categorie_matos = $categorie_matos;

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
            $materiel->setTypeMatos($this);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): self
    {
        if ($this->materiels->removeElement($materiel)) {
            // set the owning side to null (unless already changed)
            if ($materiel->getTypeMatos() === $this) {
                $materiel->setTypeMatos(null);
            }
        }

        return $this;
    }
}
