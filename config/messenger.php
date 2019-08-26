<?php

return [

    /* -----------------------------------------------------------------
     |  Database
     | -----------------------------------------------------------------
     */

    'database' => [
        'connection' => env('DB_CONNECTION', 'mongodb'),

        'prefix'     => null,
    ],

    /* -----------------------------------------------------------------
     |  Models
     | -----------------------------------------------------------------
     */

    'users' => [
        'table' => 'users',
        'model' => App\User::class,
        'morph' => 'participable',
    ],

    'discussions' => [
        'table' => 'discussions',
        'model' => Viauco\Messenger\Models\Discussion::class
    ],

    'participations' => [
        'table' => 'participations',
        'model' => Viauco\Messenger\Models\Participation::class,
    ],

    'messages' => [
        'table' => 'messages',
        'model' => Viauco\Messenger\Models\Message::class
    ],

    /*
        events
    */
    'events' => [
        'public' => [
            'channel' => '_conversations',
            'name'    => '_conversations'
        ]
    ]
];
