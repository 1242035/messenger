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

Broadcast::channel('user-{id}', function ($user, $userId)
{
    return ['id' => $user->id, 'email' => $user->email, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'avatar' => $user->cover];
});

Broadcast::channel('discussion-{id}', function ($user, $discussionId)
{
    return ['id' => $user->id, 'email' => $user->email, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'avatar' => $user->cover, 'discussion_id' => $discussionId];
});

Broadcast::channel('message-{id}', function ($user, $id)
{
    return ['id' => $user->id, 'email' => $user->email, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'avatar' => $user->cover, 'discussion_id' => $discussionId];
});
