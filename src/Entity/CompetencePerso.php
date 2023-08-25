<?php

namespace App\Entity;

use App\Repository\CompetencePersoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetencePersoRepository::class)]
class CompetencePerso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $valeur = null;

    #[ORM\ManyToOne(inversedBy: 'competencePersos')]
    private ?Competence $competence = null;

    #[ORM\ManyToOne(inversedBy: 'competencePersos')]
    private ?Perso $perso = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): static
    {
        $this->competence = $competence;

        return $this;
    }

    public function getPerso(): ?Perso
    {
        return $this->perso;
    }

    public function setPerso(?Perso $perso): static
    {
        $this->perso = $perso;

        return $this;
    }
    public function __toString()
    {
        return $this->valeur;
    }
}
