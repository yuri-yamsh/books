<?php

namespace App\Tests\Unit;

use App\Entity\Author;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    public function testSettingName()
    {
        $author = new Author();

        $this->assertNull($author->getName());

        $author->setName('Александр Пушкин');

        $this->assertEquals('Александр Пушкин', $author->getName());
    }
}