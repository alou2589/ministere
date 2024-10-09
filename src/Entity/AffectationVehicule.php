<?php

namespace App\Entity;

use App\Repository\AffectationVehiculeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffectationVehiculeRepository::class)]
class AffectationVehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'affectationVehicules')]
    private ?Vehicule $vehicule = null;

    #[ORM\ManyToOne(inversedBy: 'affectationVehicules')]
    private ?Affectation $affectation = null;

    #[ORM\ManyToOne(inversedBy: 'affectationVehicules')]
    private ?EtatVehicule $etat_vehicule = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_affectation_vehicule = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): static
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getAffectation(): ?Affectation
    {
        return $this->affectation;
    }

    public function setAffectation(?Affectation $affectation): static
    {
        $this->affectation = $affectation;

        return $this;
    }

    public function getEtatVehicule(): ?EtatVehicule
    {
        return $this->etat_vehicule;
    }

    public function setEtatVehicule(?EtatVehicule $etat_vehicule): static
    {
        $this->etat_vehicule = $etat_vehicule;

        return $this;
    }

    public function getDateAffectationVehicule(): ?\DateTimeImmutable
    {
        return $this->date_affectation_vehicule;
    }

    public function setDateAffectationVehicule(\DateTimeImmutable $date_affectation_vehicule): static
    {
        $this->date_affectation_vehicule = $date_affectation_vehicule;

        return $this;
    }
}
