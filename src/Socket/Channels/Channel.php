<?php
namespace Viauco\Messenger\Socket\Channels;

use stdClass;
use Ratchet\ConnectionInterface;

class Channel extends \BeyondCode\LaravelWebSockets\WebSockets\Channels\Channel
{
    public function subscribe(ConnectionInterface $connection, stdClass $payload)
    {
        parent::unsubscribe($connection);
        event( new \Viauco\Messenger\Events\Socket\ChannelSubscribe($connection, $payload) );
    }

    public function unsubscribe(ConnectionInterface $connection)
    {
        parent::unsubscribe($connection);
        event( new \Viauco\Messenger\Events\Socket\ChannelUnsubscribe($connection) );
    }
}