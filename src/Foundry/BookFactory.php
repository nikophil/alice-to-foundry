<?php

namespace App\Foundry;

use App\Entity\Book;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Book>
 */
final class BookFactory extends PersistentObjectFactory
{
    public static function class(): string
    {
        return Book::class;
    }

    /** @return array<string, mixed> */
    protected function defaults(): array
    {
        return [
            'source' => 'foundry',
            'title' => self::faker()->sentence(3),
            'summary' => self::faker()->text(),
        ];
    }
}
