<?php
namespace Viauco\Messenger\Events\Socket;
use Illuminate\Broadcasting\PresenceChannel;

class ChannelSubscribe extends Channel
{

    public function broadcastAs()
    {
        return '_channel_subscribe';
    }
}   