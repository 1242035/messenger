<?php

namespace Viauco\Messenger\Controllers;

class MessageController extends Controller
{
    public function index()
    {
        return $this->_success([
            'id' => 0,
            'name' => 'message test'
        ]);
    }

    public function addMessageToDiscusstion($messageId, $discussionId)
    {
        
    }
}