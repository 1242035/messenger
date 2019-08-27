<?php
namespace Viauco\Messenger\Events;

class Participation extends Base
{
    public $request;

    public $participation;

    public $discussion;

    public function __construct($request, $discussion, $participation)
    {
        $this->request          = $request;
        $this->discussion       = $discussion;
        $this->participation    = $participation;
    }
}
