<?php

namespace App\Exception;

/**
 * Domain-specific exception for reservation failures.
 */
final class ReservationException extends \DomainException
{
    public static function seatAlreadyTaken(): self
    {
        return new self('One or more selected seats are already booked.');
    }

    public static function invalidGeometry(): self
    {
        return new self('Seat selection is invalid for this hall geometry.');
    }
}
