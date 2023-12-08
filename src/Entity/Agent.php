<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
#[UniqueEntity(fields: ['matricule'], message: 'Cette matricule existe déjà !')]
class Agent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu_naissance = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    private ?string $matricule = null;

    #[ORM\Column(length: 255)]
    private ?string $fonction = null;

    #[ORM\ManyToOne(inversedBy: 'agents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Poste $poste = null;

    #[ORM\ManyToOne(inversedBy: 'agents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SousStructure $sous_structure = null;

    #[ORM\OneToMany(mappedBy: 'agent', targetEntity: StatutAgent::class, orphanRemoval: true)]
    private Collection $statutAgents;

    #[ORM\OneToMany(mappedBy: 'agent', targetEntity: User::class, orphanRemoval: true)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'agent', targetEntity: CartePro::class, orphanRemoval: true)]
    private Collection $cartePros;

    #[ORM\ManyToOne(inversedBy: 'agents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeAgent $type_agent = null;

    #[ORM\OneToMany(mappedBy: 'agent', targetEntity: Attribution::class, orphanRemoval: true)]
    private Collection $attributions;

    #[ORM\OneToMany(mappedBy: 'agent', targetEntity: FichiersAgent::class, orphanRemoval: true)]
    private Collection $fichiersAgents;

    public function __construct()
    {
        $this->statutAgents = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->cartePros = new ArrayCollection();
        $this->attributions = new ArrayCollection();
        $this->fichiersAgents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieu_naissance;
    }

    public function setLieuNaissance(string $lieu_naissance): self
    {
        $this->lieu_naissance = $lieu_naissance;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getSousStructure(): ?SousStructure
    {
        return $this->sous_structure;
    }

    public function setSousStructure(?SousStructure $sous_structure): self
    {
        $this->sous_structure = $sous_structure;

        return $this;
    }



    /**
     * @return Collection<int, StatutAgent>
     */
    public function getStatutAgents(): Collection
    {
        return $this->statutAgents;
    }

    public function addStatutAgent(StatutAgent $statutAgent): self
    {
        if (!$this->statutAgents->contains($statutAgent)) {
            $this->statutAgents->add($statutAgent);
            $statutAgent->setAgent($this);
        }

        return $this;
    }

    public function removeStatutAgent(StatutAgent $statutAgent): self
    {
        if ($this->statutAgents->removeElement($statutAgent)) {
            // set the owning side to null (unless already changed)
            if ($statutAgent->getAgent() === $this) {
                $statutAgent->setAgent(null);
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

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setAgent($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAgent() === $this) {
                $user->setAgent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CartePro>
     */
    public function getCartePros(): Collection
    {
        return $this->cartePros;
    }

    public function addCartePro(CartePro $cartePro): self
    {
        if (!$this->cartePros->contains($cartePro)) {
            $this->cartePros->add($cartePro);
            $cartePro->setAgent($this);
        }

        return $this;
    }

    public function removeCartePro(CartePro $cartePro): self
    {
        if ($this->cartePros->removeElement($cartePro)) {
            // set the owning side to null (unless already changed)
            if ($cartePro->getAgent() === $this) {
                $cartePro->setAgent(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getPrenom() . ' ' . $this->getNom() . ' ' . $this->getMatricule();
    }

    public function getTypeAgent(): ?TypeAgent
    {
        return $this->type_agent;
    }

    public function setTypeAgent(?TypeAgent $type_agent): self
    {
        $this->type_agent = $type_agent;

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
            $attribution->setAgent($this);
        }

        return $this;
    }

    public function removeAttribution(Attribution $attribution): self
    {
        if ($this->attributions->removeElement($attribution)) {
            // set the owning side to null (unless already changed)
            if ($attribution->getAgent() === $this) {
                $attribution->setAgent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FichiersAgent>
     */
    public function getFichiersAgents(): Collection
    {
        return $this->fichiersAgents;
    }

    public function addFichiersAgent(FichiersAgent $fichiersAgent): static
    {
        if (!$this->fichiersAgents->contains($fichiersAgent)) {
            $this->fichiersAgents->add($fichiersAgent);
            $fichiersAgent->setAgent($this);
        }

        return $this;
    }

    public function removeFichiersAgent(FichiersAgent $fichiersAgent): static
    {
        if ($this->fichiersAgents->removeElement($fichiersAgent)) {
            // set the owning side to null (unless already changed)
            if ($fichiersAgent->getAgent() === $this) {
                $fichiersAgent->setAgent(null);
            }
        }

        return $this;
    }
}
