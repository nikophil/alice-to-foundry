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

    #[ORM\Column()]
    public string $reference;

    #[ORM\Column()]
    public string $source = 'alice';

    #[ORM\Column()]
    public string $title;

    #[ORM\Column()]
    public string $summary = '';
}
