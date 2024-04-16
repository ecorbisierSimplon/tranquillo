<?php

namespace App\Entity;

use App\Repository\TpaRolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TpaRolesRepository::class)]
class TpaRoles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $roleCode = null;

    #[ORM\Column(length: 50)]
    private ?string $roleName = null;

    /**
     * @var Collection<int, TpaUsers>
     */
    #[ORM\OneToMany(targetEntity: TpaUsers::class, mappedBy: 'roles')]
    private Collection $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleCode(): ?string
    {
        return $this->roleCode;
    }

    public function setRoleCode(string $roleCode): static
    {
        $this->roleCode = $roleCode;

        return $this;
    }

    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    public function setRoleName(string $roleName): static
    {
        $this->roleName = $roleName;

        return $this;
    }

    /**
     * @return Collection<int, TpaUsers>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(TpaUsers $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->setRoles($this);
        }

        return $this;
    }

    public function removeRole(TpaUsers $role): static
    {
        if ($this->roles->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getRoles() === $this) {
                $role->setRoles(null);
            }
        }

        return $this;
    }
}