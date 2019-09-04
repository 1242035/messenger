<?php

return [

    /* -----------------------------------------------------------------
     |  Database
     | -----------------------------------------------------------------
     */

    'database' => [
        'connection' => env('DB_CONNECTION', 'mongodb'),
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
        'connection' => null,
    ],

    'participations' => [
        'table' => 'participations',
        'model' => Viauco\Messenger\Models\Participation::class,
        'connection' => null,
        'piginate' => [
            'offset' => 0,
            'limit'  => 25
        ]
    ],

    'messages' => [
        'table' => 'messages',
        'model' => Viauco\Messenger\Models\Message::class,
        'connection' => null,
        'piginate' => [
            'offset' => 0,
            'limit'  => 25
        ]
    ],
    'attachments' => [
        'table' => 'attachments',
        'model' => Viauco\Messenger\Models\Attachable::class,
        'connection' => null,
        'piginate' => [
            'offset' => 0,
            'limit'  => 25
        ]
    ],
    'informations' => [
        'table' => 'informations',
        'model' => Viauco\Messenger\Models\Information::class,
        'connection' => null,
        'piginate' => [
            'offset' => 0,
            'limit'  => 25
        ]
    ],
    'notifications' => [
        'table' => 'notifications',
        'model' => Viauco\Messenger\Models\Notification::class,
        'connection' => null,
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
