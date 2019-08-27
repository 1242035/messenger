<?php

namespace Viauco\Messenger\Listeners;

use Viauco\Messenger\Events\DiscussionCreate;

class DiscussionCreateBroadcastListener extends Base
{

    /**
     * Handle the event.
     *
     * @param  Base  $event
     * @return void
     */
    public function handle(DiscussionCreate $event)
    {
        logger()->info('DiscussionCreateListener start');
        broadcast( $event );
        logger()->info('DiscussionCreateListener end');
    }
}
