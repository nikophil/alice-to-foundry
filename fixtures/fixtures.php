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
    ],
];
