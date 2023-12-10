<?php

namespace App\Entity;

use App\Repository\FichiersAgentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichiersAgentRepository::class)]
class FichiersAgent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fichiersAgents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeFichier $type_fichier = null;

    #[ORM\ManyToOne(inversedBy: 'fichiersAgents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agent $agent = null;


    #[ORM\Column(length: 255)]
    private ?string $nom_fichier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fichier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeFichier(): ?TypeFichier
    {
        return $this->type_fichier;
    }

    public function setTypeFichier(?TypeFichier $type_fichier): static
    {
        $this->type_fichier = $type_fichier;

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): static
    {
        $this->agent = $agent;

        return $this;
    }

    public function getNomFichier(): ?string
    {
        return $this->nom_fichier;
    }

    public function setNomFichier(string $nom_fichier): static
    {
        $this->nom_fichier = $nom_fichier;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(?string $fichier): static
    {
        $this->fichier = $fichier;

        return $this;
    }
}
