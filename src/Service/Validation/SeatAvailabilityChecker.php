<?php

namespace App\Service\Validation;

use App\Entity\Hall;

/**
 * Service for validating seat selection against hall constraints.
 */
final readonly class SeatAvailabilityChecker
{
    /**
     * Validates if the selected seats are within the hall's geometry and are not duplicated.
     *
     * @param array<int, array{row: int, seat: int}> $seats
     */
    public function isSelectionValid(Hall $hall, array $seats): bool
    {
        $uniqueSeats = [];

        foreach ($seats as $seat) {
            $row = $seat['row'];
            $num = $seat['seat'];

            if ($row < 1 || $row > $hall->getTotalRows() || $num < 1 || $num > $hall->getSeatsPerRow()) {
                return false;
            }

            $key = "{$row}-{$num}";
            if (isset($uniqueSeats[$key])) {
                return false;
            }
            $uniqueSeats[$key] = true;
        }

        return true;
    }
}