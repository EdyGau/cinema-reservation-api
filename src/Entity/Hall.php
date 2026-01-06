<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Repository\HallRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HallRepository::class)]
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
class Hall
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotNull, Assert\GreaterThan(0)]
    private ?int $totalRows = null;

    #[ORM\Column]
    #[Assert\NotNull, Assert\GreaterThan(0)]
    private ?int $seatsPerRow = null;

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getTotalRows(): ?int { return $this->totalRows; }
    public function setTotalRows(int $totalRows): self { $this->totalRows = $totalRows; return $this; }
    public function getSeatsPerRow(): ?int { return $this->seatsPerRow; }
    public function setSeatsPerRow(int $seatsPerRow): self { $this->seatsPerRow = $seatsPerRow; return $this; }
}