<?php

namespace App\Entity;

use App\Repository\TpaTasksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TpaTasksRepository::class)]
class TpaTasks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $taskName = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $taskCreateAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $taskDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $tpaDescription = null;

    #[ORM\Column(nullable: true)]
    private ?int $taskReminder = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $taskStartAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $taskEndAt = null;

    #[ORM\ManyToOne(inversedBy: 'usersTasksEmail')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TpaUsers $users = null;

    /**
     * @var Collection<int, TpaSubtasks>
     */
    #[ORM\OneToMany(targetEntity: TpaSubtasks::class, mappedBy: 'tasks', orphanRemoval: true)]
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskName(): ?string
    {
        return $this->taskName;
    }

    public function setTaskName(string $taskName): static
    {
        $this->taskName = $taskName;

        return $this;
    }

    public function getTaskCreateAt(): ?\DateTimeImmutable
    {
        return $this->taskCreateAt;
    }

    public function setTaskCreateAt(\DateTimeImmutable $taskCreateAt): static
    {
        $this->taskCreateAt = $taskCreateAt;

        return $this;
    }

    public function getTaskDescription(): ?string
    {
        return $this->taskDescription;
    }

    public function setTaskDescription(string $taskDescription): static
    {
        $this->taskDescription = $taskDescription;

        return $this;
    }

    public function getTpaDescription(): ?string
    {
        return $this->tpaDescription;
    }

    public function setTpaDescription(?string $tpaDescription): static
    {
        $this->tpaDescription = $tpaDescription;

        return $this;
    }

    public function getTaskReminder(): ?int
    {
        return $this->taskReminder;
    }

    public function setTaskReminder(?int $taskReminder): static
    {
        $this->taskReminder = $taskReminder;

        return $this;
    }

    public function getTaskStartAt(): ?\DateTimeImmutable
    {
        return $this->taskStartAt;
    }

    public function setTaskStartAt(?\DateTimeImmutable $taskStartAt): static
    {
        $this->taskStartAt = $taskStartAt;

        return $this;
    }

    public function getTaskEndAt(): ?\DateTimeImmutable
    {
        return $this->taskEndAt;
    }

    public function setTaskEndAt(?\DateTimeImmutable $taskEndAt): static
    {
        $this->taskEndAt = $taskEndAt;

        return $this;
    }

    public function getUsers(): ?TpaUsers
    {
        return $this->users;
    }

    public function setUsers(?TpaUsers $users): static
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, TpaSubtasks>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(TpaSubtasks $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setTasks($this);
        }

        return $this;
    }

    public function removeTask(TpaSubtasks $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getTasks() === $this) {
                $task->setTasks(null);
            }
        }

        return $this;
    }
}