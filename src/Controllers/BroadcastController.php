<?php
namespace Viauco\Messenger\Controllers;

use Illuminate\Support\Facades\Broadcast;

class BroadcastController extends Controller
{
    public function auth()
    {
        return Broadcast::auth( request() );
    }
}