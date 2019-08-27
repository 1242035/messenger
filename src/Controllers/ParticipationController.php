<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Participation;
use Viauco\Messenger\Resources\Participation as ParticipationItemResource;

class ParticipationController extends Controller
{
    /* SECTION discussion */
    public function participationPost($discussionId, $memberId)
    {
        try
        {
            $userClass = config('messenger.users.model');
            
            $user = $userClass::findOrFail($memberId);

            $discussions = Discussion::findOrFail($discussionId);

            $discussions->addParticipant($user);

            return $this->_success( new DiscussionItemResource( $discussions ) );
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

            $discussions = Discussion::findOrFail($discussionId);

            $discussions->removeParticipant($user);

            return $this->_success( new DiscussionItemResource( $discussions ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );

            return $this->_error($e);
        }
    }
}