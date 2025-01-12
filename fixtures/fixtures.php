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
    ],

    Author::class => [
        'asimov' => [
            'name' => 'Isaac Asimov',
        ],
    ],
];
