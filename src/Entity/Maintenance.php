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
    private ?int $id ;

    #[ORM\ManyToOne(inversedBy: 'maintenances')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Materiel $matos;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_maintenance ;

    #[ORM\Column(length: 255)]
    private ?string $status_matos ;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_sortie ;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $detail_maintenance ;

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

    public function getDetailMaintenance(): ?string
    {
        return $this->detail_maintenance;
    }

    public function setDetailMaintenance(?string $detail_maintenance): static
    {
        $this->detail_maintenance = $detail_maintenance;

        return $this;
    }
}
