<?php 
namespace Viauco\Messenger;

/**
 * Class     MessengerServiceProvider
 *
 * @package  Viauco\Messenger
 */
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \Viauco\Messenger\Events\DiscussionCreate::class => [
            \Viauco\Messenger\Listeners\DiscussionCreateBroadcastListener::class,
        ],
        \Viauco\Messenger\Events\MessageCreate::class => [
            \Viauco\Messenger\Listeners\MessageCreateListener::class,
        ],
        \Viauco\Messenger\Events\Socket\PresenceSubscribe::class => [
            \Viauco\Messenger\Listeners\PresenceSubscribeListener::class,
        ],
        \Viauco\Messenger\Events\Socket\PresenceUnsubscribe::class => [
            \Viauco\Messenger\Listeners\PresenceUnsubscribeListener::class,
        ],
    ];
}
