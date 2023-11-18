<?php
    return [
        'authors' => [
            'books' => 'books',
        ],

        'books' => [
            'authors' => 'authors',
            'genres' => 'genres'
        ],

        'genres' => [
            'books' => 'books'
        ]
    ];
