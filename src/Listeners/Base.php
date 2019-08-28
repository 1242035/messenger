<?php
namespace Viauco\Messenger\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Notifications\Notifiable;
use Viauco\Messenger\Traits\Notifiable;

class Base implements ShouldQueue
{
    use InteractsWithQueue, Notifiable;
}
