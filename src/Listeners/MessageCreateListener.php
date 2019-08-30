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
        logger()->info('MessageCreateListener start');
        $message = $event->message;
        if( isset( $message ) )
        {
            logger()->info('MessageCreateListener message: ' .json_encode($message));
            $participations = $message->participations;
            if( isset( $participations ) && count( $participations ) > 0 )
            {
                foreach($participations as $participation)
                {
                    $information = $participation->information;
                    if( ! isset( $information ) ) 
                    {
                        $information = new \Viauco\Messenger\Models\Information();
                        $information->participation_id=$participation->_id;
                        //$information->last_active = \Carbon\Carbon::now();
                    }
                    $information->last_message_id = $message->_id;
                    $information->save();
                }
            }
        }
        logger()->info('MessageCreateListener end');
    }
}
