<?php
namespace Viauco\Messenger\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Base implements ShouldQueue
{
    use InteractsWithQueue;
}
