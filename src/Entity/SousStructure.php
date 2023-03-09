<?php

namespace App\Entity;

use App\Repository\SousStructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousStructureRepository::class)]
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

    #[ORM\OneToMany(mappedBy: 'sous_structure', targetEntity: Agent::class, orphanRemoval: true)]
    private Collection $agents;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
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
     * @return Collection<int, Agent>
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents->add($agent);
            $agent->setSousStructure($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getSousStructure() === $this) {
                $agent->setSousStructure(null);
            }
        }

        return $this;
    }
}
