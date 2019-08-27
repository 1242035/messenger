<?php

namespace Viauco\Messenger\Resources;

class Discussion extends Item
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
            'subject' => $this->subject,
            'members' => Participation::collection($this->participations),
            //'creator' => new User( $this->creator ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
