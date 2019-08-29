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
        return new PresenceChannel( 'participation-'. $this->discussion->getKey() );
    }

    public function broadcastAs()
    {
        return 'participation';
    }

    public function broadcastWith()
    {
        return ['id' => $this->participation->getKey()];
    }
}
