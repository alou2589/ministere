<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
#[UniqueEntity(fields: ['sn_matos'], message: 'Ce numéro de série existe déjà !')]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $modele_matos = null;

    #[ORM\Column(length: 255)]
    private ?string $sn_matos = null;



    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_reception = null;

    #[ORM\ManyToOne(inversedBy: 'materiels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeMateriel $type_matos = null;

    #[ORM\OneToMany(mappedBy: 'matos', targetEntity: Attribution::class, orphanRemoval: true)]
    private Collection $attributions;

    #[ORM\OneToMany(mappedBy: 'matos', targetEntity: Ticket::class, orphanRemoval: true)]
    private Collection $tickets;

    #[ORM\ManyToOne(inversedBy: 'materiels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseur $fournisseur = null;

    #[ORM\ManyToOne(inversedBy: 'materiels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MarqueMatos $marque_matos = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $info_matos = null;

    #[ORM\OneToMany(mappedBy: 'matos', targetEntity: Maintenance::class, orphanRemoval: true)]
    private Collection $maintenances;




    public function __construct()
    {
        $this->attributions = new ArrayCollection();
        $this->tickets = new ArrayCollection();
        $this->maintenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModeleMatos(): ?string
    {
        return $this->modele_matos;
    }

    public function setModeleMatos(string $modele_matos): self
    {
        $this->modele_matos = $modele_matos;

        return $this;
    }

    public function getSnMatos(): ?string
    {
        return $this->sn_matos;
    }

    public function setSnMatos(string $sn_matos): self
    {
        $this->sn_matos = $sn_matos;

        return $this;
    }




    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->date_reception;
    }

    public function setDateReception(\DateTimeInterface $date_reception): self
    {
        $this->date_reception = $date_reception;

        return $this;
    }

    public function getTypeMatos(): ?TypeMateriel
    {
        return $this->type_matos;
    }

    public function setTypeMatos(?TypeMateriel $type_matos): self
    {
        $this->type_matos = $type_matos;

        return $this;
    }


    /**
     * @return Collection<int, Attribution>
     */
    public function getAttributions(): Collection
    {
        return $this->attributions;
    }

    public function addAttribution(Attribution $attribution): self
    {
        if (!$this->attributions->contains($attribution)) {
            $this->attributions->add($attribution);
            $attribution->setMatos($this);
        }

        return $this;
    }

    public function removeAttribution(Attribution $attribution): self
    {
        if ($this->attributions->removeElement($attribution)) {
            // set the owning side to null (unless already changed)
            if ($attribution->getMatos() === $this) {
                $attribution->setMatos(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setMatos($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getMatos() === $this) {
                $ticket->setMatos(null);
            }
        }

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getMarqueMatos(): ?MarqueMatos
    {
        return $this->marque_matos;
    }

    public function setMarqueMatos(?MarqueMatos $marque_matos): self
    {
        $this->marque_matos = $marque_matos;

        return $this;
    }

    public function getInfoMatos(): ?string
    {
        return $this->info_matos;
    }

    public function setInfoMatos(string $info_matos): self
    {
        $this->info_matos = $info_matos;

        return $this;
    }

    /**
     * @return Collection<int, Maintenance>
     */
    public function getMaintenances(): Collection
    {
        return $this->maintenances;
    }

    public function addMaintenance(Maintenance $maintenance): static
    {
        if (!$this->maintenances->contains($maintenance)) {
            $this->maintenances->add($maintenance);
            $maintenance->setMatos($this);
        }

        return $this;
    }

    public function removeMaintenance(Maintenance $maintenance): static
    {
        if ($this->maintenances->removeElement($maintenance)) {
            // set the owning side to null (unless already changed)
            if ($maintenance->getMatos() === $this) {
                $maintenance->setMatos(null);
            }
        }

        return $this;
    }



}
