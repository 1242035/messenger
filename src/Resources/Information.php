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
            'last_active' => $this->last_active,
            'last_message_id' => Message::collection($this->message),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
