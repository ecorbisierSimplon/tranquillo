<?php

namespace App\Entity;

use App\Repository\TpaUsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TpaUsersRepository::class)]
#[UniqueEntity('email')]
class TpaUsers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    private ?string $userPassword = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $userCreateAt = null;

    /**
     * @var Collection<int, TpaTasks>
     */
    #[ORM\OneToMany(targetEntity: TpaTasks::class, mappedBy: 'users')]
    private Collection $usersTasksEmail;

    #[ORM\ManyToOne(inversedBy: 'roles')]
    private ?TpaRoles $roles = null;

    public function __construct()
    {
        $this->usersTasksEmail = new ArrayCollection();
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
    public function getUsersTasksEmail(): Collection
    {
        return $this->usersTasksEmail;
    }

    public function addUsersTasksEmail(TpaTasks $usersTasksEmail): static
    {
        if (!$this->usersTasksEmail->contains($usersTasksEmail)) {
            $this->usersTasksEmail->add($usersTasksEmail);
            $usersTasksEmail->setUsers($this);
        }

        return $this;
    }

    public function removeUsersTasksEmail(TpaTasks $usersTasksEmail): static
    {
        if ($this->usersTasksEmail->removeElement($usersTasksEmail)) {
            // set the owning side to null (unless already changed)
            if ($usersTasksEmail->getUsers() === $this) {
                $usersTasksEmail->setUsers(null);
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