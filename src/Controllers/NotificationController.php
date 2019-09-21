<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Notification;
use Viauco\Messenger\Resources\Notification as NotificationResource;
use Viauco\Messenger\Resources\NotificationCollection;

class NotificationController extends Controller
{
    public function index()
    {
        $params = request()->all();

        if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.notifications.paginate.limit'); }
        $params['page'] = isset( $params['page'] ) ? (int)$params['page'] : 1;
        $collections = Notification::simplePaginate((int)$params['per_page']);

        return $this->_success( new NotificationCollection( $collections) );
    }

    public function searchByUser()
    {
        try
        {
            $request = request();

            $params = $request->all();

            if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.notification.paginate.limit'); }
            if( ! isset( $params['page'] ) ){ $params['page'] = 1; } else { $params['page'] = (int)$params['page']; }
            $notifications = auth()->user()
                            ->notifications()
                            ->orderBy('updated_at', 'DESC')
                            ->simplePaginate((int)$params['per_page']);
            /*$discussions = Notification::forModel(auth()->user())
                ->orderBy('updated_at', 'DESC')
                ->simplePaginate((int)$params['per_page']);*/
            return $this->_success( new NotificationCollection( $notifications )  );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function markAsRead($notificationId)
    {
        try
        {
            $notification = Notification::findOrFail($notificationId);

            $notification->markAsRead(auth()->user());

            return $this->_success( new NotificationResource( $notification ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function markAsReadAll()
    {
        try
        {
            auth()->user()->notifications->markAsRead();
            //Notification::forModel( $user )->markAsRead( $user );
            return $this->_success([]);
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }
}
