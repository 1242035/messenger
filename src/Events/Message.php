<?php
namespace Viauco\Messenger\Events;

use Illuminate\Broadcasting\PresenceChannel;

class Message extends BroadcastNow
{
    public $request;

    public $message;

    public $discussion;

    public function __construct($request, $message, $discussion)
    {
        $this->request    = $request;
        $this->message    = $message;
        $this->discussion = $discussion;
    }

    public function broadcastOn()
    {
        return new PresenceChannel( 'discussion-'. $this->discussion->id );
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
