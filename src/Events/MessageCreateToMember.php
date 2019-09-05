<?php
namespace Viauco\Messenger\Events;

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
