<?php
namespace Viauco\Messenger\Events\Socket;

class PresenceSubscribe extends Channel
{
    
    public function __construct($connection, $request = null)
    {
       parent::__construct($connection, $request);
    }

    public function broadcastAs()
    {
        return 'presence-subscribe';
    }
}   
