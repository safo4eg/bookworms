<?php
    return [
        'books' => [
            'relationships' => [
                'authors' => [
                    'relationship' => 'authors',
                    'fields' => [
                        'name' => ['like'],
                        'surname' => ['like'],
                        'patronymic' => ['like']
                    ]
                ],

                'genres' => [
                    'relationship' => 'genres',
                    'fields' => [
                        'title' => ['like']
                    ]
                ],

                'users' => [
                    'relationship' => 'user',
                    'fields' => ['rating' => 'avg', 'review' => 'avg']
                ]
            ],

            'fields' => [
                'title' => ['like'],
                'desc' => ['like'],
                'rating' => ['avg']
            ],

            'sort' => [
                'fields' => ['date_of_writing', 'title']
            ]
        ]
    ];
