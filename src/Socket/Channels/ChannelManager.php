<?php
namespace Viauco\Messenger\Socket\Channels;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Ratchet\ConnectionInterface;

class ChannelManager extends \BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManagers\ArrayChannelManager
{

    public function findOrCreate(string $appId, string $channelName): \BeyondCode\LaravelWebSockets\WebSockets\Channels\Channel
    {
        if (! isset($this->channels[$appId][$channelName])) {
            $channelClass = $this->determineChannelClass($channelName);
            $this->channels[$appId][$channelName] = new $channelClass($channelName);
        }
        return $this->channels[$appId][$channelName];
    }

    
    protected function determineChannelClass(string $channelName): string
    {
        if (Str::startsWith($channelName, 'private-')) {
            return PrivateChannel::class;
        }
        if (Str::startsWith($channelName, 'presence-')) {
            return PresenceChannel::class;
        }
        return Channel::class;
    }
    
}