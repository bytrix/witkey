<?php

return [

    'title' => 'Attachment',
    'single' => 'Attachment',
    'model' => 'Attachment',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'file_name' => [
            'title' => 'File Name',
        ],
        'file_hash' => [
            'title' => 'File Hash',
        ],
        'file_ext' => [
            'title' => 'File Extension',
        ],
        'task_id' => [
            'title' => 'Task ID',
        ],
        'created_at',
    ],

    'edit_fields' => [
        'file_name' => [
            'title' => 'File Name',
            'type' => 'text'
        ],
        'file_hash' => [
            'title' => 'File Hash',
            'type' => 'text'
        ],
        'file_ext' => [
            'title' => 'File Extension',
            'type' => 'text'
        ],
        'task_id' => [
            'title' => 'Task ID',
            'type' => 'text'
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID'
        ],
        'file_name' => [
            'title' => 'File Name',
        ],
        'file_hash' => [
            'title' => 'File Hash',
        ],
        'file_ext' => [
            'title' => 'File Extension',
        ],
        'task_id' => [
            'title' => 'Task ID',
        ],
    ],
];
