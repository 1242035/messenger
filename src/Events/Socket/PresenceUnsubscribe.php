<?php
namespace Viauco\Messenger\Events\Socket;

class PresenceUnsubscribe extends Channel
{
    
    public function __construct($connection, $request = null)
    {
       parent::__construct($connection, $request);
    }

    public function broadcastAs()
    {
        return 'presence-unsubscribe';
    }
}   
