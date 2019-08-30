<?php
namespace Viauco\Messenger\Listeners;

use Viauco\Messenger\Events\MessageRemove;

class MessageCreateBroadcastListener extends Base
{

    /**
     * Handle the event.
     *
     * @param  Base  $event
     * @return void
     */
    public function handle(MessageCreate $event)
    {
        logger()->info('MessageCreateBroadcastListener start');
        
        logger()->info('MessageCreateBroadcastListener end');
    }
}
