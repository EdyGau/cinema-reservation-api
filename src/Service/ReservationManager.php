<?php

namespace App\Service;

use ApiPlatform\Metadata\IriConverterInterface;
use App\DTO\ReservationRequest;
use App\Entity\Reservation;
use App\Entity\ReservationSeat;
use App\Entity\Screening;
use App\Exception\ReservationException;
use App\Service\Validation\SeatAvailabilityChecker;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Service responsible for orchestrating the reservation creation process.
 */
final readonly class ReservationManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private IriConverterInterface $iriConverter,
        private SeatAvailabilityChecker $checker,
    ) {
    }

    /**
     * Creates a reservation with seats within a single transaction.
     *
     * @throws ReservationException
     */
    public function createFromRequest(ReservationRequest $request): Reservation
    {
        $screening = $this->iriConverter->getResourceFromIri($request->screeningIri);

        if (!$screening instanceof Screening) {
            throw new ReservationException('Invalid screening resource.');
        }

        if (!$this->checker->isSelectionValid($screening->getHall(), $request->seats)) {
            throw ReservationException::invalidGeometry();
        }

        try {
            return $this->entityManager->wrapInTransaction(function () use ($request, $screening): Reservation {
                $reservation = (new Reservation())
                    ->setScreening($screening)
                    ->setCustomerName($request->customerName);

                foreach ($request->seats as $seatData) {
                    $seat = (new ReservationSeat())
                        ->setReservation($reservation)
                        ->setScreening($screening)
                        ->setRowNumber((int) $seatData['row'])
                        ->setSeatNumber((int) $seatData['seat']);

                    $reservation->addSeat($seat);
                }

                $this->entityManager->persist($reservation);
                $this->entityManager->flush();

                return $reservation;
            });
        } catch (\Exception $e) {
            throw $e instanceof ReservationException ? $e : ReservationException::seatAlreadyTaken();
        }
    }
}