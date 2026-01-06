<?php

namespace App\DataFixtures;

use App\Entity\Hall;
use App\Entity\Movie;
use App\Entity\Reservation;
use App\Entity\ReservationSeat;
use App\Entity\Screening;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = (new User())->setEmail('pracownik@kino.pl')->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        $halls = [];
        $hallData = [
            ['Sala IMAX', 15, 20],
            ['Sala Kameralna', 6, 10],
            ['Sala Atmos', 12, 16],
            ['Strefa VIP', 4, 6],
        ];

        foreach ($hallData as [$name, $rows, $seats]) {
            $hall = (new Hall())->setName($name)->setTotalRows($rows)->setSeatsPerRow($seats);
            $manager->persist($hall);
            $halls[] = $hall;
        }

        $movies = [];
        $movieData = [
            ['Bohemian Rhapsody', 134],
            ['Elvis', 159],
            ['Rocketman', 121],
            ['Walk the Line', 136],
            ['Władca Pierścieni: Drużyna Pierścienia', 178],
            ['Piraci z Karaibów: Klątwa Czarnej Perły', 143],
            ['Dobry, Zły i Brzydki', 161],
            ['Siedmiu Wspaniałych', 128],
            ['Gladiator II', 148],
            ['Interstellar', 169],
        ];

        foreach ($movieData as [$title, $duration]) {
            $movie = (new Movie())->setTitle($title)->setDurationMinutes($duration);
            $manager->persist($movie);
            $movies[] = $movie;
        }

        $screenings = [];
        $hours = ['15:00', '18:00', '21:00'];
        foreach ($movies as $index => $movie) {
            $screening = (new Screening())
                ->setMovie($movie)
                ->setHall($halls[$index % count($halls)])
                ->setStartTime(new \DateTimeImmutable('+'.($index % 3).' days '.$hours[$index % 3]));
            $manager->persist($screening);
            $screenings[] = $screening;
        }

        $reservation = (new Reservation())
            ->setScreening($screenings[0])
            ->setCustomerName('Edyta Testowy');
        $manager->persist($reservation);

        $seat = (new ReservationSeat())
            ->setReservation($reservation)
            ->setScreening($screenings[0])
            ->setRowNumber(1)
            ->setSeatNumber(1);
        $manager->persist($seat);

        $manager->flush();
    }
}
