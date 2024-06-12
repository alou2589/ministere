<?php

namespace App\Entity;

use App\Repository\CarteProRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteProRepository::class)]
class CartePro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_delivrance;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_expiration ;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $qrcode_agent;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo_agent ;

    #[ORM\Column(length: 255)]
    private ?string $status_impression;

    #[ORM\ManyToOne(inversedBy: 'cartePros')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Affectation $affectation;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDelivrance(): ?\DateTimeInterface
    {
        return $this->date_delivrance;
    }

    public function setDateDelivrance(\DateTimeInterface $date_delivrance): self
    {
        $this->date_delivrance = $date_delivrance;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(\DateTimeInterface $date_expiration): self
    {
        $this->date_expiration = $date_expiration;

        return $this;
    }

    public function getQrcodeAgent(): ?string
    {
        return $this->qrcode_agent;
    }

    public function setQrcodeAgent(string $qrcode_agent): self
    {
        $this->qrcode_agent = $qrcode_agent;

        return $this;
    }

    public function getPhotoAgent(): ?string
    {
        return $this->photo_agent;
    }

    public function setPhotoAgent(?string $photo_agent): self
    {
        $this->photo_agent = $photo_agent;

        return $this;
    }

    public function getStatusImpression(): ?string
    {
        return $this->status_impression;
    }

    public function setStatusImpression(string $status_impression): self
    {
        $this->status_impression = $status_impression;

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
