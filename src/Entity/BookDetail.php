<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class BookDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    public int $id;

    #[ORM\Column()]
    public string $description;

    #[ORM\OneToOne(inversedBy: 'bookDetail')]
    public Book $book;
}
