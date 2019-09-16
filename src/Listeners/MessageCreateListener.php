<?php
namespace Viauco\Messenger\Listeners;

use Viauco\Messenger\Events\MessageCreate;

class MessageCreateListener extends Base
{

    /**
     * Handle the event.
     *
     * @param  Base  $event
     * @return void
     */
    public function handle(MessageCreate $event)
    {
        //logger()->info('MessageCreateListener start');
        $message = $event->message;

        if( isset( $message ) )
        {
            //add last message to disccusion
            $discussionId = $event->discussionId;

            $discussion = \Viauco\Messenger\Models\Discussion::findOrFail($discussionId);

            logger()->info('MessageCreateListener $discussion: ' .$discussion->id);

            if( isset( $discussion->id ) )
            {
                //logger()->info('MessageCreateListener message: ' .json_encode($message));
                //add last message to discussion member

                $discussion->update([
                    'last_message_id' => $message->id
                ]);

                $participations = $discussion->participations;

                if ( isset($participations) && count($participations) > 0 )
                {
                    foreach ($participations as $participation)
                    {
                        $participation->last_message_id = $message->id;
                        $participation->save();
                        //push broadcast to member channel
                        event(new \Viauco\Messenger\Events\MessageCreateToMember($message, $participation->participable->id));
                    }
                }

                $notify = new \Viauco\Messenger\Notifications\Message($event);

                $message->notify($notify);
            }
        }
        //logger()->info('MessageCreateListener end');
    }
}
