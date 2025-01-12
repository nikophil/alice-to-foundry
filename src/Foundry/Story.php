<?php

declare(strict_types=1);

namespace App\Foundry;

use App\Entity\FixtureReference;
use Doctrine\Common\Collections\ArrayCollection;
use Zenstruck\Foundry\Story as FoundryStory;

use function Zenstruck\Foundry\faker;

final class Story extends FoundryStory
{
    public function build(): void
    {
        $this->createOne();

        $this->createMany();

        $this->createUsingFaker();

        $this->createWithManyToOne();

        $this->createWithOneToMany();

        $this->createWithOneToManyRandom();

        $this->createWithGapsInIndex();
    }

    private function createOne(): void
    {
        BookFactory::createOne(['title' => 'Foundation', 'reference' => FixtureReference::CREATE_ONE]);
    }

    private function createMany(): void
    {
        BookFactory::createMany(2, fn(int $i) => ['title' => "book {$i}", 'reference' => FixtureReference::CREATE_MANY]
        );
    }

    private function createUsingFaker(): void
    {
        BookFactory::createOne([
            'title' => faker()->bookTitle(), // @phpstan-ignore method.notFound
            'summary' => faker()->sentence(3, false),
            'reference' => FixtureReference::USING_FAKER
        ]);
    }

    private function createWithManyToOne(): void
    {
        $author = AuthorFactory::createOne(['name' => 'Isaac Asimov', 'reference' => FixtureReference::WITH_MANY_TO_ONE]
        );
        BookFactory::createOne(['author' => $author, 'reference' => FixtureReference::WITH_MANY_TO_ONE]);

        // OR, other (better) solution
        // BookFactory::createOne(['author' => AuthorFactory::new(['name' => 'Isaac Asimov']), 'reference' => 'with many to one']);
    }

    private function createWithOneToMany(): void
    {
        $books = [
            BookFactory::createOne(['title' => 'Dune', 'reference' => FixtureReference::WITH_ONE_TO_MANY]),
            BookFactory::createOne(['title' => 'Dune messiah', 'reference' => FixtureReference::WITH_ONE_TO_MANY]),
        ];
        AuthorFactory::createOne(
            [
                'name' => 'Frank Herbert',
                'books' => new ArrayCollection($books),
                'reference' => FixtureReference::WITH_ONE_TO_MANY
            ]
        );

        // OR, other (better) solution
        // AuthorFactory::createOne([
        //     'name' => 'Frank Herbert',
        //     'books' => BookFactory::new(['reference' => FixtureReference::WITH_ONE_TO_MANY])
        //         ->sequence([
        //             ['title' => 'Dune'],
        //             ['title' => 'Dune messiah']
        //         ])
        // ]);
    }

    private function createWithOneToManyRandom(): void
    {
        BookFactory::createMany(
            3,
            fn(int $i) => ['title' => "Random book {$i}", 'reference' => FixtureReference::WITH_ONE_TO_MANY_RANDOM]
        );
        AuthorFactory::createOne([
            'reference' => FixtureReference::WITH_ONE_TO_MANY_RANDOM,
            'name' => 'Some author',
            'books' => BookFactory::randomSet(2, ['reference' => FixtureReference::WITH_ONE_TO_MANY_RANDOM])
        ]);
    }

    // I really don't know if this is really used
    // It does not seem useful
    private function createWithGapsInIndex(): void
    {
        for ($i = 1; $i <= 5; $i += 2) {
            BookFactory::createOne(['title' => "Book with gap {$i}", 'reference' => FixtureReference::WITH_GAP]);
        }
    }
}
