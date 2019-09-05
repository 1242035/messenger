<?php
namespace Viauco\Messenger\Events;
use Illuminate\Broadcasting\PrivateChannel;

class UserChannel extends Broadcast
{
    public $request;

    public $channel;

    public function __construct($request, $channel)
    {
        $this->request      = $request;
        $this->channel      = $channel;
    }

    public function broadcastOn()
    {
        return new PrivateChannel( 'user-' . $this->channel );
    }

    public function broadcastAs()
    {
        return 'user';
    }
}
