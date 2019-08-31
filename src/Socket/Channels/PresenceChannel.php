<?php
namespace Viauco\Messenger\Socket\Channels;

use stdClass;
use Ratchet\ConnectionInterface;

class PresenceChannel extends \BeyondCode\LaravelWebSockets\WebSockets\Channels\PresenceChannel
{
    protected $storage = [];

    public function subscribe(ConnectionInterface $connection, stdClass $payload)
    {
        parent::subscribe($connection, $payload);
        logger()->info('PresenceChannel: '. json_encode($connection->resourceId) );
        $this->storage[$connection->resourceId] = ['connection' => $connection,'payload' => $payload];
        event( new \Viauco\Messenger\Events\Socket\PresenceSubscribe($connection->resourceId, $payload) );
        logger()->info('PresenceChannel: '. json_encode($this->storage) );
    }

    public function unsubscribe(ConnectionInterface $connection)
    {
        parent::unsubscribe($connection);
        $payload = isset($this->storage[$connection->resourceId]['payload']) ? $this->storage[$connection->resourceId]['payload'] : null;
        $this->storage[$connection->resourceId] = null;
        event( new \Viauco\Messenger\Events\Socket\PresenceUnsubscribe($connection->resourceId, $payload) );
    }
}