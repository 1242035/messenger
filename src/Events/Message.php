<?php
namespace Viauco\Messenger\Events;

use Illuminate\Broadcasting\PresentChannel;

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
        return new PresentChannel( '_messages');
    }

    public function broadcastAs()
    {
        return '_messages';
    }
}
