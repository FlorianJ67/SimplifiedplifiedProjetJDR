<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'competence', targetEntity: CompetencePerso::class)]
    private Collection $competencePersos;

    #[ORM\OneToMany(mappedBy: 'competence', targetEntity: CompetenceInflueCarac::class)]
    private Collection $competenceInflueCaracs;

    public function __construct()
    {
        $this->competencePersos = new ArrayCollection();
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
     * @return Collection<int, CompetencePerso>
     */
    public function getCompetencePersos(): Collection
    {
        return $this->competencePersos;
    }

    public function addCompetencePerso(CompetencePerso $competencePerso): static
    {
        if (!$this->competencePersos->contains($competencePerso)) {
            $this->competencePersos->add($competencePerso);
            $competencePerso->setCompetence($this);
        }

        return $this;
    }

    public function removeCompetencePerso(CompetencePerso $competencePerso): static
    {
        if ($this->competencePersos->removeElement($competencePerso)) {
            // set the owning side to null (unless already changed)
            if ($competencePerso->getCompetence() === $this) {
                $competencePerso->setCompetence(null);
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
            $competenceInflueCarac->setCompetence($this);
        }

        return $this;
    }

    public function removeCompetenceInflueCarac(CompetenceInflueCarac $competenceInflueCarac): static
    {
        if ($this->competenceInflueCaracs->removeElement($competenceInflueCarac)) {
            // set the owning side to null (unless already changed)
            if ($competenceInflueCarac->getCompetence() === $this) {
                $competenceInflueCarac->setCompetence(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return ucfirst($this->nom);
    }
}
