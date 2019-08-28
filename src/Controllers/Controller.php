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
use Illuminate\Notifications\Notifiable;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Notifiable;

    public function __construct() 
    {
        //$this->middleware('auth');
    }

    protected function _success($data)
    {
        $response = [
            'code'    => 200,
            'type'    => 'success',
            'message' => 'Success',
            'data'    => $data
        ];
        //if( isset( $data['meta'])){ $response['meta'] = $data['meta']; }
        //if( isset( $data['links'])){ $response['links'] = $data['links']; }
        return response()->json( $response );
    }

    protected function _error($error = null, $code = 500, $type = 'error', $message='error')
    {
        return response()->json([
            'code'    => $code,
            'type'    => $type,
            'message' => $message,
            'params'  => request()->all(),
            'error'   => $error
        ]);
    }
}
