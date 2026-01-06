<?php

namespace App\Tests\Integration;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Hall;
use App\Entity\Movie;
use App\Entity\Screening;
use Doctrine\ORM\EntityManagerInterface;

class ReservationTest extends ApiTestCase
{
    protected static ?bool $alwaysBootKernel = true;

    public function test_user_can_make_reservation(): void
    {
        $client = static::createClient();
        $container = static::getContainer();
        /** @var EntityManagerInterface $em */
        $em = $container->get('doctrine')->getManager();

        $hall = (new Hall())->setName('Test Hall')->setTotalRows(10)->setSeatsPerRow(10);
        $movie = (new Movie())->setTitle('Test Movie')->setDurationMinutes(120);
        $em->persist($hall);
        $em->persist($movie);
        $em->flush();

        $screening = (new Screening())
            ->setHall($hall)
            ->setMovie($movie)
            ->setStartTime(new \DateTimeImmutable('+1 day'));
        $em->persist($screening);
        $em->flush();

        $iri = $container->get('api_platform.iri_converter')->getIriFromResource($screening);

        $payload = [
            'screeningIri' => $iri,
            'customerName' => 'Edyta Testowy',
            'seats' => [['row' => 1, 'seat' => 1]],
        ];

        $client->request('POST', '/api/v1/reservations', ['json' => $payload]);
        $this->assertResponseStatusCodeSame(201);

        $client->request('POST', '/api/v1/reservations', ['json' => $payload]);
        $this->assertResponseStatusCodeSame(400);
    }
}