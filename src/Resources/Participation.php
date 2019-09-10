<?php

namespace Viauco\Messenger\Resources;

class Participation extends Item
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->_id,
            'user'          => new User($this->participable),
            'discussionId' => $this->discussion_id,
            'lastOnline'   => $this->last_active,
            'lastMessage'  => new Message($this->message),
            'createdAt'    => $this->created_at,
            'updatedAt'    => $this->updated_at,
        ];
    }
}
