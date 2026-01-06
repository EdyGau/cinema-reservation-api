<?php

namespace App\Controller\Api\v1;

use App\DTO\ReservationRequest;
use App\Exception\ReservationException;
use App\Service\ReservationManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class ReservationController extends AbstractController
{
    /**
     * Endpoint for creating a new reservation.
     */
    public function create(
        #[MapRequestPayload] ReservationRequest $request,
        ReservationManager $reservationManager,
    ): JsonResponse {
        try {
            $reservation = $reservationManager->createFromRequest($request);
        } catch (ReservationException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return $this->json([
            'id' => $reservation->getId(),
            'customerName' => $reservation->getCustomerName(),
            'status' => 'created',
        ], 201);
    }
}