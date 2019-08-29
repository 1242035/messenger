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
        Broadcast::routes( ['middleware' => 'multiauth:member']);
        
        $this->loadRoutesFrom(__DIR__.'/../routes/channels.php');
    }
}
