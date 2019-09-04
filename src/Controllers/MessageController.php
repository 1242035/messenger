<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Discussion;
use Viauco\Messenger\Models\Message;
use Viauco\Messenger\Resources\Message as MessageItemResource;
use Viauco\Messenger\Resources\MessageCollection;

class MessageController extends Controller
{
    
    public function messageGetAll($discussionId)
    {
        try
        {
            $params = request()->all();
            
            if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.messages.piginate.limit'); }

            $discussion = Discussion::notDeleted()->findOrFail($discussionId);
            
            $messages = $discussion->messages()->paginate($params['per_page']);

            return $this->_success( new MessageCollection( $messages ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function messagePost(\Viauco\Messenger\Requests\MessageText $request, $discussionId)
    {
        try
        {
            $discussion = Discussion::findOrFail($discussionId);

            $params = $request->except('discussionId');

            $message = Message::create($params);

            $message->participable_id = request()->user()->id;

            $message->participable_type = request()->user()->getMorphClass();

            $discussion->messages()->save( $message );

            $parsedMessage = new MessageItemResource( $message );

            event( new \Viauco\Messenger\Events\MessageCreate( request()->all(), $parsedMessage ) );

            return $this->_success(  $parsedMessage );
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