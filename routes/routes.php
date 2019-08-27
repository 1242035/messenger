<?php

Route::group(['prefix' => '_conversations', 'namespace' => 'Viauco\Messenger\Controllers', 'middleware' => config('messenger.auth.middleware') ], function () 
{
    Route::group(['prefix' => 'discussions'], function () 
    {
        Route::get('/{sourceId}/{targetId}', ['as' => 'viauco_messenger_discussions_getOrCreate', 'uses' => 'DiscussionController@discussionGetOrCreate']);
        Route::get('/{discussionId}', ['as' => 'viauco_messenger_discussions_get', 'uses' => 'DiscussionController@discussionGet']);
        Route::put('/{discussionId}', ['as' => 'viauco_messenger_discussions_put', 'uses' => 'DiscussionController@discussionPut']);

        Route::post('/{discussionId}/participations/{participationId}', ['as' => 'viauco_messenger_discussions_participations_post', 'uses' => 'ParticipationController@participationPost']);
        Route::delete('/{discussionId}/participations/{participationId}', ['as' => 'viauco_messenger_discussions_participations_delete_id', 'uses' => 'ParticipationController@participationDelete']);
        
        Route::get('/{discussionId}/messages', ['as' => 'viauco_messenger_discussions_messages_get', 'uses' => 'DiscussionController@messageGetAll']);
        Route::post('/{discussionId}/messages', ['as' => 'viauco_messenger_discussions_messages_post', 'uses' => 'DiscussionController@messagePost']);
        Route::get('/{discussionId}/messages/{id}', ['as' => 'viauco_messenger_discussions_messages_get_id', 'uses' => 'DiscussionController@messageGet']);
        Route::put('/{discussionId}/messages/{id}', ['as' => 'viauco_messenger_discussions_messages_put_id', 'uses' => 'DiscussionController@messagePut']);
        Route::delete('/{discussionId}/messages/{id}', ['as' => 'viauco_messenger_discussions_messages_delete_id', 'uses' => 'DiscussionController@messageDelete']);
    });

    Route::group(['prefix' => 'notifications'], function () 
    {
        Route::get('/', ['as' => 'viauco_messenger_notifications_index', 'uses' => 'NotificationController@index']);
    });
});