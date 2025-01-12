<?php

namespace App\Foundry;

use App\Entity\BookDetail;
use App\Entity\FixtureReference;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<BookDetail>
 */
final class BookDetailFactory extends PersistentObjectFactory
{
    public static function class(): string
    {
        return BookDetail::class;
    }

    /** @return array<string, mixed> */
    protected function defaults(): array
    {
        return [
            'book' => BookFactory::new(['reference' => FixtureReference::WITH_ONE_TO_ONE_REFERENCE]),
            'description' => self::faker()->text(),
        ];
    }
}
