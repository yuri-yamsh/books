<?php

namespace App\Tests\Controller;

use App\Tests\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class BookControllerTest extends BaseWebTestCase
{
    private KernelBrowser $client;

    public function setUp()
    {
        $this->client = $this->createClient();
    }

    public function testCreateBook()
    {
        $client = $this->client;
        echo $this->baseApiUrl . '/book/create';
        $client->xmlHttpRequest(
            'POST',
            $this->baseApiUrl . '/book/create',
            [
                'name' => 'Новая книга',
                'author' => 'Новый автор'
            ]
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testValidationFailsOnCreateBook()
    {
        $client = $this->client;

        $client->xmlHttpRequest(
            'POST',
            $this->baseApiUrl . '/book/create',
            ['name' => 'Новая книга']
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $client->xmlHttpRequest(
            'POST',
            $this->baseApiUrl . '/book/create',
            ['author' => 'Автор']
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testGetBookTranslations()
    {
        $client = $this->client;

        $client->xmlHttpRequest(
            'POST',
            $this->baseApiUrl . '/book/create',
            [
                'name' => 'Новая книга 2',
                'author' => 'Новый автор 2'
            ]
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        $data = $this->getDataFromResponse($client->getResponse());
        $bookId = $data['id'];

        $client->xmlHttpRequest(
            'GET',
            $this->baseApiUrl . "/ru/book/$bookId"
        );

        $data = $this->getDataFromResponse($client->getResponse());
        $bookNameRu = $data['name'];

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Новая книга 2', $bookNameRu);

        $client->xmlHttpRequest(
            'GET',
            $this->baseApiUrl . "/en/book/$bookId"
        );

        $data = $this->getDataFromResponse($client->getResponse());
        $bookNameEn = $data['name'];

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('pseudo english string', $bookNameEn);
    }

    public function testSearchBook()
    {
        $client = $this->client;

        $client->xmlHttpRequest(
            'POST',
            $this->baseApiUrl . '/book/create',
            [
                'name' => 'Новая книга 3',
                'author' => 'Новый автор 3'
            ]
        );

        $client->xmlHttpRequest(
            'GET',
            $this->baseApiUrl . '/book/search',
            ['name' => 'Новая книга 3']
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $data = $this->getDataFromResponse($client->getResponse());

        $this->assertCount(1, $data);
    }
}