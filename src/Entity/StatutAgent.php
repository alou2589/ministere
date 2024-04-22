<?php

namespace App\Entity;

use App\Repository\StatutAgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutAgentRepository::class)]
#[UniqueEntity(fields: ['agent', 'matricule'], message: 'Cet agent existe déjà !')]
class StatutAgent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $echellon = null;

    #[ORM\Column(length: 255)]
    private ?string $grade = null;

    #[ORM\Column(length: 255)]
    private ?string $hierarchie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_prise_service = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_avancement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut_ministere = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $matricule = null;

    #[ORM\OneToMany(mappedBy: 'statut_agent', targetEntity: Affectation::class)]
    private Collection $affectations;

    #[ORM\ManyToOne(inversedBy: 'statutAgents')]
    private ?TypeAgent $type_agent = null;


    #[ORM\OneToMany(mappedBy: 'statut_agent', targetEntity: FichiersAgent::class, orphanRemoval: true)]
    private Collection $fichiersAgents;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fonction = null;

    #[ORM\ManyToOne(inversedBy: 'statutAgents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agent $agent = null;

    #[ORM\OneToMany(mappedBy: 'statut_agent', targetEntity: CongeAbsence::class, orphanRemoval: true)]
    private Collection $congeAbsences;

    public function __construct()
    {
        $this->affectations = new ArrayCollection();
        $this->fichiersAgents = new ArrayCollection();
        $this->congeAbsences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEchellon(): ?string
    {
        return $this->echellon;
    }

    public function setEchellon(string $echellon): self
    {
        $this->echellon = $echellon;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getHierarchie(): ?string
    {
        return $this->hierarchie;
    }

    public function setHierarchie(string $hierarchie): self
    {
        $this->hierarchie = $hierarchie;

        return $this;
    }

    public function getDatePriseService(): ?\DateTimeInterface
    {
        return $this->date_prise_service;
    }

    public function setDatePriseService(\DateTimeInterface $date_prise_service): self
    {
        $this->date_prise_service = $date_prise_service;

        return $this;
    }

    public function getDateAvancement(): ?\DateTimeInterface
    {
        return $this->date_avancement;
    }

    public function setDateAvancement(\DateTimeInterface $date_avancement): self
    {
        $this->date_avancement = $date_avancement;

        return $this;
    }

    public function getDateDebutMinistere(): ?\DateTimeInterface
    {
        return $this->date_debut_ministere;
    }

    public function setDateDebutMinistere(?\DateTimeInterface $date_debut_ministere): static
    {
        $this->date_debut_ministere = $date_debut_ministere;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * @return Collection<int, Affectation>
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): static
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations->add($affectation);
            $affectation->setStatutAgent($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): static
    {
        if ($this->affectations->removeElement($affectation)) {
            // set the owning side to null (unless already changed)
            if ($affectation->getStatutAgent() === $this) {
                $affectation->setStatutAgent(null);
            }
        }

        return $this;
    }

    public function getTypeAgent(): ?TypeAgent
    {
        return $this->type_agent;
    }

    public function setTypeAgent(?TypeAgent $type_agent): static
    {
        $this->type_agent = $type_agent;

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
            $fichiersAgent->setStatutAgent($this);
        }

        return $this;
    }

    public function removeFichiersAgent(FichiersAgent $fichiersAgent): static
    {
        if ($this->fichiersAgents->removeElement($fichiersAgent)) {
            // set the owning side to null (unless already changed)
            if ($fichiersAgent->getStatutAgent() === $this) {
                $fichiersAgent->setStatutAgent(null);
            }
        }

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): static
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): static
    {
        $this->agent = $agent;

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
            $congeAbsence->setStatutAgent($this);
        }

        return $this;
    }

    public function removeCongeAbsence(CongeAbsence $congeAbsence): static
    {
        if ($this->congeAbsences->removeElement($congeAbsence)) {
            // set the owning side to null (unless already changed)
            if ($congeAbsence->getStatutAgent() === $this) {
                $congeAbsence->setStatutAgent(null);
            }
        }

        return $this;
    }
}
