<?php
namespace Viauco\Messenger\Events;

class DiscussionCreate extends Base
{
    public $request;

    public $discussion;

    public function __construct($request, $discussion)
    {
        $this->request       = $request;
        $this->discussion    = $discussion;
    }
}
