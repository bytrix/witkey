<?php

return [

    'title' => 'ReasonForReporting',
    'single' => 'ReasonForReporting',
    'model' => 'ReasonForReporting',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'reason' => [
            'title' => 'ReasonForReporting Name',
        ],
        'task_id' => [
            'title' => 'Task ID',
        ],
        'created_at',
    ],

    'edit_fields' => [
        'reason' => [
            'title' => 'ReasonForReporting Name',
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
            'title' => 'ReasonForReporting Name',
        ],
        'task_id' => [
            'title' => 'Task ID',
        ],
    ],
];
