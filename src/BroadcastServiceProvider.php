<?php

namespace Viauco\Messenger;

use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*Broadcast::routes( ['middleware' => 'multiauth:member']);
        Broadcast::channel('presence-discussion-{id}', function ($user, $discussionId) {
            return ['id' => 2, 'email' => 'tiachopden304@gmail.com'];
        }, ['guards' => ['member'] ]);
        
        Broadcast::channel('message-{id}', function ($user, $id) {
            return (array)$user;
        }, ['guards' => ['member'] ]);*/
        //$this->loadRoutesFrom(__DIR__.'/../routes/channels.php');
    }
}
