<?php

namespace App\Tests\Unit;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookTranslation;
use App\Enums\BookLanguagesEnum;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testSettingName()
    {
        $book = new Book();

        $this->assertNull($book->getName());

        $book->setName('Война и Мир');

        $this->assertEquals('Война и Мир', $book->getName());
    }

    public function testSettingAuthor()
    {
        $book = new Book();

        $this->assertNull($book->getAuthor());

        $author = new Author();

        $book->setAuthor($author);

        $this->assertInstanceOf(Author::class, $book->getAuthor());
    }

    public function testSettingTranslation()
    {
        $book = new Book();

        $book->setName('Новая книга');

        $this->assertCount(0, $book->getTranslations());

        $bookTranslation = new BookTranslation(BookLanguagesEnum::RU, 'name', 'New book');

        $this->assertNull($bookTranslation->getObject());

        $book->addTranslation($bookTranslation);

        $this->assertCount(1, $book->getTranslations());

        $this->assertInstanceOf(Book::class, $bookTranslation->getObject());
    }
}