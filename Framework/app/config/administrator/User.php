<?php

return [

    'title' => 'User',
    'single' => 'User',
    'model' => 'User',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'username' => [
            'title' => 'User Name',
        ],
        'truename' => [
            'title' => 'True Name',
        ],
        'email' => [
            'title' => 'Email',
        ],
        'school' => [
            'title' => 'School',
            'relationship' => 'school',
            'select' => '(:table).name',
        ],
        'created_at',
    ],

    'edit_fields' => [
        'username' => [
            'title' => 'User Name',
            'type' => 'text',
        ],
        'truename' => [
            'title' => 'True Name',
            'type' => 'text',
        ],
        'email' => [
            'title' => 'Email',
            'type' => 'text',
        ],
        'school' => [
            'title' => 'School',
            'type' => 'relationship',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID'
        ],
        'username' => [
            'title' => 'User Name',
        ],
        'truename' => [
            'title' => 'True Name',
        ],
        'email' => [
            'title' => 'Email',
        ],
        'school' => [
            'title' => 'School',
        ],
    ],
];
