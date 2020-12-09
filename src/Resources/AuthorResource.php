<?php

namespace App\Resources;

use App\Entity\Author;

class AuthorResource
{
    private Author $author;

    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    public function toArray()
    {
        return [
            'name' => $this->author->getName()
        ];
    }
}