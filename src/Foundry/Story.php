<?php

declare(strict_types=1);

namespace App\Foundry;

use App\Entity\FixtureReference;
use Zenstruck\Foundry\Story as FoundryStory;

use function Zenstruck\Foundry\faker;

final class Story extends FoundryStory
{
    public function build(): void
    {
        // create one
        BookFactory::createOne(['title' => 'Foundation', 'reference' => FixtureReference::CREATE_ONE]);

        // create many
        BookFactory::createMany(2, fn(int $i) => ['title' => "book {$i}", 'reference' => FixtureReference::CREATE_MANY]);

        // create using faker
        BookFactory::createOne([
            'title' => faker()->bookTitle(),
            'summary' => faker()->sentence(3, false),
            'reference' => FixtureReference::USING_FAKER
        ]);

        // create with ManyToOne
        $author = AuthorFactory::createOne(['name' => 'Isaac Asimov']);
        BookFactory::createOne(['author' => $author, 'reference' => FixtureReference::WITH_MANY_TO_ONE]);
    }
}
