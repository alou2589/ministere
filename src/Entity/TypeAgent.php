<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeAgentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TypeAgentRepository::class)]
#[UniqueEntity(fields: ['nom_type_agent'], message: "Ce type d' agent existe déjà !")]
class TypeAgent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_type_agent = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'type_agent', targetEntity: StatutAgent::class)]
    private Collection $statutAgents;

    public function __construct()
    {
        $this->statutAgents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeAgent(): ?string
    {
        return $this->nom_type_agent;
    }

    public function setNomTypeAgent(string $nom_type_agent): self
    {
        $this->nom_type_agent = $nom_type_agent;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, StatutAgent>
     */
    public function getStatutAgents(): Collection
    {
        return $this->statutAgents;
    }

    public function addStatutAgent(StatutAgent $statutAgent): static
    {
        if (!$this->statutAgents->contains($statutAgent)) {
            $this->statutAgents->add($statutAgent);
            $statutAgent->setTypeAgent($this);
        }

        return $this;
    }

    public function removeStatutAgent(StatutAgent $statutAgent): static
    {
        if ($this->statutAgents->removeElement($statutAgent)) {
            // set the owning side to null (unless already changed)
            if ($statutAgent->getTypeAgent() === $this) {
                $statutAgent->setTypeAgent(null);
            }
        }

        return $this;
    }
}
