<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class ReservationRequest
{
    /**
     * @param array<int, array{row: int, seat: int}> $seats
     */
    public function __construct(
        #[Assert\NotBlank]
        public string $screeningIri,
        #[Assert\NotBlank]
        #[Assert\Length(min: 3)]
        public string $customerName,
        #[Assert\NotBlank]
        #[Assert\Count(min: 1)]
        #[Assert\All([
            new Assert\Collection([
                'fields' => [
                    'row' => [new Assert\NotBlank(), new Assert\Type('integer')],
                    'seat' => [new Assert\NotBlank(), new Assert\Type('integer')],
                ],
                'allowExtraFields' => false,
            ]),
        ])]
        public array $seats,
    ) {
    }
}
