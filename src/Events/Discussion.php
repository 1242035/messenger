<?php
namespace Viauco\Messenger\Events;
use Illuminate\Broadcasting\PresenceChannel;

class Discussion extends Broadcast
{
    public $request;

    public $discussion;

    public function __construct($request, $discussion)
    {
        $this->request       = $request;
        $this->discussion    = $discussion;
    }

    public function broadcastOn()
    {
        return new PresenceChannel( 'discussion-' . $this->discussion->getKey() );
    }

    public function broadcastAs()
    {
        return 'discussion';
    }

    public function broadcastWith()
    {
        return [ 'id' => $this->discussion->getKey() ];
    }
}   
