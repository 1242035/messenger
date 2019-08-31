<?php
namespace Viauco\Messenger\Listeners;

use Viauco\Messenger\Events\Socket\PresenceUnsubscribe;
use Viauco\Messenger\Models\Discussion;

class PresenceUnsubscribeListener extends Base
{

    /**
     * Handle the event.
     *
     * @param  Base  $event
     * @return void
     */
    public function handle(PresenceUnsubscribe $event)
    {
        logger()->info('PresenceUnsubscribeListener start');
        
        $connection = $event->connection;
        $payload    = $event->request;

        if( isset( $connection ) && isset( $payload ) )
        {
            logger()->error('PresenceUnsubscribeListener info:' . $payload->channel_data->user_info->discussion_id);

            if( isset( $payload->channel_data->user_info->discussion_id ) && isset( $payload->channel_data->user_id ) )
            {
                $discussionId = $payload->channel_data->user_info->discussion_id;
                $userId       = $payload->channel_data->user_id;
                logger()->error('PresenceUnsubscribeListener info:' . $discussionId . ' => ' . $userId);
                try 
                {
                    $discussion = Discussion::notDeleted()->findOrFail( $discussionId );
                    $participations = $discussion->participations;
                    foreach($participations as $participation)
                    {
                        if( $participation->participable->id == $userId )
                        {
                            logger()->error('PresenceUnsubscribeListener participation', ['exception' => $participation]);

                            $information = $participation->information;
                            if( ! isset( $information ) ) 
                            {
                                $information = new \Viauco\Messenger\Models\Information();
                                $information->participation_id = $participation->_id;
                            }
                            $information->last_active = now();
                            $information->save();
                            break;
                        }
                    }
                }
                catch(\Exception $e)
                {
                    logger()->error('PresenceUnsubscribeListener error', ['exception' => $e]);
                }
            }
        }

        logger()->info('PresenceUnsubscribeListener end');
    }
}
