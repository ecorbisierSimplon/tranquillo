<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class TaskDto
{


    public ?string $name = null;


    public ?string $description = null;


    public ?int $reminder = null;


    public ?\DateTimeImmutable $startAt = null;


    public ?\DateTimeImmutable $endAt = null;
}
