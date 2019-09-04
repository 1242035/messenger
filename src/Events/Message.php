<?php
namespace Viauco\Messenger\Events;

use Illuminate\Broadcasting\PresenceChannel;

class Message extends Broadcast
{
    public $request;

    public $message;

    public function __construct($request, $message)
    {
        $this->request    = $request;
        $this->message    = $message;
    }

    public function broadcastOn()
    {
        return new PresenceChannel( 'discussion-'. $this->message->discussion->getKey() );
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
