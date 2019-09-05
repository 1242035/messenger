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
            try
            {
                $channelData = json_decode($payload->channel_data);

                //logger()->error('PresenceUnsubscribeListener channelData type:' . gettype($channelData)  );

                $connectionInfo = json_decode(json_encode($channelData->user_info) );

                //logger()->error('PresenceUnsubscribeListener connectionInfo type:' . gettype($connectionInfo)  );
                if( isset( $connectionInfo  ) )
                {
                    $discussionId = $connectionInfo->discussion_id;
                    $userId       = $connectionInfo->id;
                    //logger()->error('PresenceUnsubscribeListener connectionInfo :' . $discussionId . ' => ' . $userId);

                    $discussion = Discussion::notDeleted()->findOrFail( $discussionId );
                    $participations = $discussion->participations;
                    foreach($participations as $participation)
                    {
                        if( $participation->participable->id == $userId )
                        {
                            logger()->error('PresenceUnsubscribeListener participation', ['exception' => $participation]);
                            $participation->last_active = now();
                            $participation->save();
                            break;
                        }
                    }

                }
            }
            catch(\Exception $e)
            {
                logger()->error('PresenceUnsubscribeListener error: ', ['exception' => $e]);
            }
        }

        logger()->info('PresenceUnsubscribeListener end');
    }
}
