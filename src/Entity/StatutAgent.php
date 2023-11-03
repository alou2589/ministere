<?php

namespace App\Entity;

use App\Repository\StatutAgentRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutAgentRepository::class)]
#[UniqueEntity(fields: ['agent'], message: 'Cet agent existe déjà !')]
class StatutAgent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'statutAgents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agent $agent = null;

    #[ORM\Column(length: 255)]
    private ?string $echellon = null;

    #[ORM\Column(length: 255)]
    private ?string $grade = null;

    #[ORM\Column(length: 255)]
    private ?string $hierarchie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_prise_service = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_avancement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut_ministere = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getEchellon(): ?string
    {
        return $this->echellon;
    }

    public function setEchellon(string $echellon): self
    {
        $this->echellon = $echellon;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getHierarchie(): ?string
    {
        return $this->hierarchie;
    }

    public function setHierarchie(string $hierarchie): self
    {
        $this->hierarchie = $hierarchie;

        return $this;
    }

    public function getDatePriseService(): ?\DateTimeInterface
    {
        return $this->date_prise_service;
    }

    public function setDatePriseService(\DateTimeInterface $date_prise_service): self
    {
        $this->date_prise_service = $date_prise_service;

        return $this;
    }

    public function getDateAvancement(): ?\DateTimeInterface
    {
        return $this->date_avancement;
    }

    public function setDateAvancement(\DateTimeInterface $date_avancement): self
    {
        $this->date_avancement = $date_avancement;

        return $this;
    }

    public function getDateDebutMinistere(): ?\DateTimeInterface
    {
        return $this->date_debut_ministere;
    }

    public function setDateDebutMinistere(?\DateTimeInterface $date_debut_ministere): static
    {
        $this->date_debut_ministere = $date_debut_ministere;

        return $this;
    }
}
