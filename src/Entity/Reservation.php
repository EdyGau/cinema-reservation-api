<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Controller\Api\v1\ReservationController;
use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')",
            openapi: new Operation(security: [['JWT' => []]])
        ),
        new Post(
            controller: ReservationController::class . '::create',
            name: 'api_v1_reservation_create',
            deserialize: false
        ),
    ]
)]
class Reservation
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne, ORM\JoinColumn(nullable: false)]
    private ?Screening $screening = null;

    #[ORM\Column(length: 255)]
    private ?string $customerName = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, ReservationSeat>
     */
    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: ReservationSeat::class, cascade: ['persist'])]
    private Collection $seats;

    public function __construct()
    {
        $this->seats = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getScreening(): ?Screening { return $this->screening; }
    public function setScreening(?Screening $screening): self { $this->screening = $screening; return $this; }
    public function getCustomerName(): ?string { return $this->customerName; }
    public function setCustomerName(string $customerName): self { $this->customerName = $customerName; return $this; }
    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    /**
     * @return Collection<int, ReservationSeat>
     */
    public function getSeats(): Collection { return $this->seats; }
    public function addSeat(ReservationSeat $seat): self
    {
        if (!$this->seats->contains($seat)) {
            $this->seats->add($seat);
            $seat->setReservation($this);
        }
        return $this;
    }
}