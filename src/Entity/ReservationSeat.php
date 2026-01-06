<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ReservationSeatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ReservationSeatRepository::class)]
#[ORM\UniqueConstraint(name: 'unique_seat_screening', columns: ['screening_id', 'row_number', 'seat_number'])]
#[UniqueEntity(fields: ['screening', 'rowNumber', 'seatNumber'], message: 'Miejsce zajęte.')]
#[ApiResource(operations: [new GetCollection()])]
class ReservationSeat
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'seats'), ORM\JoinColumn(nullable: false)]
    private ?Reservation $reservation = null;

    #[ORM\ManyToOne, ORM\JoinColumn(nullable: false)]
    private ?Screening $screening = null;

    #[ORM\Column(name: '`row_number`')]
    private ?int $rowNumber = null;

    #[ORM\Column(name: '`seat_number`')]
    private ?int $seatNumber = null;

    public function getId(): ?int { return $this->id; }
    public function getReservation(): ?Reservation { return $this->reservation; }
    public function setReservation(?Reservation $reservation): self { $this->reservation = $reservation; return $this; }
    public function getScreening(): ?Screening { return $this->screening; }
    public function setScreening(?Screening $screening): self { $this->screening = $screening; return $this; }
    public function getRowNumber(): ?int { return $this->rowNumber; }
    public function setRowNumber(int $rowNumber): self { $this->rowNumber = $rowNumber; return $this; }
    public function getSeatNumber(): ?int { return $this->seatNumber; }
    public function setSeatNumber(int $seatNumber): self { $this->seatNumber = $seatNumber; return $this; }
}