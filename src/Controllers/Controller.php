<?php

namespace Viauco\Messenger\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() 
    {
        //$this->middleware('auth');
    }

    protected function _success($data)
    {
        return response()->json([
            'code'    => 200,
            'type'    => 'success',
            'message' => 'Success',
            'data'    => $data
        ]);
    }

    protected function _error($code = 500, $type = 'error', $message='error', $data = null)
    {
        return response()->json([
            'code'    => $code,
            'type'    => $type,
            'message' => $message,
            'params'  => request()->all(),
            'data'    => $data
        ]);
    }
}
