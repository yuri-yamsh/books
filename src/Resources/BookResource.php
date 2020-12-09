<?php

namespace App\Resources;

use App\Entity\Book;

class BookResource
{
    private Book $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
        $this->author = $book->getAuthor();
    }

    public function toArray()
    {
        return [
            'id' => $this->book->getId(),
            'name' => $this->book->getName(),
            'author' => [
                'name' => $this->author->getName()
            ]
        ];
    }
}