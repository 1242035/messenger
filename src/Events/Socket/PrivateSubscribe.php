<?php
namespace Viauco\Messenger\Events\Socket;
use Illuminate\Broadcasting\PresenceChannel;

class privateSubscribe extends Channel
{

    public function broadcastAs()
    {
        return 'private-subscribe';
    }
}   
