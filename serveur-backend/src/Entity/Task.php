<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TaskRepository;
use App\Validator\TpaLength;
use App\Validator\UserRegex;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Table(name: "tpa_tasks")]
#[ApiResource]
class Task
{
    // Le point d'interrogation (?) avant le type dans cette déclaration de propriété en PHP signifie
    // que la variable peut également être null.
    // En d'autres termes, la propriété peut soit contenir une valeur entière, soit être null.
    // Cela est souvent utilisé pour indiquer qu'une valeur peut être absente ou non définie dans certains contextes.
    // C'est couramment utilisé lorsque nous avons besoin de distinguer entre une valeur valide et l'absence de valeur.

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "task_id")]
    #[Assert\PositiveOrZero()]
    #[UserRegex(regex: 'number', entity: "task", field: "id")]
    #[Groups(['tasks: read', 'tasks: create'])]
    private ?int $id = null;

    #[ORM\Column(name: "task_name")]
    #[Assert\NotBlank(message: 'error.task.name: The key « name » must be a non-empty  string.')]
    #[TpaLength(min: 5, max: 50, entity: "task", field: "name")]
    #[Groups(['tasks: read', 'tasks: create'])]
    private ?string $name = null;

    #[ORM\Column(name: "task_description")]
    #[Assert\NoSuspiciousCharacters()]
    #[Groups(['tasks: read', 'tasks: create'])]
    private ?string $description = null;

    #[ORM\Column(name: "task_reminder")]
    #[UserRegex(regex: 'number', information: "Reminder task is calculated in minute(s)", entity: "task", field: "reminder")]
    #[Assert\PositiveOrZero()]
    #[Groups(['tasks: read', 'tasks: create'])]
    private ?int $reminder = null;

    #[ORM\Column(name: "task_start_at")]
    #[Groups(['tasks: read', 'tasks: create'])]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column(name: "task_end_at")]
    #[Groups(['tasks: read', 'tasks: create'])]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column(name: "task_create_at")]
    #[Assert\NotBlank(message: 'error.task.createAt: The key « createAt » must be a non-empty  string.')]
    #[Groups(['tasks: read', 'tasks: create'])]
    private ?\DateTimeImmutable $createAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getReminder(): ?int
    {
        return $this->reminder;
    }

    public function setReminder(?int $reminder): static
    {
        $this->reminder = $reminder;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeImmutable  $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeImmutable  $endAt): static
    {
        $this->endAt = $endAt;

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
