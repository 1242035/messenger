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

Broadcast::channel('public', function ($user) 
{
    return true;
});

Broadcast::channel('discussion-{id}', function ($user, $discussionId) 
{
    return ['id' => $user->id, 'email' => $user->email, 'discussion_id' => $discussionId];
});

Broadcast::channel('message-{id}', function ($user, $id) 
{
    return ['id' => $user->id, 'email' => $user->email, 'discussion_id' => $discussionId];
});