<?php

namespace App\Resources;

class AuthorCollection
{
    private array $collection;

    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public function toArray()
    {
        $array = [];

        foreach ($this->collection as $author) {
            $array[] = (new AuthorResource($author))->toArray();
        }

        return $array;
    }
}