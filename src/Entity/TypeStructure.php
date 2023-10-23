<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeStructureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TypeStructureRepository::class)]
#[UniqueEntity(fields: ['nom_type_structure'], message: 'Ce type de structure existe déjà !')]
class TypeStructure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_type_structure = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_type_structure = null;

    #[ORM\OneToMany(mappedBy: 'type_structure', targetEntity: Structure::class, orphanRemoval: true)]
    private Collection $structures;

    public function __construct()
    {
        $this->structures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeStructure(): ?string
    {
        return $this->nom_type_structure;
    }

    public function setNomTypeStructure(string $nom_type_structure): self
    {
        $this->nom_type_structure = $nom_type_structure;

        return $this;
    }

    public function getDescriptionTypeStructure(): ?string
    {
        return $this->description_type_structure;
    }

    public function setDescriptionTypeStructure(string $description_type_structure): self
    {
        $this->description_type_structure = $description_type_structure;

        return $this;
    }

    /**
     * @return Collection<int, Structure>
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure)) {
            $this->structures->add($structure);
            $structure->setTypeStructure($this);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): self
    {
        if ($this->structures->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getTypeStructure() === $this) {
                $structure->setTypeStructure(null);
            }
        }

        return $this;
    }
}
