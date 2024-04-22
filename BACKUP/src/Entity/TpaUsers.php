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
    #[Groups(['users.index', 'tasks.index'])]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\Email]
    #[Groups(['users.index', 'tasks.show', 'users.create'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    // #[Groups(['users.secure', 'users.create'])]
    // #[Assert\Length(
    //     min: 8,
    //     max: 50,
    //     minMessage: 'Votre mot de passe doit avoir un minimum de `{{ limit }}` caratères.',
    //     maxMessage: 'Votre mot de passe ne doit pas dépasser `{{ limit }}` caractères.',
    // )]
    // #[UserRegex(regex: 'password')]

    #[ORM\Column]
    private ?string $password = null;

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

    #[ORM\Column]
    #[Groups(['users.at'])]
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
