<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->createBooksWithAuthors($manager);
    }

    private function createBooksWithAuthors(ObjectManager $manager, int $batchSize = 20, int $countEntities = 10000)
    {
        for ($i = 1; $i <= $countEntities; ++$i) {
            $author = new Author();
            $author->setName("Автор $i");
            $book = new Book();
            $book->setName("Книга $i");
            $book->setAuthor($author);
            $manager->persist($book);
            if (($i % $batchSize) === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        $manager->flush();
        $manager->clear();
    }
}
