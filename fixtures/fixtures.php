<?php

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
    ],
];
