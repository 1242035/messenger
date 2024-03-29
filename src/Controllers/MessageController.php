<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Discussion;
use Viauco\Messenger\Models\Message;
use Viauco\Messenger\Models\Attachable;
use Viauco\Messenger\Resources\Message as MessageItemResource;
use Viauco\Messenger\Resources\Discussion as DiscussionItemResource;
use Viauco\Messenger\Resources\MessageCollection;

class MessageController extends Controller
{

    public function messageGetAll($discussionId)
    {
        try
        {
            $params = request()->all();

            if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.messages.paginate.limit'); }
            $params['page'] = isset( $params['page'] ) ? (int)$params['page'] : 1;

            $discussion = Discussion::findOrFail($discussionId);

            $messages = $discussion->messages()->where(function ($query) use ($params) {
                if( isset( $params['time_end'] ) )
                {
                    $time = \Carbon\Carbon::now();
                    try {
                        $time = \Carbon\Carbon::parse($params['time_end']);
                    } catch(\Exception $e){
                        logger()->error('MessageController messageGetAll ', ['exception' => $e]);
                    }
                    $query->where('updated_at', '<=', $time);
                }
            })
            // this very slow
            ->orderBy('updated_at', 'DESC')
            ->simplePaginate((int)$params['per_page']);


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

            $currentUser = auth()->user();

            $message->participable_id = $currentUser->id;

            $message->participable_type = $currentUser->getMorphClass();

            if( isset( $params['attachments'] ) )
            {
                foreach ( $params['attachments'] as $key => $attach)
                {
                    $attachable = new Attachable($attach);
                    $attachable->discussion_id = $discussion->id;
                    $attachable->participable_id = $currentUser->id;
                    $attachable->participable_type = $currentUser->getMorphClass();
                    $message->attachments()->save($attachable);
                }
            }

            $discussion->messages()->save( $message );

            $parsedMessage = new MessageItemResource( $message );

            event( new \Viauco\Messenger\Events\MessageCreate( $parsedMessage, $discussion->id ) );

            return $this->_success( new MessageItemResource( $parsedMessage ) );
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
