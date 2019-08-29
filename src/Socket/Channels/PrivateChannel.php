<?php
namespace Viauco\Messenger\Socket\Channels;

use stdClass;
use Ratchet\ConnectionInterface;

class PrivateChannel extends \BeyondCode\LaravelWebSockets\WebSockets\Channels\PrivateChannel
{
    public function subscribe(ConnectionInterface $connection, stdClass $payload)
    {
        parent::subscribe($connection, $payload);
        event( new \Viauco\Messenger\Events\Socket\PrivateSubscribe($connection, $payload) );
    }

    public function unsubscribe(ConnectionInterface $connection)
    {
        parent::unsubscribe($connection);
        event( new \Viauco\Messenger\Events\Socket\PrivateUnsubscribe($connection) );
    }
}