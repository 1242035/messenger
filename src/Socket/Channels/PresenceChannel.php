<?php
namespace Viauco\Messenger\Socket\Channels;

use stdClass;
use Ratchet\ConnectionInterface;

class PresenceChannel extends \BeyondCode\LaravelWebSockets\WebSockets\Channels\PresenceChannel
{
    public function subscribe(ConnectionInterface $connection, stdClass $payload)
    {
        logger()->info('PresenceChannel: '. json_encode( $connection ) );
        parent::subscribe($connection, $payload);
        event( new \Viauco\Messenger\Events\Socket\PresenceSubscribe($connection, $payload) );
    }

    public function unsubscribe(ConnectionInterface $connection)
    {
        parent::unsubscribe($connection);
        event( new \Viauco\Messenger\Events\Socket\PresenceUnsubscribe($connection) );
    }
}