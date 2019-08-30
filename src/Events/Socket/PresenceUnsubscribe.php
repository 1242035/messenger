<?php
namespace Viauco\Messenger\Events\Socket;
use Illuminate\Broadcasting\PresenceChannel;

class PresenceUnsubscribe extends Channel
{

    public function broadcastAs()
    {
        return 'presence-unsubscribe';
    }
}   
