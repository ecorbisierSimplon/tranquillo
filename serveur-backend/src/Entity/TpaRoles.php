<?php

namespace App\Entity;

use App\Repository\TpaRolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TpaRolesRepository::class)]
#[ORM\UniqueConstraint(name: "tpa_roles_code_ukey", columns: ["role_code"])]
#[ORM\UniqueConstraint(name: "tpa_roles_name_ukey", columns: ["role_name"])]
#[ORM\Index(name: "tpa_roles_code_ikey", columns: ["role_code"])]
class TpaRoles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['roles.index'])]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Groups(['users.index', 'roles.index'])]
    private ?string $roleCode = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Groups(['users.show', 'roles.show'])]
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
