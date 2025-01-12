<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\FixtureReference;
use App\Faker\BookTitleProvider;
use App\Foundry\AuthorFactory;
use App\Foundry\BookFactory;
use App\Foundry\Story;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Attribute\WithStory;
use Zenstruck\Foundry\Test\Factories;

#[WithStory(Story::class)]
final class AliceVersusFoundryTest extends KernelTestCase
{
    use ReloadDatabaseTrait;
    use Factories;

    #[DataProvider('provideSource')]
    public function testCreateOne(string $source): void
    {
        $book = BookFactory::findBy(['reference' => FixtureReference::CREATE_ONE, 'source' => $source]);

        self::assertCount(1, $book);
        self::assertSame('Foundation', $book[0]->title);
    }

    #[DataProvider('provideSource')]
    public function testCreateMany(string $source): void
    {
        $books = BookFactory::repository()->findBy(['reference' => FixtureReference::CREATE_MANY, 'source' => $source],
            orderBy: ['title' => 'ASC']);

        self::assertCount(2, $books);
        self::assertSame('book 1', $books[0]->title);
        self::assertSame('book 2', $books[1]->title);
    }

    #[DataProvider('provideSource')]
    public function testUsingFaker(string $source): void
    {
        $books = BookFactory::findBy(['reference' => FixtureReference::USING_FAKER, 'source' => $source]);

        self::assertCount(1, $books);
        self::assertContains($books[0]->title, BookTitleProvider::BOOK_TITLES);
        self::assertCount(3, explode(' ', $books[0]->summary ?? ''));
    }

    #[DataProvider('provideSource')]
    public function testWithManyToOne(string $source): void
    {
        $books = BookFactory::findBy(['reference' => FixtureReference::WITH_MANY_TO_ONE, 'source' => $source]);

        self::assertCount(1, $books);
        self::assertNotNull($books[0]->author);
        self::assertSame('Isaac Asimov', $books[0]->author->name);
    }

    #[DataProvider('provideSource')]
    public function testWithOneToMany(string $source): void
    {
        $books = BookFactory::findBy(['reference' => FixtureReference::WITH_ONE_TO_MANY, 'source' => $source]);

        self::assertCount(2, $books);
        self::assertNotNull($books[0]->author);
        self::assertSame('Frank Herbert', $books[0]->author->name);
        self::assertSame($books[0]->author, $books[1]->author);
    }

    #[DataProvider('provideSource')]
    public function testWithOneToManyRandom(string $source): void
    {
        BookFactory::assert()->count(3, ['reference' => FixtureReference::WITH_ONE_TO_MANY_RANDOM, 'source' => $source]
        );

        $author = AuthorFactory::repository()->findOneBy(
            ['reference' => FixtureReference::WITH_ONE_TO_MANY_RANDOM, 'source' => $source]
        );
        self::assertNotNull($author);

        // we cannot predict the number in advance, because of a bug in Alice:
        // if the same book is randomly picked twice, it will be added to the collection only once ¯\_(ツ)_/¯
        // (or I don't know how to use it properly)
        self::assertGreaterThan(0, $author->getBooks()->count());

        foreach ($author->getBooks() as $book) {
            self::assertStringContainsString('Random book', $book->title ?? '');
        }
    }

    #[DataProvider('provideSource')]
    public function testGapsInIndex(string $source): void
    {
        $books = BookFactory::repository()->findBy(
            ['reference' => FixtureReference::WITH_GAP, 'source' => $source],
            orderBy: ['title' => 'ASC']
        );

        self::assertCount(3, $books);
        self::assertSame('Book with gap 1', $books[0]->title);
        self::assertSame('Book with gap 3', $books[1]->title);
        self::assertSame('Book with gap 5', $books[2]->title);
    }

    #[DataProvider('provideSource')]
    public function testWithReference(string $source): void
    {
        $books = BookFactory::repository()->findBy(['reference' => FixtureReference::WITH_ONE_TO_ONE_REFERENCE, 'source' => $source]);

        self::assertCount(2, $books);
        self::assertSame($books[0], $books[0]->bookDetail?->book);
        self::assertSame($books[1], $books[1]->bookDetail?->book);
    }

    #[DataProvider('provideSource')]
    public function testUsingAliceSpecialChars(string $source): void
    {
        $book = BookFactory::repository()->findOneBy(['reference' => FixtureReference::ESCAPE_ALICE_SPECIAL_CHARS, 'source' => $source]);

        self::assertNotNull($book);
        self::assertSame('title with @foo $bar', $book->title);
    }

    #[DataProvider('provideSource')]
    public function testWithMethodCalls(string $source): void
    {
        $book = BookFactory::repository()->findOneBy(['reference' => FixtureReference::WITH_METHOD_CALLS, 'source' => $source]);

        self::assertNotNull($book);
        self::assertNotNull($book->getIsbn());
        self::assertSame('title', $book->title);
        self::assertSame('summary', $book->summary);
    }

    #[DataProvider('provideSource')]
    public function testWithMethodCallsWithFakerModifiers(string $source): void
    {
        $book = BookFactory::repository()->findOneBy(['reference' => FixtureReference::WITH_METHOD_CALLS_WITH_FAKER_MODIFIED, 'source' => $source]);

        self::assertNotNull($book);
        self::assertNull($book->getIsbn());

        // cannot currently test optional()
        self::assertContains($book->title, BookTitleProvider::BOOK_TITLES);
    }

    public static function provideSource(): iterable // @phpstan-ignore missingType.iterableValue
    {
        yield ['alice'];
        yield ['foundry'];
    }
}
