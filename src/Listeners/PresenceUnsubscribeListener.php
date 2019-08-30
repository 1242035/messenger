<?php
namespace Viauco\Messenger\Listeners;

use Viauco\Messenger\Events\Socket\PresenceSubscribe;

class PresenceUnsubscribeListener extends Base
{

    /**
     * Handle the event.
     *
     * @param  Base  $event
     * @return void
     */
    public function handle(PresenceSubscribe $event)
    {
        logger()->info('PresenceUnsubscribeListener start');
        
        logger()->info('PresenceUnsubscribeListener end');
    }
}
