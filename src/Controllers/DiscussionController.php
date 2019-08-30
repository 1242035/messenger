<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Discussion;
use Viauco\Messenger\Resources\Discussion as DiscussionItemResource;

class DiscussionController extends Controller
{
    public function discussionGet($discussionId)
    {
        try
        {
            $discussions = Discussion::notDeleted()->findOrFail($discussionId);
            return $this->_success( new DiscussionItemResource( $discussions ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function discussionPut(Discussion $discussion)
    {
        try
        {
            $discussion->save();

            event( new \Viauco\Messenger\Events\DiscussionUpdate( request()->all(), $discussion ) );
            
            return $this->_success( new DiscussionItemResource( $discussions ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function discussionGetOrCreate()
    {
        $request = request();
        try
        {            
            $ids = $request->ids;
            try {
                $ids = explode(',', $ids);
            }catch(\Exception $e){}

            asort( $ids );
            
            $key = implode('_', $ids);
            
            $discussion = Discussion::where(['ids' => $key])->first();

            if( ! isset( $discussion ) ) 
            {
                
                $discussion = Discussion::create([
                    'ids' => $key
                ]);

                $discussion->participable_id = request()->user()->id;

                $discussion->participable_type = request()->user()->getMorphClass();
                
                $discussion->subject = $key;

                $userClass = config('messenger.users.model');

                $users = $userClass::whereIn(( new $userClass )->getKeyName(), $ids )->get();

                $discussion->addParticipants($users);
                
                $discussion->save();

                event( new \Viauco\Messenger\Events\DiscussionCreate( request()->all(), $discussion ) );

            }

            return $this->_success( new DiscussionItemResource($discussion) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }
}