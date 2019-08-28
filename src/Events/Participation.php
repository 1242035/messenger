<?php
namespace Viauco\Messenger\Events;
use Illuminate\Broadcasting\PresenceChannel;

class Participation extends Base
{
    public $request;

    public $participation;

    public $discussion;

    public function __construct($request, $discussion, $participation)
    {
        $this->request          = $request;
        $this->discussion       = $discussion;
        $this->participation    = $participation;
    }

    public function broadcastOn()
    {
        return new PresenceChannel( '_participation_'. $this->discussion->getKey() );
    }

    public function broadcastAs()
    {
        return '_participation';
    }
}
