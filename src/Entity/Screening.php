<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Repository\ScreeningRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ScreeningRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(
            security: "is_granted('ROLE_ADMIN')",
            openapi: new Operation(security: [['JWT' => []]])
        ),
    ]
)]
class Screening
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne, ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Movie $movie = null;

    #[ORM\ManyToOne, ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Hall $hall = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $startTime = null;

    public function getId(): ?int { return $this->id; }
    public function getMovie(): ?Movie { return $this->movie; }
    public function setMovie(?Movie $movie): self { $this->movie = $movie; return $this; }
    public function getHall(): ?Hall { return $this->hall; }
    public function setHall(?Hall $hall): self { $this->hall = $hall; return $this; }
    public function getStartTime(): ?\DateTimeImmutable { return $this->startTime; }
    public function setStartTime(\DateTimeImmutable $startTime): self { $this->startTime = $startTime; return $this; }
}