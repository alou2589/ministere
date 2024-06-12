<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
#[UniqueEntity(fields: ['telephone'], message: 'Ce telephone existe déjà !')]
class Agent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;
    #[ORM\Column(length: 255)]
    private ?string $prenom;

    #[ORM\Column(length: 255)]
    private ?string $nom;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance ;

    #[ORM\Column(length: 255)]
    private ?string $lieu_naissance;

    #[ORM\Column(length: 255)]
    private ?string $genre;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone;

    #[ORM\OneToMany(mappedBy: 'agent', targetEntity: StatutAgent::class, orphanRemoval: true)]
    private Collection $statutAgents;

    public function __construct()
    {
        $this->statutAgents = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieu_naissance;
    }

    public function setLieuNaissance(string $lieu_naissance): self
    {
        $this->lieu_naissance = $lieu_naissance;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function __toString()
    {
        return $this->getPrenom() . ' ' . $this->getNom();
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

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
            $statutAgent->setAgent($this);
        }

        return $this;
    }

    public function removeStatutAgent(StatutAgent $statutAgent): static
    {
        if ($this->statutAgents->removeElement($statutAgent)) {
            // set the owning side to null (unless already changed)
            if ($statutAgent->getAgent() === $this) {
                $statutAgent->setAgent(null);
            }
        }

        return $this;
    }



}
