<?php

namespace App\Tests\Controller;

use App\Tests\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class AuthorControllerTest extends BaseWebTestCase
{
    private KernelBrowser $client;

    public function setUp()
    {
        $this->client = $this->createClient();
    }

    public function testCreateAuthor()
    {
        $client = $this->client;

        $client->xmlHttpRequest(
            'POST',
            $this->baseApiUrl . '/author/create',
            [
                'name' => 'Лев Толстой',
            ]
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testValidationFailOnCreateAuthor()
    {
        $client = $this->client;

        $client->xmlHttpRequest(
            'POST',
            $this->baseApiUrl . '/author/create',
            []
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}