<?php
namespace Viauco\Messenger\Events;

use Illuminate\Broadcasting\PresenceChannel;

class Message extends BroadcastNow
{
    public $discussionId;

    public $message;

    public function __construct($message, $discussionId)
    {
        $this->message    = $message;
        $this->discussionId = $discussionId;
    }

    public function broadcastOn()
    {
        return new PresenceChannel( 'discussion-'. $this->discussionId );
    }

    public function broadcastAs()
    {
        return 'message';
    }

    /*public function broadcastWith()
    {
        return ['id' => $this->message->getKey()];
    }*/
}
