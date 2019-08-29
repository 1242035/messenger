<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('public', function ($user) {
    return true;
});

Broadcast::channel('_discussion_{id}', function ($user, $discussionId) {
    return ['id' => 2, 'email' => 'tiachopden304@gmail.com'];
});

Broadcast::channel('_message_{id}', function ($user, $id) {
    return (array)$user;
});