<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    public int $id;

    #[ORM\ManyToOne(inversedBy: 'books')]
    public Author|null $author = null;

    #[ORM\OneToOne(mappedBy: 'book')]
    public BookDetail|null $bookDetail = null;

    #[ORM\Column()]
    public FixtureReference $reference;

    #[ORM\Column()]
    public string $source = 'alice';

    #[ORM\Column(nullable: true)]
    public string|null $title = null;

    #[ORM\Column(nullable: true)]
    public string|null $summary = null;

    #[ORM\Column(nullable: true)]
    private string|null $isbn = null;

    public static function create(Author $author, string $title): self
    {
        $book = new self();
        $book->author = $author;
        $book->title = $title;

        return $book;
    }

    public function getIsbn(): string|null
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): void
    {
        $this->isbn = $isbn;
    }

    public function setTitleAndSummary(string $title, string $summary): void
    {
        $this->title = $title;
        $this->summary = $summary;
    }
}
