<?php
namespace Viauco\Messenger\Listeners;

use Viauco\Messenger\Events\Socket\PresenceSubscribe;

class PresenceSubscribeListener extends Base
{

    /**
     * Handle the event.
     *
     * @param  Base  $event
     * @return void
     */
    public function handle(PresenceSubscribe $event)
    {
        logger()->error('PresenceSubscribeListener start');

        $connection = $event->connection;
        $payload    = $event->request;

        if( isset( $connection ) && isset( $payload ) )
        {

        }

        logger()->info('PresenceSubscribeListener end');
    }
}
