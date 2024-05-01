<?php

namespace App\Dto;

// use App\Validator\DateTimeImmutable;
use App\Validator\UserRegex;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class TaskDto
{

    #[Groups(['tasks: create'])]
    #[Assert\NotBlank(message: "Le nom de la tache ne peut être vide !")]
    private ?string $name = null;

    #[Groups(['tasks: create'])]
    #[Assert\NoSuspiciousCharacters()]
    private ?string $description = null;

    #[Groups(['tasks: create'])]
    #[Assert\PositiveOrZero()]
    #[UserRegex(regex: 'number', field: 'Rappel', information: "Le rappel est calculé en minute(s)")]
    private ?int $reminder = null;

    #[Groups(['tasks: create'])]
    private  ?\DateTimeImmutable  $startAt = null;

    #[Groups(['tasks: create'])]
    private  ?\DateTimeImmutable  $endAt = null;

    #[Groups(['tasks: create'])]
    private  ?\DateTimeImmutable  $createAt = null;

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

    public function setCreateAt(?\DateTimeImmutable  $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }
}
