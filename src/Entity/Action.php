<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'actions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Perso $personnage = null;

    #[ORM\ManyToOne]
    private ?Caracteristique $caracteristique = null;

    #[ORM\ManyToOne]
    private ?Competence $competence = null;

    #[ORM\ManyToOne]
    private ?Objet $objet = null;

    #[ORM\Column(length: 255)]
    private ?string $dice = null;

    #[ORM\Column]
    private ?int $diceScore = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonnage(): ?Perso
    {
        return $this->personnage;
    }

    public function setPersonnage(?Perso $personnage): static
    {
        $this->personnage = $personnage;

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

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): static
    {
        $this->competence = $competence;

        return $this;
    }

    public function getObjet(): ?Objet
    {
        return $this->objet;
    }

    public function setObjet(?Objet $objet): static
    {
        $this->objet = $objet;

        return $this;
    }

    public function getDice(): ?string
    {
        return $this->dice;
    }

    public function setDice(string $dice): static
    {
        $this->dice = $dice;

        return $this;
    }

    public function getDiceScore(): ?int
    {
        return $this->diceScore;
    }

    public function setDiceScore(int $diceScore): static
    {
        $this->diceScore = $diceScore;

        return $this;
    }
}
