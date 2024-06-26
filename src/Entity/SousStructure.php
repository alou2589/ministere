<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SousStructureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SousStructureRepository::class)]
#[UniqueEntity(fields: ['nom_sous_structure'], message: 'Cette sous-structure existe déjà !')]
class SousStructure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sousStructures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeSousStructure $type_sous_structure = null;

    #[ORM\ManyToOne(inversedBy: 'sousStructures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Structure $structure = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_sous_structure = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_sous_structure = null;

    #[ORM\OneToMany(mappedBy: 'sous_structure', targetEntity: Affectation::class)]
    private Collection $affectations;

    public function __construct()
    {
        $this->affectations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeSousStructure(): ?TypeSousStructure
    {
        return $this->type_sous_structure;
    }

    public function setTypeSousStructure(?TypeSousStructure $type_sous_structure): self
    {
        $this->type_sous_structure = $type_sous_structure;

        return $this;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    public function getNomSousStructure(): ?string
    {
        return $this->nom_sous_structure;
    }

    public function setNomSousStructure(string $nom_sous_structure): self
    {
        $this->nom_sous_structure = $nom_sous_structure;

        return $this;
    }

    public function getDescriptionSousStructure(): ?string
    {
        return $this->description_sous_structure;
    }

    public function setDescriptionSousStructure(string $description_sous_structure): self
    {
        $this->description_sous_structure = $description_sous_structure;

        return $this;
    }

    /**
     * @return Collection<int, Affectation>
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): static
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations->add($affectation);
            $affectation->setSousStructure($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): static
    {
        if ($this->affectations->removeElement($affectation)) {
            // set the owning side to null (unless already changed)
            if ($affectation->getSousStructure() === $this) {
                $affectation->setSousStructure(null);
            }
        }

        return $this;
    }
}
