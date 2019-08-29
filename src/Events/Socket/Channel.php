<?php
namespace Viauco\Messenger\Events\Socket;
use Illuminate\Broadcasting\PresenceChannel;

class Channel extends Base
{
    public $request;

    public $connection;

    public function __construct($connection, $request = null)
    {
        $this->request       = $request;
        $this->connection    = $connection;
    }

    public function broadcastAs()
    {
        return '_channel';
    }
}   
