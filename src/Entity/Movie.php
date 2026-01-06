<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(
            security: "is_granted('ROLE_ADMIN')",
            openapi: new Operation(security: [['JWT' => []]])
        ),
        new Patch(
            security: "is_granted('ROLE_ADMIN')",
            openapi: new Operation(security: [['JWT' => []]])
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')",
            openapi: new Operation(security: [['JWT' => []]])
        ),
    ]
)]
class Movie
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\NotNull, Assert\GreaterThan(0)]
    private ?int $durationMinutes = null;

    public function getId(): ?int { return $this->id; }
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    public function getDurationMinutes(): ?int { return $this->durationMinutes; }
    public function setDurationMinutes(int $durationMinutes): self { $this->durationMinutes = $durationMinutes; return $this; }
}