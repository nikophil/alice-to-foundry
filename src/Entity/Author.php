<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    public int $id;

    #[ORM\Column()]
    public string $name;

    /** @var Collection<int,Book> */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'author')]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @return Collection<int,Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): void
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->author = $this;
        }
    }

    public function removeBook(Book $book): void
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            $book->author = null;
        }
    }
}
