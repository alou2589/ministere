<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type:"json")]
    private $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbConnect = null;

    #[ORM\OneToMany(mappedBy: 'compte', targetEntity: Historiques::class, orphanRemoval: true)]
    private Collection $historiques;

    #[ORM\OneToMany(mappedBy: 'info_technicien', targetEntity: Technicien::class, orphanRemoval: true)]
    private Collection $techniciens;

    #[ORM\OneToMany(mappedBy: 'destinataire', targetEntity: Messages::class, orphanRemoval: true)]
    private Collection $destinataires;

    #[ORM\OneToMany(mappedBy: 'expediteur', targetEntity: Messages::class, orphanRemoval: true)]
    private Collection $expediteurs;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Affectation $affectation = null;

    #[ORM\OneToMany(mappedBy: 'operateur', targetEntity: CongeAbsence::class)]
    private Collection $congeAbsences;



    public function __construct()
    {
        $this->historiques = new ArrayCollection();
        $this->techniciens = new ArrayCollection();
        $this->destinataires = new ArrayCollection();
        $this->expediteurs = new ArrayCollection();
        $this->congeAbsences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = '';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getNbConnect(): ?int
    {
        return $this->nbConnect;
    }

    public function setNbConnect(?int $nbConnect): self
    {
        $this->nbConnect = $nbConnect;

        return $this;
    }
    /**
     * @return Collection<int, Historiques>
     */
    public function getHistoriques(): Collection
    {
        return $this->historiques;
    }

    public function addHistorique(Historiques $historique): self
    {
        if (!$this->historiques->contains($historique)) {
            $this->historiques->add($historique);
            $historique->setCompte($this);
        }

        return $this;
    }

    public function removeHistorique(Historiques $historique): self
    {
        if ($this->historiques->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getCompte() === $this) {
                $historique->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Technicien>
     */
    public function getTechniciens(): Collection
    {
        return $this->techniciens;
    }

    public function addTechnicien(Technicien $technicien): self
    {
        if (!$this->techniciens->contains($technicien)) {
            $this->techniciens->add($technicien);
            $technicien->setInfoTechnicien($this);
        }

        return $this;
    }

    public function removeTechnicien(Technicien $technicien): self
    {
        if ($this->techniciens->removeElement($technicien)) {
            // set the owning side to null (unless already changed)
            if ($technicien->getInfoTechnicien() === $this) {
                $technicien->setInfoTechnicien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getdestinataires(): Collection
    {
        return $this->destinataires;
    }

    public function adddestinataire(Messages $destinataire): self
    {
        if (!$this->destinataires->contains($destinataire)) {
            $this->destinataires->add($destinataire);
            $destinataire->setDestinataire($this);
        }

        return $this;
    }

    public function removedestinataire(Messages $destinataire): self
    {
        if ($this->destinataires->removeElement($destinataire)) {
            // set the owning side to null (unless already changed)
            if ($destinataire->getDestinataire() === $this) {
                $destinataire->setDestinataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getExpediteurs(): Collection
    {
        return $this->expediteurs;
    }

    public function addExpediteur(Messages $expediteur): self
    {
        if (!$this->expediteurs->contains($expediteur)) {
            $this->expediteurs->add($expediteur);
            $expediteur->setExpediteur($this);
        }

        return $this;
    }

    public function removeExpediteur(Messages $expediteur): self
    {
        if ($this->expediteurs->removeElement($expediteur)) {
            // set the owning side to null (unless already changed)
            if ($expediteur->getExpediteur() === $this) {
                $expediteur->setExpediteur(null);
            }
        }

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

    /**
     * @return Collection<int, CongeAbsence>
     */
    public function getCongeAbsences(): Collection
    {
        return $this->congeAbsences;
    }

    public function addCongeAbsence(CongeAbsence $congeAbsence): static
    {
        if (!$this->congeAbsences->contains($congeAbsence)) {
            $this->congeAbsences->add($congeAbsence);
            $congeAbsence->setOperateur($this);
        }

        return $this;
    }

    public function removeCongeAbsence(CongeAbsence $congeAbsence): static
    {
        if ($this->congeAbsences->removeElement($congeAbsence)) {
            // set the owning side to null (unless already changed)
            if ($congeAbsence->getOperateur() === $this) {
                $congeAbsence->setOperateur(null);
            }
        }

        return $this;
    }

}
