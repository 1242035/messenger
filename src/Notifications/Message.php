<?php
namespace Viauco\Messenger\Notifications;

class Message extends Base
{

    public function __construct($event)
    {
        $this->data = $event;
    }

    public function via($notifiable)
    {
        return ['database'];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return (array)$this->data;
    }
}
