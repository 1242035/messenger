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
            'id' => $this->_id,
            'user' => new User($this->participable),
            'discussion_id' => $this->discussion_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
