<?php

return [

    'title' => 'ReasonForDeleting',
    'single' => 'ReasonForDeleting',
    'model' => 'ReasonForDeleting',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'reason' => [
            'title' => 'ReasonForDeleting Name',
        ],
        'task_id' => [
        	'title' => 'Task ID',
        ],
        'created_at',
    ],

    'edit_fields' => [
        'reason' => [
            'title' => 'ReasonForDeleting Name',
            'type' => 'text'
        ],
        'task_id' => [
        	'title' => 'Task ID',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID'
        ],
        'reason' => [
            'title' => 'ReasonForDeleting Name',
        ],
        'task_id' => [
        	'title' => 'Task ID',
        ],
    ],
];
