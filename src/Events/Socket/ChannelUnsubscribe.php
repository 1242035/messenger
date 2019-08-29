<?php
namespace Viauco\Messenger\Events\Socket;
use Illuminate\Broadcasting\PresenceChannel;

class ChannelUnsubscribe extends Channel
{

    public function broadcastAs()
    {
        return '_channel_unsubscribe';
    }
}   