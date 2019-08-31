<?php
namespace Viauco\Messenger\Events\Socket;
use Illuminate\Broadcasting\PresenceChannel;

class ChannelUnsubscribe extends Channel
{

    public function __construct($connection, $request = null)
    {
        parent::__construct($connection, $request);
    }

    public function broadcastAs()
    {
        return 'channel-unsubscribe';
    }
}   
