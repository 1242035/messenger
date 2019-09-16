<?php
namespace Viauco\Messenger\Events;
use Illuminate\Broadcasting\PrivateChannel;

class UserChannel extends Broadcast
{
    public $data;

    public $channel;

    public $type = 'notification';

    public function __construct($data, $channel)
    {
        $this->data      = $data;
        $this->channel   = $channel;
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
