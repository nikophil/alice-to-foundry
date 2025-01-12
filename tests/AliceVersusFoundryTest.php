<?php

declare(strict_types=1);

namespace App\Tests;

use App\Faker\BookTitleProvider;
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
        $book = BookFactory::findBy(['reference' => 'create one', 'source' => $source]);

        self::assertCount(1, $book);
        self::assertSame('Foundation', $book[0]->title);
    }

    #[DataProvider('provideSource')]
    public function testCreateMany(string $source): void
    {
        $books = BookFactory::repository()->findBy(['reference' => 'create many', 'source' => $source], orderBy: ['title' => 'ASC']);

        self::assertCount(2, $books);
        self::assertSame('book 1', $books[0]->title);
        self::assertSame('book 2', $books[1]->title);
    }

    #[DataProvider('provideSource')]
    public function testUsingFaker(string $source): void
    {
        $books = BookFactory::findBy(['reference' => 'using faker', 'source' => $source]);

        self::assertCount(1, $books);
        self::assertContains($books[0]->title, BookTitleProvider::BOOK_TITLES);
        self::assertCount(3, explode(' ', $books[0]->summary));
    }

    #[DataProvider('provideSource')]
    public function testWithManyToOne(string $source): void
    {
        $books = BookFactory::findBy(['reference' => 'with many to one', 'source' => $source]);

        self::assertCount(1, $books);
        self::assertNotNull($books[0]->author);
        self::assertSame('Isaac Asimov', $books[0]->author->name);
    }

    public static function provideSource(): iterable
    {
        yield ['alice'];
        yield ['foundry'];
    }
}
