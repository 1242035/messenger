<?php
namespace Viauco\Messenger\Notifications;

class Discussion extends Base
{

    public function __construct($event)
    {
        $this->data = $event;
    }
}
