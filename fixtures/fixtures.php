<?php

use App\Entity\Author;
use App\Entity\Book;

return [
    Book::class => [
        'book' => [
            'reference' => 'create one',
            'title' => 'Foundation',
        ],
        'book{1..2}' => [
            'reference' => 'create many',
            'title' => 'book <current()>',
        ],
        'book using faker' => [
            'reference' => 'using faker',
            'title' => '<bookTitle()>',
            'summary' => '<sentence(3, false)>',
        ],
        'book using author' => [
            'reference' => 'with many to one',
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
