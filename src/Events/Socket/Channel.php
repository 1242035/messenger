<?php
namespace Viauco\Messenger\Events\Socket;
use Illuminate\Broadcasting\PresenceChannel;

class Channel extends Base
{
    public $request;

    public $connection;

    public function __construct($connection, $request = null)
    {
        $this->connection    = $connection;
        $this->request       = $request;
        parent::__construct();
    }

    public function broadcastAs()
    {
        return 'channel';
    }
}   
