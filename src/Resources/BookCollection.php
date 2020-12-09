<?php

namespace App\Resources;

class BookCollection
{
    private array $collection;

    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public function toArray()
    {
        $array = [];

        foreach ($this->collection as $book) {
            $array[] = (new BookResource($book))->toArray();
        }

        return $array;
    }
}