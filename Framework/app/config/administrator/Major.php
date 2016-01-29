<?php

return [

    'title' => 'Major',
    'single' => 'Major',
    'model' => 'Major',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'name' => [
            'title' => 'Major Name',
        ],
        'academy_id' => [
            'title' => 'Academy ID',
        ],
        'created_at',
    ],

    'edit_fields' => [
        'name' => [
            'title' => 'Major Name',
            'type' => 'text'
        ],
        'academy_id' => [
            'title' => 'Academy ID',
            'type' => 'text',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID'
        ],
        'name' => [
            'title' => 'Major Name',
        ],
        'academy_id' => [
            'title' => 'Academy ID',
        ],
    ],
];
