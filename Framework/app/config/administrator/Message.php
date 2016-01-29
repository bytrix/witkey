<?php

return [

    'title' => 'Message',
    'single' => 'Message',
    'model' => 'Message',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'from_user_id' => [
            'title' => 'From User ID',
        ],
        'to_user_id' => [
            'title' => 'To User ID',
        ],
        'message' => [
            'title' => 'Message',
        ],
        'read' => [
            'title' => "Read",
        ],
        'created_at',
    ],

    'edit_fields' => [
        'from_user_id' => [
            'title' => 'From User ID',
            'type' => 'text'
        ],
        'to_user_id' => [
            'title' => 'To User ID',
            'type' => 'text',
        ],
        'message' => [
            'title' => 'Message',
            'type' => 'text',
        ],
        'read' => [
            'title' => "Read",
            'type' => 'text',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID'
        ],
        'from_user_id' => [
            'title' => 'From User ID',
        ],
        'to_user_id' => [
            'title' => 'To User ID',
        ],
        'message' => [
            'title' => 'Message',
        ],
        'read' => [
            'title' => "Read",
        ],
    ],
];
