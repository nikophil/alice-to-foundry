<?php

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\FixtureReference;

return [
    Book::class => [
        'book' => [
            'reference' => FixtureReference::CREATE_ONE,
            'title' => 'Foundation',
        ],
        'book{1..2}' => [
            'reference' => FixtureReference::CREATE_MANY,
            'title' => 'book <current()>',
        ],
        'book using faker' => [
            'reference' => FixtureReference::USING_FAKER,
            'title' => '<bookTitle()>',
            'summary' => '<sentence(3, false)>',
        ],
        'book using author' => [
            'reference' => FixtureReference::WITH_MANY_TO_ONE,
            'title' => 'Foundation',
            'author' => '@asimov',
        ],
        'book_for_author_1' => [
            'reference' => FixtureReference::WITH_ONE_TO_MANY,
            'title' => 'Dune',
        ],
        'book_for_author_2' => [
            'reference' => FixtureReference::WITH_ONE_TO_MANY,
            'title' => 'Dune messiah',
        ],
        'some_book_{1..3}' => [
            'reference' => FixtureReference::WITH_ONE_TO_MANY_RANDOM,
            'title' => 'Random book <current()>',
        ],
        'book_with_gaps_{1..5, 2}' => [
            'reference' => FixtureReference::WITH_GAP,
            'title' => 'Book with gap <current()>',
        ],
    ],

    Author::class => [
        'asimov' => [
            'reference' => FixtureReference::WITH_MANY_TO_ONE,
            'name' => 'Isaac Asimov',
        ],
        'herbert' => [
            'reference' => FixtureReference::WITH_ONE_TO_MANY,
            'name' => 'Frank Herbert',
            'books' => ['@book_for_author_1', '@book_for_author_2']
        ],
        'author_with_random_books' => [
            'reference' => FixtureReference::WITH_ONE_TO_MANY_RANDOM,
            'name' => 'Some author',
            'books' => '2x @some_book_*',
        ],
    ],
];
