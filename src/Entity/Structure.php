<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StructureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
#[UniqueEntity(fields: ['nom_structure'], message: 'Cette structure existe déjà !')]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeStructure $type_structure = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_structure = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_structure = null;

    #[ORM\OneToMany(mappedBy: 'structure', targetEntity: SousStructure::class, orphanRemoval: true)]
    private Collection $sousStructures;

    public function __construct()
    {
        $this->sousStructures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeStructure(): ?TypeStructure
    {
        return $this->type_structure;
    }

    public function setTypeStructure(?TypeStructure $type_structure): self
    {
        $this->type_structure = $type_structure;

        return $this;
    }

    public function getNomStructure(): ?string
    {
        return $this->nom_structure;
    }

    public function setNomStructure(string $nom_structure): self
    {
        $this->nom_structure = $nom_structure;

        return $this;
    }

    public function getDescriptionStructure(): ?string
    {
        return $this->description_structure;
    }

    public function setDescriptionStructure(string $description_structure): self
    {
        $this->description_structure = $description_structure;

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
            $sousStructure->setStructure($this);
        }

        return $this;
    }

    public function removeSousStructure(SousStructure $sousStructure): self
    {
        if ($this->sousStructures->removeElement($sousStructure)) {
            // set the owning side to null (unless already changed)
            if ($sousStructure->getStructure() === $this) {
                $sousStructure->setStructure(null);
            }
        }

        return $this;
    }
}
