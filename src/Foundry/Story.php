<?php

declare(strict_types=1);

namespace App\Foundry;

use Zenstruck\Foundry\Story as FoundryStory;

use function Zenstruck\Foundry\faker;

final class Story extends FoundryStory
{
    public function build(): void
    {
        BookFactory::createOne(['title' => 'Foundation', 'reference' => 'create one']);

        BookFactory::createMany(2, fn(int $i) => ['title' => "book {$i}", 'reference' => 'create many']);

        BookFactory::createOne([
            'title' => faker()->bookTitle(),
            'summary' => faker()->sentence(3, false),
            'reference' => 'using faker'
        ]);
    }
}
