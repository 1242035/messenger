<?php
namespace Viauco\Messenger\Socket;

class StatisticsEntry extends \Viauco\Messenger\Models\Model
{
    protected $collection = 'websockets_statistics_entries';

    protected $connection = 'mongodb';
    
}