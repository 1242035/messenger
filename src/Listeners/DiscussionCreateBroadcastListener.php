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
        //logger()->debug('DiscussionCreateListener start');
        
        $notify = new \Viauco\Messenger\Notifications\Discussion( $event );

        $event->discussion->notify( $notify );

        //logger()->debug('DiscussionCreateListener end');
    }
}
