<?php

namespace Viauco\Messenger\Events\Socket;

use Illuminate\Broadcasting\PresenceChannel;

abstract class Base extends \Viauco\Messenger\Events\Base
{

    //public $broadcastQueue = '_conversations';

    public function broadcastOn()
    {
        return new PresenceChannel( 'sockets' );
    }

    public function broadcastAs()
    {
        return 'sockets';
    }
}
