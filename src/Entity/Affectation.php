<?php

namespace App\Entity;

use App\Repository\AffectationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffectationRepository::class)]
class Affectation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\ManyToOne(inversedBy: 'affectations')]
    private ?SousStructure $sous_structure;

    #[ORM\ManyToOne(inversedBy: 'affectations')]
    private ?Poste $poste;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status_affectation;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_affectation;

    #[ORM\ManyToOne(inversedBy: 'affectations')]
    private ?StatutAgent $statut_agent;

    #[ORM\OneToMany(mappedBy: 'affectation', targetEntity: CartePro::class, orphanRemoval: true)]
    private Collection $cartePros;

    #[ORM\OneToMany(mappedBy: 'affectation', targetEntity: Attribution::class)]
    private Collection $attributions;

    #[ORM\OneToMany(mappedBy: 'affectation', targetEntity: User::class, orphanRemoval: true)]
    private Collection $users;


    public function __construct()
    {
        $this->cartePros = new ArrayCollection();
        $this->attributions = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSousStructure(): ?SousStructure
    {
        return $this->sous_structure;
    }

    public function setSousStructure(?SousStructure $sous_structure): static
    {
        $this->sous_structure = $sous_structure;

        return $this;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getStatusAffectation(): ?string
    {
        return $this->status_affectation;
    }

    public function setStatusAffectation(?string $status_affectation): static
    {
        $this->status_affectation = $status_affectation;

        return $this;
    }

    public function getDateAffectation(): ?\DateTimeInterface
    {
        return $this->date_affectation;
    }

    public function setDateAffectation(\DateTimeInterface $date_affectation): static
    {
        $this->date_affectation = $date_affectation;

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

    /**
     * @return Collection<int, CartePro>
     */
    public function getCartePros(): Collection
    {
        return $this->cartePros;
    }

    public function addCartePro(CartePro $cartePro): static
    {
        if (!$this->cartePros->contains($cartePro)) {
            $this->cartePros->add($cartePro);
            $cartePro->setAffectation($this);
        }

        return $this;
    }

    public function removeCartePro(CartePro $cartePro): static
    {
        if ($this->cartePros->removeElement($cartePro)) {
            // set the owning side to null (unless already changed)
            if ($cartePro->getAffectation() === $this) {
                $cartePro->setAffectation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Attribution>
     */
    public function getAttributions(): Collection
    {
        return $this->attributions;
    }

    public function addAttribution(Attribution $attribution): static
    {
        if (!$this->attributions->contains($attribution)) {
            $this->attributions->add($attribution);
            $attribution->setAffectation($this);
        }

        return $this;
    }

    public function removeAttribution(Attribution $attribution): static
    {
        if ($this->attributions->removeElement($attribution)) {
            // set the owning side to null (unless already changed)
            if ($attribution->getAffectation() === $this) {
                $attribution->setAffectation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setAffectation($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAffectation() === $this) {
                $user->setAffectation(null);
            }
        }

        return $this;
    }
}
