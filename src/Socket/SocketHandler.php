<?php
namespace Viauco\Messenger\Socket;

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;

class SocketHandler extends \BeyondCode\LaravelWebSockets\WebSockets\WebSocketHandler
{
    public function onOpen(ConnectionInterface $connection)
    {
        parent::onOpen($connection);
        logger()->debug('SocketHandler onOpen');
    }
    
    public function onClose(ConnectionInterface $connection)
    {
        parent::onClose($connection);
        logger()->debug('SocketHandler onClose');
    }

    public function onError(ConnectionInterface $connection, \Exception $e)
    {
        parent::onError($connection, $e);
        logger()->debug('SocketHandler onError');
    }

    public function onMessage(ConnectionInterface $connection, MessageInterface $msg)
    {
        parent::onMessage($connection, $msg);
        logger()->debug('SocketHandler onMessage: '. json_encode( $msg ) );
    }
}