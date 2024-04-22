<?php

namespace App\Entity;

use App\Repository\AttributionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AttributionRepository::class)]
#[UniqueEntity(fields: ['matos'], message: 'Ce matériel est déjà attribué !')]
class Attribution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'attributions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materiel $matos = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $QrCodeAttribution = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_attribution = null;

    #[ORM\ManyToOne(inversedBy: 'attributions')]
    private ?Affectation $affectation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatos(): ?Materiel
    {
        return $this->matos;
    }

    public function setMatos(?Materiel $matos): self
    {
        $this->matos = $matos;

        return $this;
    }

    public function getQrCodeAttribution(): ?string
    {
        return $this->QrCodeAttribution;
    }

    public function setQrCodeAttribution(string $QrCodeAttribution): self
    {
        $this->QrCodeAttribution = $QrCodeAttribution;

        return $this;
    }

    public function getDateAttribution(): ?\DateTimeInterface
    {
        return $this->date_attribution;
    }

    public function setDateAttribution(\DateTimeInterface $date_attribution): self
    {
        $this->date_attribution = $date_attribution;

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
}
