<?php

namespace Viauco\Messenger\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

abstract class BroadcastNow extends Event implements ShouldBroadcastNow
{

}
