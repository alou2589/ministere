<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MaintenanceRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MaintenanceRepository::class)]
#[UniqueEntity(fields: ['matos'], message: 'Ce matériel existe déjà !')]
class Maintenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'maintenances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materiel $matos = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_maintenance = null;

    #[ORM\Column(length: 255)]
    private ?string $status_matos = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_sortie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatos(): ?Materiel
    {
        return $this->matos;
    }

    public function setMatos(?Materiel $matos): static
    {
        $this->matos = $matos;

        return $this;
    }

    public function getDateMaintenance(): ?\DateTimeInterface
    {
        return $this->date_maintenance;
    }

    public function setDateMaintenance(\DateTimeInterface $date_maintenance): static
    {
        $this->date_maintenance = $date_maintenance;

        return $this;
    }

    public function getStatusMatos(): ?string
    {
        return $this->status_matos;
    }

    public function setStatusMatos(string $status_matos): static
    {
        $this->status_matos = $status_matos;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(\DateTimeInterface $date_sortie): static
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }
}
