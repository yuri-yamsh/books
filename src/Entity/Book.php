<?php

namespace App\Entity;

use App\Enums\BookLanguagesEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @Gedmo\TranslationEntity(class="App\Entity\BookTranslation")
 * @Table(name="book",
 *    uniqueConstraints={
 *        @UniqueConstraint(name="bookname_author",
 *            columns={"name", "author_id"})
 *    }
 * )
 */
class Book implements Translatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     *
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books", cascade={"persist"})
     *
     */
    private $author;

    /**
     * @ORM\OneToMany(
     *   targetEntity=BookTranslation::class,
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     *
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(BookTranslation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setObject($this);
        }
    }

    public function getTranslationsByLang(BookLanguagesEnum $lang): array
    {
        $translations = $this->getTranslations();
        $translationsArray = [];

        if (BookLanguagesEnum::RU()->equals($lang)) {
            $translationsArray['name'] = $this->getName();
            $translationsArray['content'] = 'dsadsa';

            return $translationsArray;
        }

        /** @var BookTranslation $translation */
        foreach ($translations as $translation) {
            if ($translation->getLocale() === $lang->getValue()) {
                $translationsArray[$translation->getField()] = $translation->getContent();
            }
        }

        return $translationsArray;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
