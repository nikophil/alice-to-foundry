<?php

declare(strict_types=1);

namespace App\Faker;

use Faker\Provider\Base as BaseProvider;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('foundry.faker_provider')]
final class BookTitleProvider extends BaseProvider
{
    public const BOOK_TITLES = [
        'Foundation',
        'Dune',
        '1984'
    ];

    public function bookTitle(): string
    {
        return self::randomElement(self::BOOK_TITLES);
    }
}
