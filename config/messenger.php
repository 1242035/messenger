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
        'model' => Viauco\Messenger\Models\Discussion::class,
        'connection' => env('DB_CONNECTION', 'mongodb'),
    ],

    'participations' => [
        'table' => 'participations',
        'model' => Viauco\Messenger\Models\Participation::class,
        'connection' => env('DB_CONNECTION', 'mongodb'),
        'piginate' => [
            'offset' => 0,
            'limit'  => 25
        ]
    ],

    'messages' => [
        'table' => 'messages',
        'model' => Viauco\Messenger\Models\Message::class,
        'connection' => env('DB_CONNECTION', 'mongodb'),
        'piginate' => [
            'offset' => 0,
            'limit'  => 25
        ]
    ],

    'notifications' => [
        'table' => 'notifications',
        'model' => Viauco\Messenger\Models\Notification::class,
        'connection' => env('DB_CONNECTION', 'mongodb'),
        'piginate' => [
            'offset' => 0,
            'limit'  => 25
        ]
    ],
    /*
        events
    */
    'events' => [
        'public' => [
            'channel' => '_conversations',
            'name'    => '_conversations'
        ]
    ],
    'auth' => [
        'middleware' => ['api']
    ]
];
