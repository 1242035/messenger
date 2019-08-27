<?php
namespace Viauco\Messenger;


trait EventMap
{
    /**
     * All event / listener mappings.
     *
     * @var array
     */
    protected $events = [
        Viauco\Messenger\Events\DiscussionCreate::class => [
            Viauco\Messenger\Listeners\DiscussionCreateBroadcastListener::class,
        ],
        Viauco\Messenger\Events\MessageCreate::class => [
            Viauco\Messenger\Listeners\MessageCreateBroadcastListener::class,
        ],
    ];
}