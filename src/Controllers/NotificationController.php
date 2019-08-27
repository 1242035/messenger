<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Notification;
use Viauco\Messenger\Resources\Notification as Resource;

class NotificationController extends Controller
{
    public function index()
    {
        $params = request()->all();
        
        if( ! isset( $params['offset'] ) ){ $params['offset'] = 0; }
        if( ! isset( $params['limit'] ) ){ $params['limit'] = config('messenger.notifications.piginate.limit'); }

        $collections = Notification::take($params['limit'])->skip($params['offset']);

        return $this->_success(Resource::collection( $collections) );
    }
}