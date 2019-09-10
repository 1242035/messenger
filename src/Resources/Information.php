<?php

namespace Viauco\Messenger\Resources;

class Information extends Item
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
            'lastActive' => $this->last_active,
            'lastMessage' => Message::collection($this->message),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
