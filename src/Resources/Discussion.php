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
        $participations = $this->participations;

        $user = auth()->user();
        $author = $this->author;
        return [
            'id'            => $this->id,
            'subject'       => $this->subject,
            'members'       => Participation::collection($participations),
            'author'        => isset($author) ? new User( $author ) : null,
            'latestMessage' => new LastMessage( $this->latestMessage ),
            'isGroup'       => count( $participations ) > 2 ? true : false,
            'unRead'        => null != $user ? $this->isUnread($user) : false,
            'createdAt'     => $this->created_at,
            'updatedAt'     => $this->updated_at,
        ];
    }
}
