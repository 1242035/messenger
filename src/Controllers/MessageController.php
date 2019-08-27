<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Discussion;
use Viauco\Messenger\Models\Message;
use Viauco\Messenger\Resources\Message as MessageItemResource;

class MessageController extends Controller
{
    /* SECTION discussion */
    public function messageGetAll($discussionId)
    {
        try
        {
            $params = request()->all();

            if( ! isset( $params['offset'] ) ){ $params['offset'] = 0; }
            if( ! isset( $params['limit'] ) ){ $params['limit'] = config('messenger.messages.piginate.limit'); }

            $discussions = Discussion::findOrFail($discussionId);

            $messages = $discussions->messages()->take($params['limit'])->skip($params['offset']);
            return $this->_success( MessageItemResource::collection( $messages ) );
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
            $discussions = Discussion::findOrFail($discussionId);

            $message = request()->except('discussionId');

            $discussion->messages()->save( $message );

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

            $params = request()->except('discussionId');

            $message->save( $params );
            
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
            
            return $this->_success( new MessageItemResource( $message ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }
}