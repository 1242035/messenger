<?php
namespace Viauco\Messenger\Events\Socket;
use Illuminate\Broadcasting\PresenceChannel;

class PresenceSubscribe extends Channel
{

    public function broadcastAs()
    {
        return 'presence-subscribe';
    }
}   
