<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BaseWebTestCase extends WebTestCase
{
    protected string $baseApiUrl = "/api";

    protected function getDataFromResponse(Response $response): array
    {
        $response = json_decode($response->getContent(), true);
        return $response['data'];
    }
}