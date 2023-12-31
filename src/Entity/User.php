<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Perso::class)]
    private Collection $persos;

    #[ORM\ManyToMany(targetEntity: Perso::class, inversedBy: 'usersFav')]
    private Collection $persoFav;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commentaire::class)]
    private Collection $commentaires;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    public function __construct()
    {
        $this->persos = new ArrayCollection();
        $this->persoFav = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Perso>
     */
    public function getPersos(): Collection
    {
        return $this->persos;
    }

    public function addPerso(Perso $perso): static
    {
        if (!$this->persos->contains($perso)) {
            $this->persos->add($perso);
            $perso->setUser($this);
        }

        return $this;
    }

    public function removePerso(Perso $perso): static
    {
        if ($this->persos->removeElement($perso)) {
            // set the owning side to null (unless already changed)
            if ($perso->getUser() === $this) {
                $perso->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Perso>
     */
    public function getPersoFav(): Collection
    {
        return $this->persoFav;
    }

    public function addPersoFav(Perso $persoFav): static
    {
        if (!$this->persoFav->contains($persoFav)) {
            $this->persoFav->add($persoFav);
        }

        return $this;
    }

    public function removePersoFav(Perso $persoFav): static
    {
        $this->persoFav->removeElement($persoFav);

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
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function __toString() {
        return $this->pseudo;
    }

}
