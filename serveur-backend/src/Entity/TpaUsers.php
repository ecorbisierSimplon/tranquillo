<?php

namespace App\Entity;

use App\Repository\TpaUsersRepository;
use App\Validator\TpaLength;
use App\Validator\UserRegex;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: TpaUsersRepository::class)]
#[ORM\Table(name: "Tpa_Users")]
class TpaUsers implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\Column(name: "user_id")]
    #[Assert\PositiveOrZero()]
    #[Groups(['users:index', 'tasks:index'])]
    private ?int $id = null;



    #[ORM\Column(name: "email")]
    #[TpaLength(min: 3, max: 50)]
    #[Assert\Email]
    #[Groups(['users:index', 'users:create', 'users:show', 'users:update'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(name: "roles_id")]
    #[Groups(['users:index', 'users:create', 'admin:edit'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(name: "user_password")]
    #[UserRegex(regex: 'password', field: 'password')]
    #[TpaLength(min: 5, max: 50)]
    #[Groups(['users:create', 'users:pass'])]
    private ?string $password = null;

    // private ?string $hashPassword = null;


    #[ORM\Column(name: "lastname")]
    #[UserRegex(regex: 'prénom', field: 'name')]
    #[TpaLength(min: 2, max: 50)]
    #[Groups(['users:create', 'users:show', 'users:update'])]
    private ?string $lastname = null;

    #[ORM\Column(name: "firstname")]
    #[UserRegex(regex: 'nom', field: 'name')]
    #[TpaLength(min: 3, max: 50)]
    #[Groups(['users:create', 'users:show', 'users:update'])]
    private ?string $firstname = null;

    #[ORM\Column(name: "user_create_at")]
    #[Assert\DateTime()]
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
