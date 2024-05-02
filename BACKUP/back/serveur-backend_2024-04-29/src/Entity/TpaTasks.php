<?php

namespace App\Entity;

use App\Repository\TpaTasksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TpaTasksRepository::class)]
#[ORM\UniqueConstraint(name: "tpa_tasks_name_roles_id_ukey", columns: ["task_name", "users_id"])]
#[UniqueEntity(
    fields: ['task_name', 'roles_id'],
    message: 'Enregistrement impossible, tache déjà existante.',
    errorPath: 'roles_id',
)]
#[ORM\Index(name: "tpa_users_id_tasks_ikey", columns: ["users_id"])]
#[ORM\Index(name: "tpa_tasks_name_ikey", columns: ["task_name"])]
#[ORM\Index(name: "tpa_tasks_create_at_ikey", columns: ["task_create_at"])]
class TpaTasks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tasks.index', 'subtasks.index'])]
    private ?int $id = null;

    #[Groups(['tasks.show', 'subtasks.show'])]
    #[ORM\Column(length: 100)]
    private ?string $taskName = null;

    #[ORM\Column(type: "datetime_immutable", options: ["default" => "CURRENT_TIMESTAMP"])]
    #[Groups(['tasks.at'])]
    private ?\DateTimeImmutable $taskCreateAt = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['tasks.show'])]
    private ?string $taskDescription = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['tasks.technic'])]
    private ?int $taskReminder = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['tasks.technic'])]
    private ?\DateTimeImmutable $taskStartAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['tasks.technic'])]
    private ?\DateTimeImmutable $taskEndAt = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['tasks.index', 'tasks.show'])]
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
