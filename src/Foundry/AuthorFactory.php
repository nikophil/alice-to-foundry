<?php

namespace App\Foundry;

use App\Entity\Author;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Author>
 */
final class AuthorFactory extends PersistentObjectFactory
{
    public static function class(): string
    {
        return Author::class;
    }

    /** @return array<string, mixed> */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->name(),
        ];
    }
}
