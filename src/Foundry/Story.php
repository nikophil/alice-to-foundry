<?php

declare(strict_types=1);

namespace App\Foundry;

use App\Entity\FixtureReference;
use Doctrine\Common\Collections\ArrayCollection;
use Zenstruck\Foundry\Object\Instantiator;
use Zenstruck\Foundry\Story as FoundryStory;

use function Zenstruck\Foundry\faker;

final class Story extends FoundryStory
{
    // this const is here to mimic the "parameters" in fixtures.php
    // another solution would be to resolve them directly in the methods
    // @see method createWithMethodCallWithFakerModifiers()
    private const PARAMETERS = [
        'title' => 'title',
        'summary' => 'summary',
    ];

    public function build(): void
    {
        $this->createOne();

        $this->createMany();

        $this->createUsingFaker();

        $this->createUsingFakerOptional();

        $this->createWithManyToOne();

        $this->createWithOneToMany();

        $this->createWithOneToManyRandom();

        $this->createWithGapsInIndex();

        $this->createWithOneToOneReference();

        $this->createWithAliceSpecialChars();

        $this->createWithMethodCall();

        $this->createWithMethodCallWithFakerModifiers();

        $this->createUsingNamedConstructor();
    }

    private function createOne(): void
    {
        BookFactory::createOne(['title' => 'Foundation', 'reference' => FixtureReference::CREATE_ONE]);
    }

    private function createMany(): void
    {
        BookFactory::createMany(2, fn(int $i) => ['title' => "book {$i}", 'reference' => FixtureReference::CREATE_MANY]);
    }

    private function createUsingFaker(): void
    {
        BookFactory::createOne([
            'title' => faker()->bookTitle(), // @phpstan-ignore method.notFound
            'summary' => faker()->sentence(3, false),
            'reference' => FixtureReference::USING_FAKER
        ]);
    }

    private function createUsingFakerOptional(): void
    {
        BookFactory::createOne([
            'title' => faker()->optional(0)->bookTitle(), // @phpstan-ignore method.notFound
            'reference' => FixtureReference::USING_FAKER_OPTIONAL
        ]);
    }

    private function createWithManyToOne(): void
    {
        $author = AuthorFactory::createOne(['name' => 'Isaac Asimov', 'reference' => FixtureReference::WITH_MANY_TO_ONE]);
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

    private function createWithOneToOneReference(): void
    {
        // if the OneToOne is inversed:
        BookFactory::createMany(
            2,
            fn(int $i) => [
                'title' => "Book with reference {$i}",
                'reference' => FixtureReference::WITH_ONE_TO_ONE_REFERENCE,
                'bookDetail' => BookDetailFactory::new(),
            ]
        );

        // if not inversed:
        // $books = BookFactory::createMany(
        //     2,
        //     fn(int $i) => [
        //         'title' => "Book with reference {$i}",
        //         'reference' => FixtureReference::WITH_ONE_TO_ONE_REFERENCE,
        //     ]
        // );
        // foreach ($books as $book) {
        //     $book->bookDetail = BookDetailFactory::createOne(['book' => $book]);
        // }
    }

    private function createWithAliceSpecialChars(): void
    {
        BookFactory::createOne([
            'title' => 'title with @foo $bar',
            'reference' => FixtureReference::ESCAPE_ALICE_SPECIAL_CHARS
        ]);
    }

    private function createWithMethodCall(): void
    {
        BookFactory::createOne([
            'reference' => FixtureReference::WITH_METHOD_CALLS,
            'setIsbn' => faker()->isbn10(),

            // there is currently no way to call a method with multiple arguments in Foundry
            // so, we cannot call setTitleAndSummary() method
            'title' => self::PARAMETERS['title'],
            'summary' => self::PARAMETERS['summary'],
        ]);
    }

    private function createWithMethodCallWithFakerModifiers(): void
    {
        $attributes = [
            'reference' => FixtureReference::WITH_METHOD_CALLS_WITH_FAKER_MODIFIED,
            'title' => faker()->unique()->bookTitle(), // @phpstan-ignore method.notFound
            'summary' => 'summary',
        ];

        $isbn = faker()->optional(0)->isbn10();
        if (null !== $isbn) { // @phpstan-ignore notIdentical.alwaysTrue (it seems that faker's optional() is not well typed)
            $attributes['setIsbn'] = $isbn;
        }

        BookFactory::createOne($attributes);
    }

    private function createUsingNamedConstructor(): void
    {
        BookFactory::new([
            'author' => AuthorFactory::new(['name' => 'Isaac Asimov', 'reference' => FixtureReference::USING_NAMED_CONSTRUCTOR]),
            'title' => 'Foundation',
            'reference' => FixtureReference::USING_NAMED_CONSTRUCTOR,
        ])
            ->instantiateWith(Instantiator::namedConstructor('create'))
            ->create();
    }
}
