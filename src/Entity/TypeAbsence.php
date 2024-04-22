<?php

namespace App\Entity;

use App\Repository\TypeAbsenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeAbsenceRepository::class)]
class TypeAbsence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_type_absence = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'type_absence', targetEntity: CongeAbsence::class, orphanRemoval: true)]
    private Collection $congeAbsences;

    public function __construct()
    {
        $this->congeAbsences = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeAbsence(): ?string
    {
        return $this->nom_type_absence;
    }

    public function setNomTypeAbsence(string $nom_type_absence): static
    {
        $this->nom_type_absence = $nom_type_absence;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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
            $congeAbsence->setTypeAbsence($this);
        }

        return $this;
    }

    public function removeCongeAbsence(CongeAbsence $congeAbsence): static
    {
        if ($this->congeAbsences->removeElement($congeAbsence)) {
            // set the owning side to null (unless already changed)
            if ($congeAbsence->getTypeAbsence() === $this) {
                $congeAbsence->setTypeAbsence(null);
            }
        }

        return $this;
    }


}
