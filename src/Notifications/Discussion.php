<?php
namespace Viauco\Messenger\Notifications;

use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;
use NotificationChannels\OneSignal\OneSignalWebButton;

class Discussion extends Base
{

    public function __construct($event)
    {
        $this->data = $event;
    }

    public function toArray($notifiable)
    {
        return [
            'id' => $this->data->id,
            'subject' => $this->data->subject,
            'author' => [
                'id' => $this->author->id,
                'fullName' => $this->author->fullName,
                'avatar' => $this->author->cover,
            ]
        ];
    }

    public function toOneSignal($notifiable)
    {
        return OneSignalMessage::create()
            ->subject("Your {$notifiable->service} account was approved!")
            ->body("Click here to see details.")
            ->url('http://onesignal.com')
            ->webButton(
                OneSignalWebButton::create('link-1')
                    ->text('Click here')
                    ->icon('https://upload.wikimedia.org/wikipedia/commons/4/4f/Laravel_logo.png')
                    ->url('http://laravel.com')
            );
    }
}
