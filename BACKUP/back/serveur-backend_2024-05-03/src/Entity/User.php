<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use App\Validator\TpaLength;
use App\Validator\UserRegex;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'tpa_users')]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'user_id')]
    #[UserRegex(regex: 'number', entity: 'user', field: 'id')]
    #[Assert\PositiveOrZero()]
    #[Groups(['users: read', 'users: create', 'tasks: all'])]
    private ?int $id = null;

    #[ORM\Column(name: 'email')]
    #[Assert\Email(message: 'error.user.email: Invalid email')]
    #[Assert\NotBlank(message: 'error.user.email: The key « email » must be a non-empty  string.')]
    #[TpaLength(min: 3, max: 180, entity: 'user', field: 'email')]
    #[Groups(['users: read', 'users: create'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(name: 'user_role')]
    #[Groups(['users: read', 'users: create'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(name: 'user_password')]
    #[UserRegex(regex: 'password', entity: 'user', field: 'password')]
    #[Assert\NotBlank(message: 'error.user.password: The key « password » must be a non-empty  string.')]
    #[TpaLength(min: 5, max: 50, entity: 'user', field: 'password')]
    #[Groups(['users: read', 'users: create', 'users:pass'])]
    private ?string $password = null;

    #[ORM\Column(name: 'lastname')]
    #[UserRegex(regex: 'name', entity: 'user', field: 'lastname')]
    #[Assert\NotBlank(message: 'error.user.lastname: The key « lastname » must be a non-empty  string.')]
    #[TpaLength(min: 5, max: 50, entity: 'user', field: 'lastname')]
    #[Groups(['users: read', 'users: create', 'users:pass'])]
    private ?string $lastname = null;

    #[ORM\Column(name: 'firstname')]
    #[UserRegex(regex: 'name', entity: 'user', field: 'firstname')]
    #[Assert\NotBlank(message: 'error.user.firstname: The key « firstname » must be a non-empty  string.')]
    #[TpaLength(min: 5, max: 50, entity: 'user', field: 'firstname')]
    #[Groups(['users: read', 'users: create', 'users:pass'])]
    private ?string $firstname = null;

    #[ORM\Column(name: 'user_create_at')]
    #[Assert\NotBlank(message: 'error.user.createAT: The key « createAt » must be a non-empty  string.')]
    #[Groups(['tasks: read', 'users: read', 'users: create'])]
    private ?\DateTimeImmutable $createAt = null;


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
     * Méthode getUsername qui permet de retourner le champ qui est utilisé pour l'authentification.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
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

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }
}
