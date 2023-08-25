<?php

namespace App\Entity;

use App\Repository\CaracteristiquePersoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaracteristiquePersoRepository::class)]
class CaracteristiquePerso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $valeur = null;

    #[ORM\ManyToOne(inversedBy: 'caracteristiquePersos')]
    private ?Caracteristique $caracteristique = null;

    #[ORM\ManyToOne(inversedBy: 'caracteristiquePersos')]
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

    public function getCaracteristique(): ?Caracteristique
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(?Caracteristique $caracteristique): static
    {
        $this->caracteristique = $caracteristique;

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
