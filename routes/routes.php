<?php

Route::group(['prefix' => '_conversations', 'namespace' => '\Viauco\Messenger\Controllers', 'middleware' => config('messenger.auth.middleware') ], function () 
{
    Route::group(['prefix' => 'discussions'], function () 
    {
        Route::get('/fetch', ['as' => 'viauco_messenger_discussions_getOrCreate_get', 'uses' => 'DiscussionController@discussionGetOrCreate']);
        Route::post('/fetch', ['as' => 'viauco_messenger_discussions_getOrCreate_post', 'uses' => 'DiscussionController@discussionGetOrCreate']);

        Route::post('/{discussionId}/participations/{participationId}', ['as' => 'viauco_messenger_discussions_participations_post', 'uses' => 'ParticipationController@participationPost']);
        Route::delete('/{discussionId}/participations/{participationId}', ['as' => 'viauco_messenger_discussions_participations_delete_id', 'uses' => 'ParticipationController@participationDelete']);
        Route::get('/{discussionId}/participations/{participationId}', ['as' => 'viauco_messenger_discussions_participations_get_id', 'uses' => 'ParticipationController@participationGetId']);
        Route::get('/{discussionId}/participations', ['as' => 'viauco_messenger_discussions_participations_get', 'uses' => 'ParticipationController@participationGet']);

        Route::get('/{discussionId}/messages/{id}', ['as' => 'viauco_messenger_discussions_messages_get_id', 'uses' => 'MessageController@messageGet']);
        Route::put('/{discussionId}/messages/{id}', ['as' => 'viauco_messenger_discussions_messages_put_id', 'uses' => 'MessageController@messagePut']);
        Route::delete('/{discussionId}/messages/{id}', ['as' => 'viauco_messenger_discussions_messages_delete_id', 'uses' => 'MessageController@messageDelete']);
        Route::get('/{discussionId}/messages', ['as' => 'viauco_messenger_discussions_messages_get', 'uses' => 'MessageController@messageGetAll']);
        Route::post('/{discussionId}/messages', ['as' => 'viauco_messenger_discussions_messages_post', 'uses' => 'MessageController@messagePost']);
        
        Route::get('/{discussionId}', ['as' => 'viauco_messenger_discussions_get', 'uses' => 'DiscussionController@discussionGet']);
        Route::put('/{discussionId}', ['as' => 'viauco_messenger_discussions_put', 'uses' => 'DiscussionController@discussionPut']);

    });

    Route::group(['prefix' => 'notifications'], function () 
    {
        Route::get('/', ['as' => 'viauco_messenger_notifications_index', 'uses' => 'NotificationController@index']);
    });

    Route::post('/auth', ['as' => 'viauco_messenger_conversations_auth', 'uses' => 'BroadcastController@auth']);

    Route::post('/search/by_user', ['as' => 'viauco_messenger_discussions_participations_chatted_by_user_post', 'uses' => 'DiscussionController@searchByUser']);
    Route::get('/search/by_user', ['as' => 'viauco_messenger_discussions_participations_chatted_by_user_get', 'uses' => 'DiscussionController@searchByUser']);
});

//socket route
\Viauco\Messenger\Socket\WebSocketsRouter::webSocket( config('websockets.path') , \Viauco\Messenger\Socket\SocketHandler::class);