<?php

namespace App\Entity;

use App\Repository\CaracteristiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaracteristiqueRepository::class)]
class Caracteristique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'caracteristique', targetEntity: CaracteristiquePerso::class)]
    private Collection $caracteristiquePersos;

    #[ORM\OneToMany(mappedBy: 'caracteristique', targetEntity: CompetenceInflueCarac::class)]
    private Collection $competenceInflueCaracs;

    public function __construct()
    {
        $this->caracteristiquePersos = new ArrayCollection();
        $this->competenceInflueCaracs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, CaracteristiquePerso>
     */
    public function getCaracteristiquePersos(): Collection
    {
        return $this->caracteristiquePersos;
    }

    public function addCaracteristiquePerso(CaracteristiquePerso $caracteristiquePerso): static
    {
        if (!$this->caracteristiquePersos->contains($caracteristiquePerso)) {
            $this->caracteristiquePersos->add($caracteristiquePerso);
            $caracteristiquePerso->setCaracteristique($this);
        }

        return $this;
    }

    public function removeCaracteristiquePerso(CaracteristiquePerso $caracteristiquePerso): static
    {
        if ($this->caracteristiquePersos->removeElement($caracteristiquePerso)) {
            // set the owning side to null (unless already changed)
            if ($caracteristiquePerso->getCaracteristique() === $this) {
                $caracteristiquePerso->setCaracteristique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompetenceInflueCarac>
     */
    public function getCompetenceInflueCaracs(): Collection
    {
        return $this->competenceInflueCaracs;
    }

    public function addCompetenceInflueCarac(CompetenceInflueCarac $competenceInflueCarac): static
    {
        if (!$this->competenceInflueCaracs->contains($competenceInflueCarac)) {
            $this->competenceInflueCaracs->add($competenceInflueCarac);
            $competenceInflueCarac->setCaracteristique($this);
        }

        return $this;
    }

    public function removeCompetenceInflueCarac(CompetenceInflueCarac $competenceInflueCarac): static
    {
        if ($this->competenceInflueCaracs->removeElement($competenceInflueCarac)) {
            // set the owning side to null (unless already changed)
            if ($competenceInflueCarac->getCaracteristique() === $this) {
                $competenceInflueCarac->setCaracteristique(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
