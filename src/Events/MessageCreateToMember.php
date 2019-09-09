<?php
namespace Viauco\Messenger\Events;
use Illuminate\Broadcasting\PresenceChannel;

class MessageCreateToMember extends UserChannel
{

    public function broadcastOn()
    {
        return new PresenceChannel( 'user-'. $this->channel );
    }

    public function broadcastAs()
    {
        return 'message';
    }
}
