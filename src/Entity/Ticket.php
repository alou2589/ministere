<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TicketRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
//#[UniqueEntity(fields: ['matos'], message: 'Ce ticket est déjà ajouté !')]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materiel $matos = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_proprietaire = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_declaration = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Technicien $technicien = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $observation_technicien = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $solution_apportee = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_sortie = null;

    #[ORM\Column(length: 255)]
    private ?string $status_ticket = null;

    #[ORM\OneToMany(mappedBy: 'ticket', targetEntity: Notification::class, orphanRemoval: true)]
    private Collection $notifications;

    #[ORM\Column(length: 255)]
    private ?string $type_urgence = null;

    #[ORM\Column(length: 255)]
    private ?string $statut_matos = null;

    public function __construct()
    {
        $this->notifications = new ArrayCollection();
    }

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

    public function getDescriptionProprietaire(): ?string
    {
        return $this->description_proprietaire;
    }

    public function setDescriptionProprietaire(string $description_proprietaire): self
    {
        $this->description_proprietaire = $description_proprietaire;

        return $this;
    }

    public function getDateDeclaration(): ?\DateTimeInterface
    {
        return $this->date_declaration;
    }

    public function setDateDeclaration(\DateTimeInterface $date_declaration): self
    {
        $this->date_declaration = $date_declaration;

        return $this;
    }

    public function getTechnicien(): ?Technicien
    {
        return $this->technicien;
    }

    public function setTechnicien(?Technicien $technicien): self
    {
        $this->technicien = $technicien;

        return $this;
    }

    public function getObservationTechnicien(): ?string
    {
        return $this->observation_technicien;
    }

    public function setObservationTechnicien(string $observation_technicien): self
    {
        $this->observation_technicien = $observation_technicien;

        return $this;
    }

    public function getSolutionApportee(): ?string
    {
        return $this->solution_apportee;
    }

    public function setSolutionApportee(string $solution_apportee): self
    {
        $this->solution_apportee = $solution_apportee;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(\DateTimeInterface $date_sortie): self
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function getStatusTicket(): ?string
    {
        return $this->status_ticket;
    }

    public function setStatusTicket(string $status_ticket): self
    {
        $this->status_ticket = $status_ticket;

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setTicket($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getTicket() === $this) {
                $notification->setTicket(null);
            }
        }

        return $this;
    }

    public function getTypeUrgence(): ?string
    {
        return $this->type_urgence;
    }

    public function setTypeUrgence(string $type_urgence): self
    {
        $this->type_urgence = $type_urgence;

        return $this;
    }

    public function getStatutMatos(): ?string
    {
        return $this->statut_matos;
    }

    public function setStatutMatos(string $statut_matos): self
    {
        $this->statut_matos = $statut_matos;

        return $this;
    }
}
