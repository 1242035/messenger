<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Discussion;
use Viauco\Messenger\Resources\Discussion as DiscussionItemResource;
use Viauco\Messenger\Resources\Participation as ParticipationItemResource;
use Viauco\Messenger\Resources\ParticipationCollection;

class ParticipationController extends Controller
{
    public function participationGet($discussionId)
    {
        try
        {
            $params = request()->all();
            
            if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.messages.piginate.limit'); }

            $discussions = Discussion::notDeleted()->findOrFail($discussionId);
            
            $participations = $discussions->participations()->notDeleted()->paginate($params['per_page']);
            
            return $this->_success( ( new ParticipationCollection( $participations ) ) );
            
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }
    
    public function participationPost($discussionId, $memberId)
    {
        try
        {
            $userClass = config('messenger.users.model');
            
            $user = $userClass::findOrFail($memberId);

            $discussion = Discussion::findOrFail($discussionId);

            $discussion->addParticipant($user);

            event( new \Viauco\Messenger\Events\ParticipationAdd( request()->all(), $discussion, $user ) );

            return $this->_success( new DiscussionItemResource( $discussion ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }

    public function participationDelete($discussionId, $memberId)
    {
        try
        {
            $userClass = config('messenger.users.model');
            
            $user = $userClass::findOrFail($memberId);

            $discussion = Discussion::findOrFail($discussionId);

            $discussion->removeParticipant($user);

            event( new \Viauco\Messenger\Events\ParticipationRemove( request()->all(), $discussion, $user ) );

            return $this->_success( new DiscussionItemResource( $discussion ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }
}