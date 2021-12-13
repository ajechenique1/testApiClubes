<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ClubTest extends WebTestCase
{
    public function testPostClub(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/clubes');

        $this->assertEquals(JsonResponse::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    public function testPutClub(): void
    {
        $client = static::createClient();
        $crawler = $client->request('PUT', '/api/clubes/{id}');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testGetClub(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/clubes/{id}');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testGetAllClub(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/clubes');

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
    }
    
}
