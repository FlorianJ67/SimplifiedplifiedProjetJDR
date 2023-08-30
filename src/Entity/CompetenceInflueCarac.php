<?php

namespace App\Entity;

use App\Repository\CompetenceInflueCaracRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceInflueCaracRepository::class)]
class CompetenceInflueCarac
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $valeurBonus = null;

    #[ORM\ManyToOne(inversedBy: 'competenceInflueCaracs')]
    private ?Competence $competence = null;

    #[ORM\ManyToOne(inversedBy: 'competenceInflueCaracs')]
    private ?Caracteristique $caracteristique = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeurBonus(): ?string
    {
        return $this->valeurBonus;
    }

    public function setValeurBonus(string $valeurBonus): static
    {
        $this->valeurBonus = $valeurBonus;

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

    public function getCaracteristique(): ?Caracteristique
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(?Caracteristique $caracteristique): static
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }

    public function __toString()
    {
        $bonus = str_replace(' ', '',$valueOnly);
        $valueOnly = substr($bonus, 1);
        $bonusType = substr($bonus, 0, 1);
        if($bonusType == "x" || $bonusType == "*") {
            $jsp = "fois";
        }
        if($bonusType == "+" ) {
            $jsp = "plus";
        }
        return $this->caracteristique . " " .$jsp. " " . $valueOnly . $this->competence;
    }
}
