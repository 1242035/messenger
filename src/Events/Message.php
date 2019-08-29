<?php
namespace Viauco\Messenger\Events;

use Illuminate\Broadcasting\PresenceChannel;

class Message extends Base
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
        return new PresenceChannel( 'messages-'. $this->message->discussion->getKey() );
    }

    public function broadcastAs()
    {
        return 'messages';
    }

    public function broadcastWith()
    {
        return ['id' => $this->message->getKey()];
    }
}
