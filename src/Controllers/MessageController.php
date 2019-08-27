<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Discussion;
use Viauco\Messenger\Models\Message;
use Viauco\Messenger\Resources\Message as MessageItemResource;
use Viauco\Messenger\Resources\MessageCollection;

class MessageController extends Controller
{
    /* SECTION discussion */
    public function messageGetAll($discussionId)
    {
        try
        {
            $params = request()->all();
            
            if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.messages.piginate.limit'); }

            $discussions = Discussion::findOrFail($discussionId)->notDeleted();

            $messages = $discussions->messages()->notDeleted()->paginate($params['per_page']);

            return $this->_success( new MessageCollection( $messages ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function messagePost($discussionId)
    {
        try
        {
            $discussion = Discussion::findOrFail($discussionId);

            $params = request()->except('discussionId');

            $message = Message::create($params);

            $discussion->messages()->save( $message );

            event( new \Viauco\Messenger\Events\MessageAdd( request()->all(), $message ) );

            return $this->_success( new MessageItemResource( $message ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function messageGet($discussionId, $messageId)
    {
        try
        {
            $message = Message::findOrFail($messageId);

            return $this->_success( new MessageItemResource( $message ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function messagePut($discussionId, $messageId)
    {
        try
        {

            $message = Message::findOrFail($messageId);

            $params = request()->all();

            $message->update( $params );
            
            event( new \Viauco\Messenger\Events\MessageUpdate( request()->all(), $message ) );

            return $this->_success( new MessageItemResource( $message ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function messageDelete($discussionId, $messageId)
    {
        try
        {
            $message = Message::findOrFail($messageId);

            $message->delete();
            
            event( new \Viauco\Messenger\Events\MessageRemove( request()->all(), $message ) );

            return $this->_success( new MessageItemResource( $message ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }
}