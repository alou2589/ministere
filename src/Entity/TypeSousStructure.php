<?php

namespace App\Entity;

use App\Repository\TypeSousStructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeSousStructureRepository::class)]
class TypeSousStructure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_type_sous_structure = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_type_sous_structure = null;

    #[ORM\OneToMany(mappedBy: 'type_sous_structure', targetEntity: SousStructure::class, orphanRemoval: true)]
    private Collection $sousStructures;

    public function __construct()
    {
        $this->sousStructures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeSousStructure(): ?string
    {
        return $this->nom_type_sous_structure;
    }

    public function setNomTypeSousStructure(string $nom_type_sous_structure): self
    {
        $this->nom_type_sous_structure = $nom_type_sous_structure;

        return $this;
    }

    public function getDescriptionTypeSousStructure(): ?string
    {
        return $this->description_type_sous_structure;
    }

    public function setDescriptionTypeSousStructure(string $description_type_sous_structure): self
    {
        $this->description_type_sous_structure = $description_type_sous_structure;

        return $this;
    }

    /**
     * @return Collection<int, SousStructure>
     */
    public function getSousStructures(): Collection
    {
        return $this->sousStructures;
    }

    public function addSousStructure(SousStructure $sousStructure): self
    {
        if (!$this->sousStructures->contains($sousStructure)) {
            $this->sousStructures->add($sousStructure);
            $sousStructure->setTypeSousStructure($this);
        }

        return $this;
    }

    public function removeSousStructure(SousStructure $sousStructure): self
    {
        if ($this->sousStructures->removeElement($sousStructure)) {
            // set the owning side to null (unless already changed)
            if ($sousStructure->getTypeSousStructure() === $this) {
                $sousStructure->setTypeSousStructure(null);
            }
        }

        return $this;
    }
}
