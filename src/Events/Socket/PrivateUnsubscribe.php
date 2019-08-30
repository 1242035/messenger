<?php
namespace Viauco\Messenger\Events\Socket;
use Illuminate\Broadcasting\PresenceChannel;

class PrivateUnsubscribe extends Channel
{

    public function broadcastAs()
    {
        return 'private-unsubscribe';
    }
}   
