<?php

return [

    'title' => 'Task',
    'single' => 'Task',
    'model' => 'Task',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'title' => [
            'title' => 'Task Title',
        ],
        'detail' => [
            'title' => 'Task Detail',
        ],
        'type' => [
            'title' => 'Type',
        ],
        'amount' => [
            'title' => 'Amount',
        ],
        'user_id' => [
            'title' => 'Publisher ID',
        ],
        'category' => [
            'title' => 'Category',
            'relationship' => 'category',
            'select' => '(:table).name',
        ],
        'state' => [
            'title' => 'Task State',
        ],
        'expiration' => [
            'title' => 'Expiration',
        ],
        'place' => [
            'title' => 'Place',
            'relationship' => 'place',
            'select' => '(:table).name',
        ],
        'created_at',
    ],

    'edit_fields' => [
        'title' => [
            'title' => 'Task Title',
            'type' => 'text',
        ],
        'detail' => [
            'title' => 'Task Detail',
            'type' => 'text',
        ],
        // 'type' => [
        //     'title' => 'Type',
        //     'type' => 'text',
        // ],
        // 'amount' => [
        //     'title' => 'Amount',
        //     'type' => 'text',
        // ],
        // 'user_id' => [
        //     'title' => 'Publisher ID',
        //     'type' => 'text',
        // ],
        'category' => [
            'title' => 'Category',
            'type' => 'relationship',
            // 'type' => 'text',
            // 'relationship' => 'category',
            // 'select' => '(:table).name_inside',
        ],
        // 'state' => [
        //     'title' => 'Task State',
        //     'type' => 'text',
        // ],
        // 'expiration' => [
        //     'title' => 'Expiration',
        //     'type' => 'date',
        // ],
        // 'place' => [
        //     'title' => 'Place',
        //     'type' => 'relationship',
        // ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID'
        ],
        'title' => [
            'title' => 'Task Title',
        ],
        'detail' => [
            'title' => 'Task Detail',
        ],
        'type' => [
            'title' => 'Type',
        ],
        'amount' => [
            'title' => 'Amount',
        ],
        'user_id' => [
            'title' => 'Publisher ID',
        ],
        'category_id' => [
            'title' => 'Category',
        ],
        'state' => [
            'title' => 'Task State',
        ],
        'expiration' => [
            'title' => 'Expiration',
        ],
        'place' => [
            'title' => 'Place',
        ],
    ],
];
