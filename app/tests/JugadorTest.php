<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class JugadorTest extends WebTestCase
{

    public function testGetAllJugadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/jugadores');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testPostJugadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/jugadores');

        $this->assertEquals(JsonResponse::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    public function testGetClubJugadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/club/jugadores/{idClub}');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testGetJugadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/jugadores/{id}');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testDeleteClubJugadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('PUT', '/api/club/jugadores/delete/{id}');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testPutClubJugadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('PUT', '/api/club/jugadores/add/{id}/{idClub}');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }
    
}
