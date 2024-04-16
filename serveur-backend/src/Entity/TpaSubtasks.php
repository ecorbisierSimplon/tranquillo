<?php

namespace App\Entity;

use App\Repository\TpaSubtasksRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/* `UniqueEntity` is a Symfony validation constraint that ensures the uniqueness of a combination of
fields in the database table. In the provided code snippet, the `UniqueEntity` constraint is
applied to the `TpaSubtasks` entity with the fields `subtaskName` and `subtaskCreateAt`. This
means that the combination of values in these two fields must be unique in the database table, and
if a duplicate entry is attempted to be saved, a validation error with the message 'This port is
already in use on that host.' will be triggered. */

#[ORM\Entity(repositoryClass: TpaSubtasksRepository::class)]
#[ORM\UniqueConstraint(name: "tpa_subtasks_name_tasks_id_ukey",columns: ['subtask_name', 'tasks_id'])]
#[ORM\Index(name: "tpa_subtasks_name_ikey", columns: ["subtask_name"])]
#[ORM\Index(name: "tpa_subtasks_create_at_ikey", columns: ["subtask_create_at"])]
#[ORM\Index(name: "tpa_tasks_id_substask_ikey",columns: ["tasks_id"])]
#[UniqueEntity(
    fields: ['subtask_name', 'tasks_id'],
    message: 'Enregistrement impossible, sous-tache déjà existante.',
    errorPath: 'subtask_name',
)]
class TpaSubtasks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $subtaskName = null;

    #[ORM\Column(type: "datetime_immutable", options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $subtaskCreateAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $subtaskOrder = null;

    #[ORM\Column(nullable: true)]
    private ?bool $subtaskIsFinished = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TpaTasks $tasks = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubtaskName(): ?string
    {
        return $this->subtaskName;
    }

    public function setSubtaskName(string $subtaskName): static
    {
        $this->subtaskName = $subtaskName;

        return $this;
    }

    public function getSubtaskCreateAt(): ?\DateTimeImmutable
    {
        return $this->subtaskCreateAt;
    }

    public function setSubtaskCreateAt(\DateTimeImmutable $subtaskCreateAt): static
    {
        $this->subtaskCreateAt = $subtaskCreateAt;

        return $this;
    }

    public function getsubtaskOrder(): ?int
    {
        return $this->subtaskOrder;
    }

    public function setsubtaskOrder(?int $subtaskOrder): static
    {
        $this->subtaskOrder = $subtaskOrder;

        return $this;
    }

    public function isSubtaskIsFinished(): ?bool
    {
        return $this->subtaskIsFinished;
    }

    public function setSubtaskIsFinished(?bool $subtaskIsFinished): static
    {
        $this->subtaskIsFinished = $subtaskIsFinished;

        return $this;
    }

    public function getTasks(): ?TpaTasks
    {
        return $this->tasks;
    }

    public function setTasks(?TpaTasks $tasks): static
    {
        $this->tasks = $tasks;

        return $this;
    }
}