<?php 
namespace Viauco\Messenger;

/**
 * Class     MessengerServiceProvider
 *
 * @package  Viauco\Messenger
 */
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class PackageEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \Viauco\Messenger\Events\DiscussionCreate::class => [
            \Viauco\Messenger\Listeners\DiscussionCreateBroadcastListener::class,
        ],
        \Viauco\Messenger\Events\MessageCreate::class => [
            \Viauco\Messenger\Listeners\MessageCreateBroadcastListener::class,
        ],
    ];
}
