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
            'id'            => $this->_id,
            'subject'       => $this->subject,
            'members'       => Participation::collection($this->participations),
            'author'        => new User( $this->author ),
            'latestMessage' => new Message( $this->latestMessage ),
            'isGroup'       => count( $this->participations ) > 2 ? true : false,
            'isRead'        => null != auth()->user() ? $this->isUnread(auth()->user()) : false,
            'createdAt'     => $this->created_at,
            'updatedAt'     => $this->updated_at,
        ];
    }
}
