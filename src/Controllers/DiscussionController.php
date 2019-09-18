<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Discussion;
use Viauco\Messenger\Resources\Discussion as DiscussionItemResource;
use Viauco\Messenger\Resources\DiscussionCollection;

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
            if( ! isset( $params['page'] ) ){ $params['page'] = 1; } else { $params['page'] = (int)$params['page']; }
            $discussions = Discussion::onlyTrashed()
                            ->orderBy('updated_at','DESC')
                            ->simplePaginate((int)$params['per_page']);

            return $this->_success( new DiscussionCollection( $discussions ) );
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
                $arrMemberName = [];

                $discussion = Discussion::create([
                    'ids' => $key
                ]);

                $discussion->participable_id = request()->user()->id;

                $discussion->participable_type = request()->user()->getMorphClass();

                $discussion->subject = $key;

                $userClass = config('messenger.users.model');

                $users = $userClass::whereIn(( new $userClass )->getKeyName(), $ids )->get();
                foreach($users as $user){
                    $arrMemberName[] = $user->fullName;
                }

                $discussion->addParticipants($users);

                if( count( $arrMemberName ) > 0  ) {
                    $discussion->subject = implode(', ', $arrMemberName);
                }
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
            $params = request()->all();

            if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.discussions.piginate.limit'); }
            if( ! isset( $params['page'] ) ){ $params['page'] = 1; } else { $params['page'] = (int)$params['page']; }

            $userClass = config('messenger.users.model');

            $user = $userClass::findOrFail( $request->user_id );
            $discussions = Discussion::
                notDeleted()
                ->forUser($user)
                ->orderBy('updated_at','DESC')
                ->simplePaginate((int)$params['per_page']);
            
            return $this->_success( new DiscussionCollection( $discussions )  );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function searchTrashByUser(\Viauco\Messenger\Requests\DiscussionSearchByUser $request)
    {
        try
        {
            $params = request()->all();

            if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.discussions.piginate.limit'); }
            if( ! isset( $params['page'] ) ){ $params['page'] = 1; } else { $params['page'] = (int)$params['page']; }

            $userClass = config('messenger.users.model');

            $user = $userClass::findOrFail( $request->user_id );
            $discussions = Discussion::onlyTrashed()
                ->forUser($user)
                ->orderBy('updated_at','DESC')
                ->simplePaginate((int)$params['per_page']);

            return $this->_success( new DiscussionCollection( $discussions )  );
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
            $discussion->messages()->delete();
            $discussion->participations()->delete();
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
            $discussion->messages()->restore();
            $discussion->participations()->restore();
            $discussion->restore();
            return $this->_success( new DiscussionItemResource( $record ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function forceDelete($discussionId)
    {
        try
        {
            $discussion = Discussion::findOrFail($discussionId);
            if( $discussion->author->id != auth()->user()->id ) {
                return $this->_permissionDeny();
            }
            $record = new DiscussionItemResource( $discussion );
            $discussion->messages()->forceDelete();
            $discussion->participations()->forceDelete();
            $discussion->forceDelete();
            return $this->_success( new DiscussionItemResource( $record ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function markAsRead($discussionId)
    {
        try
        {
            $discussion = Discussion::findOrFail($discussionId);
            $discussion->markAsRead(auth()->user());
            return $this->_success( new DiscussionItemResource( $discussion ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }
}
