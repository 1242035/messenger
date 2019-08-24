<?php

namespace Viauco\Messenger\Controllers;

class DiscussionController extends Controller
{
    public function index()
    {
        return $this->_success([
            'id' => 0,
            'name' => 'discussion test'
        ]);
    }
}