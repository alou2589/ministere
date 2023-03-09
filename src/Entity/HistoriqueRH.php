<?php

namespace App\Entity;

use App\Repository\HistoriqueRHRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueRHRepository::class)]
class HistoriqueRH
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_action = null;

    #[ORM\Column(length: 255)]
    private ?string $type_action = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDateAction(): ?\DateTimeInterface
    {
        return $this->date_action;
    }

    public function setDateAction(\DateTimeInterface $date_action): self
    {
        $this->date_action = $date_action;

        return $this;
    }

    public function getTypeAction(): ?string
    {
        return $this->type_action;
    }

    public function setTypeAction(string $type_action): self
    {
        $this->type_action = $type_action;

        return $this;
    }
}
