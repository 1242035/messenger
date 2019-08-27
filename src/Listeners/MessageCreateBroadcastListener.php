<?php

namespace Viauco\Messenger\Listeners;

use Viauco\Messenger\Events\MessageCreate;

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
        logger()->info('DiscussionCreateListener start');
        broadcast( $event );
        logger()->info('DiscussionCreateListener end');
    }
}
