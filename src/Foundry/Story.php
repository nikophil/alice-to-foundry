<?php

declare(strict_types=1);

namespace App\Foundry;

use Zenstruck\Foundry\Story as FoundryStory;

use function Zenstruck\Foundry\faker;

final class Story extends FoundryStory
{
    public function build(): void
    {
        // create one
        BookFactory::createOne(['title' => 'Foundation', 'reference' => 'create one']);

        // create many
        BookFactory::createMany(2, fn(int $i) => ['title' => "book {$i}", 'reference' => 'create many']);

        // create using faker
        BookFactory::createOne([
            'title' => faker()->bookTitle(),
            'summary' => faker()->sentence(3, false),
            'reference' => 'using faker'
        ]);

        // create with ManyToOne
        $author = AuthorFactory::createOne(['name' => 'Isaac Asimov']);
        BookFactory::createOne(['author' => $author, 'reference' => 'with many to one']);
    }
}
