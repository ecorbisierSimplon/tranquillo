<?php

namespace App\Entity;

use App\Repository\TpaUsersRepository;
use App\Validator\UserRegex;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: TpaUsersRepository::class)]
#[ORM\UniqueConstraint(name: 'tpa_users_email_ukey', fields: ['email'])]
class TpaUsers implements UserInterface, PasswordAuthenticatedUserInterface
{



    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['users:index', 'tasks:index'])]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\Email]
    #[Groups(['users:index', 'users:create', 'users:show', 'users:update'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['users:index', 'users:create', 'admin:edit'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(length: 255)]
    #[Groups(['users:create', 'users:pass'])]
    #[UserRegex(regex: 'password', field: 'password')]
    private ?string $password = null;

    // private ?string $hashPassword = null;


    #[ORM\Column(length: 50)]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Votre nom doit avoir un minimum de {{ limit }} caractères.',
        maxMessage: 'Votre nom ne doit pas dépasser {{ limit }} caractères.'
    )]
    #[Groups(['users:create', 'users:show', 'users:update'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Votre prénom doit avoir un minimum de {{ limit }} caractères.',
        maxMessage: 'Votre prénom ne doit pas dépasser {{ limit }} caractères.'
    )]
    #[Groups(['users:create', 'users:show', 'users:update'])]
    private ?string $firstname = null;

    #[ORM\Column]
    #[Groups(['users:at', 'users:show'])]
    private ?\DateTimeImmutable $userCreateAt = null;

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

    public function getUserCreateAt(): ?\DateTimeImmutable
    {
        return $this->userCreateAt;
    }

    public function setUserCreateAt(\DateTimeImmutable $userCreateAt): static
    {
        $this->userCreateAt = $userCreateAt;

        return $this;
    }
}
