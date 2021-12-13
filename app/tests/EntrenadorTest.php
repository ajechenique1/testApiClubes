<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class EntrenadorTest extends WebTestCase
{

    public function testGetAllEntrenadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/entrenadores');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testPostEntrenadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/entrenadores');

        $this->assertEquals(JsonResponse::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    public function testGetClubEntrenadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/club/entrenadores/{idClub}');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testGetEntrenadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/entrenadores/{id}');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testDeleteClubEntrenadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('PUT', '/api/club/entrenadores/delete/{id}');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testPutClubEntrenadores(): void
    {
        $client = static::createClient();
        $crawler = $client->request('PUT', '/api/club/entrenadores/add/{id}/{idClub}');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }
    
}
