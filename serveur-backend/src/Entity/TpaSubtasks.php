<?php

namespace App\Entity;

use App\Repository\TpaSubtasksRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TpaSubtasksRepository::class)]
class TpaSubtasks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $subtaskName = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $subtaskCreateAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $substaskOrder = null;

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

    public function getSubstaskOrder(): ?int
    {
        return $this->substaskOrder;
    }

    public function setSubstaskOrder(?int $substaskOrder): static
    {
        $this->substaskOrder = $substaskOrder;

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
