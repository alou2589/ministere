<?php

namespace App\Entity;

use App\Repository\CongeAbsenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CongeAbsenceRepository::class)]
class CongeAbsence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'congeAbsences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeAbsence $type_absence = null;

    #[ORM\ManyToOne(inversedBy: 'congeAbsences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StatutAgent $statut_agent = null;

    #[ORM\Column]
    private ?int $nombre_jour = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fichier = null;

    #[ORM\ManyToOne(inversedBy: 'congeAbsences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $operateur = null;

    #[ORM\Column(length: 255)]
    private ?string $statutCongeAbsence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAbsence(): ?TypeAbsence
    {
        return $this->type_absence;
    }

    public function setTypeAbsence(?TypeAbsence $type_absence): static
    {
        $this->type_absence = $type_absence;

        return $this;
    }

    public function getStatutAgent(): ?StatutAgent
    {
        return $this->statut_agent;
    }

    public function setStatutAgent(?StatutAgent $statut_agent): static
    {
        $this->statut_agent = $statut_agent;

        return $this;
    }

    public function getNombreJour(): ?int
    {
        return $this->nombre_jour;
    }

    public function setNombreJour(int $nombre_jour): static
    {
        $this->nombre_jour = $nombre_jour;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): static
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getOperateur(): ?User
    {
        return $this->operateur;
    }

    public function setOperateur(?User $operateur): static
    {
        $this->operateur = $operateur;

        return $this;
    }

    public function getStatutCongeAbsence(): ?string
    {
        return $this->statutCongeAbsence;
    }

    public function setStatutCongeAbsence(string $statutCongeAbsence): static
    {
        $this->statutCongeAbsence = $statutCongeAbsence;

        return $this;
    }
}
