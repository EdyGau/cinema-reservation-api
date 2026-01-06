<?php

namespace App\Tests\Integration;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

final class SecurityTest extends ApiTestCase
{
    protected static ?bool $alwaysBootKernel = true;

    public function test_anonymous_user_cannot_create_hall(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/v1/halls', [
            'json' => ['name' => 'Unauthorized', 'totalRows' => 10, 'seatsPerRow' => 10],
        ]);
        $this->assertResponseStatusCodeSame(401);
    }

    public function test_admin_can_login_and_get_token(): void
    {
        $client = static::createClient();

        $response = $client->request('POST', '/api/v1/login_check', [
            'json' => [
                'email' => 'pracownik@kino.pl',
                'password' => 'admin123',
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $data = $response->toArray();
        $this->assertArrayHasKey('token', $data);
    }
}