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

    public function discussionGetTrash()
    {
        try
        {
            $params = request()->all();

            if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.discussions.piginate.limit'); }

            $discussions = Discussion::onlyTrashed()->orderBy('updated_at','DESC')->paginate($params['per_page']);

            return $this->_success( DiscussionItemResource::collection( $discussions ) );
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

    public function discussionGetOrCreate(\Viauco\Messenger\Requests\DiscussionGet $request)
    {
        try
        {
            $ids = $request->ids;
            try {
                $ids = explode(',', $ids);
            }catch(\Exception $e){}

            if( ! isset( $ids ) ) {
                return $this->_error( [
                    'error' => 'invalid_params'
                ] );
            }
            $ids = array_unique($ids);

            asort( $ids );

            if( count( $ids ) <= 1 ) {
                return $this->_error( [
                    'error' => 'invalid_params'
                ] );
            }

            $key = trim( trim( implode('_', $ids),'_') );

            if( empty( $key ) )
            {
                return $this->_error( [
                    'error' => 'invalid_params'
                ] );
            }

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
            else
            {
                $discussion->deleted_at = null;
                $discussion->save();
            }

            return $this->_success( new DiscussionItemResource($discussion) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function searchByUser(\Viauco\Messenger\Requests\DiscussionSearchByUser $request)
    {
        try
        {
            $userClass = config('messenger.users.model');

            $user = $userClass::findOrFail( $request->user_id );
            $discussions = Discussion::notDeleted()->forUser($user)->withParticipations()->orderBy('updated_at', 'DESC')->get();

            return $this->_success( DiscussionItemResource::collection( $discussions )  );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function discussionTrash($discussionId)
    {
        try
        {
            $discussion = Discussion::findOrFail($discussionId);
            $record = new DiscussionItemResource( $discussion );
            $discussion->delete();
            return $this->_success( new DiscussionItemResource( $record ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function discussionRestore($discussionId)
    {
        try
        {
            $discussion = Discussion::findOrFail($discussionId);
            $record = new DiscussionItemResource( $discussion );
            $discussion->delete();
            return $this->_success( new DiscussionItemResource( $record ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }
}
