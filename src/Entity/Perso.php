<?php

namespace App\Entity;

use App\Repository\PersoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersoRepository::class)]
class Perso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $espece = null;

    #[ORM\Column(length: 255)]
    private ?string $origine = null;

    #[ORM\Column(length: 255)]
    private ?string $age = null;

    #[ORM\Column]
    private ?int $sante = null;

    #[ORM\Column(nullable: true)]
    private ?int $santeMax = null;

    #[ORM\Column(length: 255)]
    private ?string $taille = null;

    #[ORM\Column(length: 255)]
    private ?string $poids = null;

    #[ORM\Column(length: 255)]
    private ?string $sex = null;

    #[ORM\OneToMany(mappedBy: 'perso', targetEntity: CompetencePerso::class)]
    private Collection $competencePersos;

    #[ORM\OneToMany(mappedBy: 'perso', targetEntity: CaracteristiquePerso::class)]
    private Collection $caracteristiquePersos;

    #[ORM\ManyToOne(inversedBy: 'persos')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'persoFav')]
    private Collection $usersFav;

    #[ORM\OneToMany(mappedBy: 'perso', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'persos', targetEntity: Inventaire::class, orphanRemoval: true)]
    private Collection $inventaires;

    #[ORM\OneToMany(mappedBy: 'personnage', targetEntity: Action::class, orphanRemoval: true)]
    private Collection $actions;

    public function __construct()
    {
        $this->competencePersos = new ArrayCollection();
        $this->caracteristiquePersos = new ArrayCollection();
        $this->usersFav = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->inventaires = new ArrayCollection();
        $this->actions = new ArrayCollection();
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

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): static
    {
        $this->espece = $espece;

        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(string $origine): static
    {
        $this->origine = $origine;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getSante(): ?int
    {
        return $this->sante;
    }

    public function setSante(int $sante): static
    {
        $this->sante = $sante;

        return $this;
    }

    public function getSanteMax(): ?int
    {
        return $this->santeMax;
    }

    public function setSanteMax(?int $santeMax): static
    {
        $this->santeMax = $santeMax;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?string
    {
        return $this->poids;
    }

    public function setPoids(string $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): static
    {
        $this->sex = $sex;

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
            $competencePerso->setPerso($this);
        }

        return $this;
    }

    public function removeCompetencePerso(CompetencePerso $competencePerso): static
    {
        if ($this->competencePersos->removeElement($competencePerso)) {
            // set the owning side to null (unless already changed)
            if ($competencePerso->getPerso() === $this) {
                $competencePerso->setPerso(null);
            }
        }

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
            $caracteristiquePerso->setPerso($this);
        }

        return $this;
    }

    public function removeCaracteristiquePerso(CaracteristiquePerso $caracteristiquePerso): static
    {
        if ($this->caracteristiquePersos->removeElement($caracteristiquePerso)) {
            // set the owning side to null (unless already changed)
            if ($caracteristiquePerso->getPerso() === $this) {
                $caracteristiquePerso->setPerso(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user ): static
    {
        $this->user = $user;

        return $this;
    }

    
    /**
     * @return Collection<int, User>
     */
    public function getUsersFav(): Collection
    {
        return $this->usersFav;
    }
    
    public function addUsersFav(User $usersFav): static
    {
        if (!$this->usersFav->contains($usersFav)) {
            $this->usersFav->add($usersFav);
            $usersFav->addPersoFav($this);
        }
        
        return $this;
    }

    public function removeUsersFav(User $usersFav): static
    {
        if ($this->usersFav->removeElement($usersFav)) {
            $usersFav->removePersoFav($this);
        }
        
        return $this;
    }
    
    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }
    
    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setPerso($this);
        }
        
        return $this;
    }
    
    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPerso() === $this) {
                $commentaire->setPerso(null);
            }
        }
        
        return $this;
    }
    
    /**
     * @return Collection<int, Inventaire>
     */
    public function getInventaires(): Collection
    {
        return $this->inventaires;
    }

    public function addInventaire(Inventaire $inventaire): static
    {
        if (!$this->inventaires->contains($inventaire)) {
            $this->inventaires->add($inventaire);
            $inventaire->setPersos($this);
        }
        
        return $this;
    }
    
    public function removeInventaire(Inventaire $inventaire): static
    {
        if ($this->inventaires->removeElement($inventaire)) {
            // set the owning side to null (unless already changed)
            if ($inventaire->getPersos() === $this) {
                $inventaire->setPersos(null);
            }
        }

        return $this;
    }

    
    /**
     * @return Collection<int, Action>
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }
    
    public function addAction(Action $action): static
    {
        if (!$this->actions->contains($action)) {
            $this->actions->add($action);
            $action->setPersonnage($this);
        }
        
        return $this;
    }

    public function removeAction(Action $action): static
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getPersonnage() === $this) {
                $action->setPersonnage(null);
            }
        }
        
        return $this;
    }
    
    public function __toString()
    {
        return ucfirst($this->nom);
    }
}
