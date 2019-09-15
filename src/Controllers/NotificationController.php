<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Notification;
use Viauco\Messenger\Resources\NotificationCollection as Resource;

class NotificationController extends Controller
{
    public function index()
    {
        $params = request()->all();

        if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.notifications.piginate.limit'); }
        $params['page'] = isset( $params['page'] ) ? (int)$params['page'] : 1;
        $collections = Notification::notDeleted()->simplePaginate((int)$params['per_page']);

        return $this->_success( new NotificationCollection( $collections) );
    }
}
