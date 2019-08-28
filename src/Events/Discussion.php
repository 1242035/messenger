<?php
namespace Viauco\Messenger\Events;
use Illuminate\Broadcasting\PresenceChannel;

class Discussion extends Base
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
        return new PresenceChannel( '_discussion_'. $this->discussion->getKey() );
    }

    public function broadcastAs()
    {
        return '_discussion';
    }
}
