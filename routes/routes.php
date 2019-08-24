<?php

Route::group(['prefix' => 'conversations', 'namespace' => 'Viauco\Messenger\Controllers'], function () 
{
    Route::group(['prefix' => 'discussions'], function () 
    {
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