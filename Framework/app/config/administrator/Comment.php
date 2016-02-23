<?php

return [

    'title' => 'Comment',
    'single' => 'Comment',
    'model' => 'Comment',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'from_whom_id' => [
            'title' => 'From Whom ID',
        ],
        'user_id' => [
            'title' => 'User ID',
        ],
        'star' => [
            'title' => 'Star',
        ],
        'content' => [
            'title' => 'Content',
        ],
        'created_at',
    ],

    'edit_fields' => [
        'from_whom_id' => [
            'title' => 'From Whom ID',
            'type' => 'text'
        ],
        'user_id' => [
            'title' => 'User ID',
            'type' => 'text',
        ],
        'star' => [
            'title' => 'Star',
            'type' => 'text',
        ],
        'content' => [
            'title' => 'Content',
            'type' => 'text',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID'
        ],
        'from_whom_id' => [
            'title' => 'From Whom ID',
        ],
        'user_id' => [
            'title' => 'User ID',
        ],
        'star' => [
            'title' => 'Star',
        ],
        'content' => [
            'title' => 'Content',
        ],
    ],
];
