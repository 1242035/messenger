<?php
namespace Viauco\Messenger\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Discussion extends Base
{

    public function __construct($event)
    {
        $this->data = $event;
    }
}
