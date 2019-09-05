<?php
namespace Viauco\Messenger\Listeners;

use Viauco\Messenger\Events\Socket\PresenceSubscribe;

class PresenceSubscribeListener extends Base
{

    /**
     * Handle the event.
     *
     * @param  Base  $event
     * @return void
     */
    public function handle(PresenceSubscribe $event)
    {
        logger()->error('PresenceSubscribeListener start');

        $connection = $event->connection;
        $payload    = $event->request;

        if( isset( $connection ) && isset( $payload ) )
        {
            try
            {
                $channelData = json_decode($payload->channel_data);

                $connectionInfo = json_decode(json_encode($channelData->user_info) );
                if( isset( $connectionInfo  ) )
                {
                    $discussionId = $connectionInfo->discussion_id;
                    $userId       = $connectionInfo->id;

                    $discussion = Discussion::notDeleted()->findOrFail( $discussionId );
                    $participations = $discussion->participations;
                    foreach($participations as $participation)
                    {
                        if( $participation->participable->id == $userId )
                        {
                            //logger()->error('PresenceUnsubscribeListener participation', ['exception' => $participation]);
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

        logger()->info('PresenceSubscribeListener end');
    }
}
