<?php

namespace App\Entity;

use App\Repository\TypeFichierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeFichierRepository::class)]
#[UniqueEntity(fields: ['nom_type_fichier'], message: "Ce type de fichier existe déjà !")]
class TypeFichier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_type_fichier = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_type_fichier = null;

    #[ORM\OneToMany(mappedBy: 'type_fichier', targetEntity: FichiersAgent::class, orphanRemoval: true)]
    private Collection $fichiersAgents;

    public function __construct()
    {
        $this->fichiersAgents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeFichier(): ?string
    {
        return $this->nom_type_fichier;
    }

    public function setNomTypeFichier(string $nom_type_fichier): static
    {
        $this->nom_type_fichier = $nom_type_fichier;

        return $this;
    }

    public function getDescriptionTypeFichier(): ?string
    {
        return $this->description_type_fichier;
    }

    public function setDescriptionTypeFichier(?string $description_type_fichier): static
    {
        $this->description_type_fichier = $description_type_fichier;

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
            $fichiersAgent->setTypeFichier($this);
        }

        return $this;
    }

    public function removeFichiersAgent(FichiersAgent $fichiersAgent): static
    {
        if ($this->fichiersAgents->removeElement($fichiersAgent)) {
            // set the owning side to null (unless already changed)
            if ($fichiersAgent->getTypeFichier() === $this) {
                $fichiersAgent->setTypeFichier(null);
            }
        }

        return $this;
    }
}
