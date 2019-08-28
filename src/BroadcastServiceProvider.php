<?php

namespace Viauco\Messenger;

use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends PackageEventServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes( ['middleware' => config('messenger.auth.middleware') ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/channels.php');
    }
}
