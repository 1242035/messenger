<?php

namespace Viauco\Messenger\Resources;

class Message extends Item
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
            'id'         => $this->_id,
            'body'       => $this->body,
            'type'       => $this->type,
            'attachments'=> Attachable::collection( $this->attachments ),
            'isRead'    => false,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'author'     => new User( $this->author ),
        ];
    }
}
