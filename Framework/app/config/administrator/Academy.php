<?php

return [

    'title' => 'Academy',
    'single' => 'Academy',
    'model' => 'Academy',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'name' => [
            'title' => 'Academy Name',
        ],
        'created_at',
    ],

    'edit_fields' => [
        'name' => [
            'title' => 'Academy Name',
            'type' => 'text'
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID'
        ],
        'name' => [
            'title' => 'Academy Name',
        ],
    ],
];
