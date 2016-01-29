<?php

return [

    'title' => 'Category',
    'single' => 'Category',
    'model' => 'Category',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'name' => [
            'title' => 'Name Inside',
        ],
        'name2' => [
            'title' => 'Name Outside',
        ],
        'created_at',
    ],

    'edit_fields' => [
        'name' => [
            'title' => 'Name Inside',
            'type' => 'text',
        ],
        'name2' => [
            'title' => 'Name Outside',
            'type' => 'text',
        ]
    ],

    'filters' => [
        'id' => [
            'title' => 'ID'
        ],
        'name' => [
            'title' => 'Name Inside',
        ],
        'name2' => [
            'title' => 'Name Outside',
        ]
    ],
];
