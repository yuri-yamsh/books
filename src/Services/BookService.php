<?php

namespace App\Services;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookTranslation;
use App\Exceptions\DuplicateEntityException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(string $name, string $authorName): Book
    {
        $book = new Book();
        $book->setName($name);

        $bookTranslationEn = new BookTranslation('en', 'name', 'pseudo english string');

        $book->addTranslation($bookTranslationEn);

        $existAuthor = $this->em->getRepository(Author::class)->findOneBy(['name' => $authorName]);

        if ($existAuthor) {
            $author = $existAuthor;
        } else {
            $author = new Author();
            $author->setName($authorName);
        }

        $book->setAuthor($author);

        try {
            $this->em->persist($book);
            $this->em->flush();
        } catch (UniqueConstraintViolationException $exception) {
            throw new DuplicateEntityException(400, 'Уже есть книга с таким автором и названием', );
        }

        return $book;
    }
}