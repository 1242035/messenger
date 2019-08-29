<?php
namespace Viauco\Messenger\Socket\Channels;

//use Illuminate\Support\Arr;
use Illuminate\Support\Str;
//use Ratchet\ConnectionInterface;

class ChannelManager extends \BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManagers\ArrayChannelManager
{

    protected function determineChannelClass(string $channelName): string
    {
        logger()->info('determineChannelClass: '. $channelName);
        if (Str::startsWith($channelName, 'private-')) {
            return PrivateChannel::class;
        }
        if (Str::startsWith($channelName, 'presence-')) {
            return PresenceChannel::class;
        }
        return Channel::class;
    }
    
}