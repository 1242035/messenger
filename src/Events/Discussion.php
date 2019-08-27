<?php
namespace Viauco\Messenger\Events;

class Discussion extends Base
{
    public $request;

    public $discussion;

    public function __construct($request, $discussion)
    {
        $this->request       = $request;
        $this->discussion    = $discussion;
    }
}
