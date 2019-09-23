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
        $notify = new \Viauco\Messenger\Notifications\Discussion( $event );

        $event->discussion->notify( $notify );
    }
}
