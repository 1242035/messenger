<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Resources\User;

class BroadcastController extends Controller
{
    public function auth()
    {
        return response()->json(new User(auth()->user()));
    }
}