<?php

namespace App\Entity;

use App\Repository\DeliciousRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeliciousRepository::class)]
class Delicious
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Bonjour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBonjour(): ?string
    {
        return $this->Bonjour;
    }

    public function setBonjour(string $Bonjour): static
    {
        $this->Bonjour = $Bonjour;

        return $this;
    }
}
