<?php

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookDetail;
use App\Entity\FixtureReference;

return [
    'parameters' => [
        'title' => 'title',
        'summary' => 'summary',
    ],
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
        'book using faker optional' => [
            'reference' => FixtureReference::USING_FAKER_OPTIONAL,

            // "0%" so that it is never called
            'title' => '00%? <bookTitle()>',
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
        'book_with_reference_{1..2}' => [
            'reference' => FixtureReference::WITH_ONE_TO_ONE_REFERENCE,
            'title' => 'Book with reference <current()>',
        ],
        'with_alice_special_chars' => [
            'reference' => FixtureReference::ESCAPE_ALICE_SPECIAL_CHARS,
            'title' => 'title with \@foo \$bar',
        ],
        'with_method_calls' => [
            'reference' => FixtureReference::WITH_METHOD_CALLS,
            '__calls' => [
                // I'm suspecting a bug here, it needs an extra level of array compared with what's in docs:
                // https://github.com/nelmio/alice/blob/main/doc/complete-reference.md#calling-methods
                ['setIsbn' => ['<isbn10()>']],

                // I could not make this work, I'm having the following error:
                // Could not resolve value during the generation process: Could not find a variable "$title".
                // ['setTitleAndSummary' => ['title' => 'title', '$title']],

                ['setTitleAndSummary' => ['<{title}>', '<{summary}>']],
            ],
        ],
        'method_calls_with_faker_modifiers' => [
            'reference' => FixtureReference::WITH_METHOD_CALLS_WITH_FAKER_MODIFIED,
            '__calls' => [
                // "0%" so that it is never called
                ['setIsbn (0%?)' => ['<isbn10()>']],

                ['setTitleAndSummary' => ['title (unique)' => '<bookTitle()>', 'summary' => 'summary>']],
            ],
        ],
        'using_named_constructor' => [
            'reference' => FixtureReference::USING_NAMED_CONSTRUCTOR,
            '__factory' => [
                'create' => ['@asimov', 'Foundation'],
            ],
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

    BookDetail::class => [
        'book_detail_{@book_with_reference_*}' => [
            'book' => '<current()>',
            'description' => 'What an awesome book!',
        ]
    ]
];
