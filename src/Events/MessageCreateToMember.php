<?php
namespace Viauco\Messenger\Events;

class MessageCreateToMember extends UserChannel
{
    public $type = 'message';

    public function broadcastAs()
    {
        return 'message';
    }
}
