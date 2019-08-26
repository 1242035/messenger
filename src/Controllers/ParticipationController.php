<?php
namespace Viauco\Messenger\Controllers;

class ParticipationController extends Controller
{
    public function index()
    {
        return $this->_success([
            'id' => 0,
            'name' => 'Participation test'
        ]);
    }
}