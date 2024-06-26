<?php

namespace App\Entity;

use App\Repository\TpaUsersRepository;
use App\Validator\UserRegex;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

use function Symfony\Component\Clock\now;

#[ORM\Entity(repositoryClass: TpaUsersRepository::class)]
#[ORM\UniqueConstraint(name: "tpa_users_email_ukey", columns: ["email"])]
#[ORM\Index(name: "tpa_users_email_ikey", columns: ["email"])]
#[ORM\Index(name: "tpa_roles_id_users_ikey", columns: ["roles_id"])]
#[ORM\Index(name: "tpa_users_create_at_ikey", columns: ["user_create_at"])]
class TpaUsers
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['users.index', 'tasks.index'])]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\Email]
    #[Groups(['users.index', 'tasks.show', 'users.create'])]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    #[UserRegex(regex: 'name', champ: 'prénom')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Votre prénom doit avoir un minimum de {{ limit }} caractères.',
        maxMessage: 'Votre prénom ne doit pas dépasser {{ limit }} caractères.'
    )]
    #[Groups(['users.show', 'users.create'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 50)]
    #[Groups(['users.show', 'users.create'])]
    #[UserRegex(regex: 'name', champ: 'nom')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Votre nom doit avoir un minimum de `{{ limit }}` caratères.',
        maxMessage: 'Votre nom ne doit pas dépasser `{{ limit }}` caractères.',
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    #[Groups(['users.secure', 'users.create'])]
    #[Assert\Length(
        min: 8,
        max: 50,
        minMessage: 'Votre mot de passe doit avoir un minimum de `{{ limit }}` caratères.',
        maxMessage: 'Votre mot de passe ne doit pas dépasser `{{ limit }}` caractères.',
    )]
    #[UserRegex(regex: 'password')]
    private ?string $userPassword = null;

    #[ORM\Column(type: "datetime_immutable", options: ["default" => "CURRENT_TIMESTAMP"])]
    #[Groups(['users.at'])]
    private ?\DateTimeImmutable $userCreateAt = null;

    /**
     * @var Collection<int, TpaTasks>
     */
    #[ORM\OneToMany(targetEntity: TpaTasks::class, mappedBy: 'users')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'roles')]
    #[Groups(['users.index', 'users.show'])]
    private ?TpaRoles $roles = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->userPassword;
    }

    public function setUserPassword(string $userPassword): static
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    public function getUserCreateAt(): ?\DateTimeImmutable
    {
        return $this->userCreateAt;
    }

    public function setUserCreateAt(\DateTimeImmutable $userCreateAt): static
    {
        $this->userCreateAt = $userCreateAt;

        return $this;
    }

    /**
     * @return Collection<int, TpaTasks>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUsers(TpaTasks $users): static
    {
        if (!$this->users->contains($users)) {
            $this->users->add($users);
            $users->setUsers($this);
        }

        return $this;
    }

    public function removeUsers(TpaTasks $users): static
    {
        if ($this->users->removeElement($users)) {
            // set the owning side to null (unless already changed)
            if ($users->getUsers() === $this) {
                $users->setUsers(null);
            }
        }

        return $this;
    }

    public function getRoles(): ?TpaRoles
    {
        return $this->roles;
    }

    public function setRoles(?TpaRoles $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
}
