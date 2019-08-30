<?php
namespace Viauco\Messenger\Socket\Channels;

use stdClass;
use Ratchet\ConnectionInterface;

class Channel extends \BeyondCode\LaravelWebSockets\WebSockets\Channels\Channel
{
    protected $storage = [];

    /*public function __construct(string $channelName)
    {
        parent::__construct($channelName);
        $this->storage = [];
    }*/

    public function subscribe(ConnectionInterface $connection, stdClass $payload)
    {
        parent::unsubscribe($connection);
        $this->storage[$connection->resourceId] = ['connection' => $connection,'payload' => $payload];
        event( new \Viauco\Messenger\Events\Socket\ChannelSubscribe($connection, $payload) );
    }

    public function unsubscribe(ConnectionInterface $connection)
    {
        parent::unsubscribe($connection);
        $payload = isset($this->storage[$connection->resourceId]['payload']) ? $this->storage[$connection->resourceId]['payload'] : null;
        $this->storage[$connection->resourceId] = null;
        event( new \Viauco\Messenger\Events\Socket\ChannelUnsubscribe($connection, $payload) );
    }
}