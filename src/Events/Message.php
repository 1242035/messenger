<?php
namespace Viauco\Messenger\Events;

class Message extends Base
{
    public $request;

    public $message;

    public function __construct($request, $message)
    {
        $this->request    = $request;
        $this->message    = $message;
    }
}
