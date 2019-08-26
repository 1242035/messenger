<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Discussion;
use Viauco\Messenger\Resources\Discussion as DiscussionItemResource;

class DiscussionController extends Controller
{
    public function index()
    {
        try
        {
            $discussions = Discussion::all();
            return $this->_success( DiscussionItemResource::collection( $discussions ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function get($discussionId)
    {
        try
        {
            $discussions = Discussion::findOrFail($discussionId);
            return $this->_success( new DiscussionItemResource( $discussions ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function put(Discussion $discussion)
    {
        try
        {
            $discussion->save();
            return $this->_success( new DiscussionItemResource( $discussions ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function getOrCreate($sourceId, $targetId)
    {
        try
        {
            $ids = [$sourceId, $targetId];

            asort( $ids );
            
            $key = implode('_', $ids);

            $discussion = Discussion::updateOrCreate([
                'key' => $key
            ]);

            $discussion->subject = $key;

            $userClass = config('messenger.users.model');

            $users = $userClass::whereIn(( new $userClass )->getKeyName(), $ids )->get();

            $discussion->addParticipants($users);

            event( new \Viauco\Messenger\Events\DiscussionCreate( request()->all(), $discussion ) );

            return $this->_success( new DiscussionItemResource($discussion) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function users($conversionId)
    {

    }
}