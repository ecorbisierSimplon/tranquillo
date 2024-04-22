<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class AuthPostTest extends ApiTestCase
{
    public function testSuccessfulLogin(): void
    {
        $client = static::createClient();
        $response = $client->request('POST', '/api/login_check', ['json' => [
            'username' => 'philippe.leclerc@example.com',
            'password' => 'Philippe:Leclerc:1234',
        ]]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['token']);
    }

    public function testFailedLogin(): void
    {
        $client = static::createClient();
        $response = $client->request('POST', '/api/login_check', ['json' => [
            'username' => 'mauvais_nom_utilisateur',
            'password' => 'mauvais_mot_de_passe',
        ]]);

        $this->assertResponseStatusCodeSame(401);
    }
}
