<?php
namespace Viauco\Messenger\Events\Socket;
use Illuminate\Broadcasting\PresenceChannel;

class privateSubscribe extends Channel
{
    
    public function __construct($connection, $request = null)
    {
        parent::__construct($connection, $request);
    }

    public function broadcastAs()
    {
        return 'private-subscribe';
    }
}   
