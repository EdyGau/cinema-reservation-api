<?php

namespace App\Tests\Unit;

use App\Entity\Hall;
use App\Service\Validation\SeatAvailabilityChecker;
use PHPUnit\Framework\TestCase;

final class SeatAvailabilityCheckerTest extends TestCase
{
    private SeatAvailabilityChecker $checker;

    protected function setUp(): void
    {
        $this->checker = new SeatAvailabilityChecker();
    }

    public function test_geometry_validation(): void
    {
        $hall = (new Hall())->setTotalRows(5)->setSeatsPerRow(5);

        $this->assertTrue($this->checker->isSelectionValid($hall, [['row' => 1, 'seat' => 1]]));
        $this->assertFalse($this->checker->isSelectionValid($hall, [['row' => 6, 'seat' => 1]]), 'Rząd poza zakresem');
        $this->assertFalse($this->checker->isSelectionValid($hall, [['row' => 1, 'seat' => 6]]), 'Miejsce poza zakresem');
    }

    public function test_duplicate_seat_detection(): void
    {
        $hall = (new Hall())->setTotalRows(5)->setSeatsPerRow(5);
        $duplicateSeats = [
            ['row' => 1, 'seat' => 1],
            ['row' => 1, 'seat' => 1]
        ];

        $this->assertFalse($this->checker->isSelectionValid($hall, $duplicateSeats), 'Duplikaty powinny być odrzucone');
    }
}