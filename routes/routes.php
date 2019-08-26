<?php

Route::group(['prefix' => '_conversations', 'namespace' => 'Viauco\Messenger\Controllers'], function () 
{
    Route::group(['prefix' => 'discussions'], function () 
    {
        Route::get('/{sourceId}/{targetId}', ['as' => 'viauco_messenger_discussions_getOrCreate', 'uses' => 'DiscussionController@getOrCreate']);
        Route::get('/{discussionId}', ['as' => 'viauco_messenger_discussions_get', 'uses' => 'DiscussionController@get']);
        Route::put('/{discussionId}', ['as' => 'viauco_messenger_discussions_put', 'uses' => 'DiscussionController@put']);
        Route::get('/', ['as' => 'viauco_messenger_discussions_index', 'uses' => 'DiscussionController@index']);
    });

    Route::group(['prefix' => 'participations'], function () 
    {
        Route::get('/', ['as' => 'viauco_messenger_participations_index', 'uses' => 'ParticipationController@index']);
    });

    Route::group(['prefix' => 'messages'], function () 
    {
        Route::get('/', ['as' => 'viauco_messenger_messages_index', 'uses' => 'MessageController@index']);
    });

});